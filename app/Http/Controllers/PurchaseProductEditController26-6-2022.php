<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductPurchase;
use App\Models\ProductPurchaseDetails;
use App\Models\SupplierLedger;
use App\Models\Transaction;
use App\Models\TransactionReport;
use App\Models\Product;
use Validator;
use Response;
use Session;
use Auth;
use DB;

class PurchaseProductEditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata']= ProductPurchase::orderBy('id', 'DESC')->get();
        return view('edit.purchaseProductEditList', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //die('ok');
        //echo $id;
        $data['alldata']= ProductPurchaseDetails::where('tok', $id)->get();
        $data['singledata']= ProductPurchase::where('tok', $id)->first();
        $data['allproduct']= Product::where('status', '1')->get();
        return view('edit.purchaseProductEditForm', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {        
        //$input = $request->all();
        DB::beginTransaction();
        try{
            $bug=0;
            // Update bank balance
            $purchaseDetails = DB::table('product_purchase')->where('tok', $id)->first();
            $difference = ($purchaseDetails->paid_amount)-($request->paid_amount);

            $update=DB::table('bank_account')->where('id', $purchaseDetails->payment_method)->increment('balance', $difference);

            $update=ProductPurchase::where('tok', $id)->update(array('sub_total' => $request->sub_total, 'discount' => $request->discount, 'paid_amount' => $request->paid_amount));

            $update=SupplierLedger::where('tok', $id)->where('reason', '=', 'purchase')->update(array('amount' => $request->sub_total));
            $update=SupplierLedger::where('tok', $id)->where('reason', '=', 'payment')->update(array('amount' => $request->paid_amount));

            // Update transaction tbl
            if ($purchaseDetails->paid_amount > 0) {
                $update=Transaction::where('tok', $id)->update(array('amount' => $request->paid_amount));
                $update=TransactionReport::where('tok', $id)->update(array('amount' => $request->paid_amount));
            }

            foreach ($request->multidata as $value) {
                // update stock product
                $data = ProductPurchaseDetails::where(['tok'=>$id, 'id'=>$value['id'], 'product_id'=>$value['product_id']])->first();
                if ($value['quantity']>$data->quantity) {
                    $restQnty = ($value['quantity']-$data->quantity);
                    $update=DB::table('stock_product')->where('product_id', $value['product_id'])->increment('quantity', $restQnty);
                }elseif ($value['quantity']<$data->quantity) {
                    $restQnty = ($data->quantity-$value['quantity']);
                    $update=DB::table('stock_product')->where('product_id', $value['product_id'])->decrement('quantity', $restQnty);
                }

                // update purchase details
                $matchThese = ['tok' => $id, 'id' => $value['id']];
                $update=ProductPurchaseDetails::where($matchThese)->update(array('quantity' => $value['quantity'], 'unit_price' => $value['unit_price']));
            }
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Purchase Edition Successfully Done !');
            return redirect()->back()->with('status_color','warning');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try{
            $bug=0;
            // Getting Payment Method for update bank balance
            $payment = DB::table('product_purchase')->where('tok', $id)->first();
            
            $action = ProductPurchase::where('tok',$id)->delete();
            // Getting quantity for stock update
            $amount = DB::table('product_purchase_details')->where('tok', $id)->get();
            foreach ($amount as $value) {
                $update=DB::table('stock_product')->where('product_id', $value->product_id)->decrement('quantity', $value->quantity);
            }

            $action = ProductPurchaseDetails::where('tok',$id)->delete();
            $action = SupplierLedger::where('tok',$id)->delete();

            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Purchase Successfully Deleted !');
            return redirect()->back()->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    public function filter(Request $request)
    {
        if ($request->search && $request->start_date !="" && $request->end_date !="") {
            $data['alldata']= ProductPurchase::whereBetween('purchase_date', [$request->start_date, $request->end_date])->get();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('edit.purchaseProductEditList', $data);
        }
    }
}
