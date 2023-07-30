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
        $data['allproduct']= Product::join('stock_product', 'stock_product.product_id', 'product.id')->where([['stock_product.quantity','>','0'],['stock_product.branch_id', '0']])->select('product.*', 'stock_product.quantity')->get();
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
        /*echo "<pre>";
        print_($request->all());
        die;*/
        DB::beginTransaction();
        try{
            $bug=0;
            $ttlQnty=0;
            $info=ProductPurchase::where('tok', $id)->first();
            // update
            $update=ProductPurchase::where('tok', $id)->update(array('sub_total' => $request->sub_total));
            $update=SupplierLedger::where('tok', $id)->where('reason', '=', 'purchase')->update(array('amount' => $request->sub_total));

            foreach ($request->multidata as $value) {
                $count = ProductPurchaseDetails::where(['tok'=>$id, 'id'=>$value['id'], 'product_id'=>$value['product_id']])->count();
                if($count==1){
                    // update existing purchase product stock
                    $data = ProductPurchaseDetails::where(['tok'=>$id, 'id'=>$value['id'], 'product_id'=>$value['product_id']])->first();
                    if ($value['quantity']>$data->quantity) {
                        $restQnty = ($value['quantity']-$data->quantity);
                        $update=DB::table('stock_product')->where([['branch_id', '0'],['product_id', $value['product_id']]])->decrement('quantity', $restQnty);
                    }elseif ($value['quantity']<$data->quantity) {
                        $restQnty = ($data->quantity-$value['quantity']);
                        $update=DB::table('stock_product')->where([['branch_id', '0'],['product_id', $value['product_id']]])->increment('quantity', $restQnty);
                    }
                    // update purchase details
                    $matchThese = ['tok' => $id, 'id' => $value['id']];
                    $update=ProductPurchaseDetails::where($matchThese)->update(array('quantity' => $value['quantity'], 'unit_price' => $value['unit_price']));
                }else{
                    // update new purchase product stock
                    $update=DB::table('stock_product')->where([['branch_id', '0'],['product_id', $value['product_id']]])->decrement('quantity', $value['quantity']);
                    
                    ProductPurchaseDetails::create([
                        'supplier_id'=>$info->supplier_id,
                        'product_id'=>$value['product_id'],
                        'unit_price'=>$value['unit_price'],
                        'quantity'=>$value['quantity'],
                        'purchase_date'=>$info->purchase_date,
                        'tok'=>$id,
                        'created_by'=>Auth::id(),
                    ]);
                }
                $ttlQnty += $value['quantity'];
            }
            //update qnty
            $update=ProductPurchase::where('tok', $id)->update(array('total_qnty' => $ttlQnty));
            DB::commit();
        }catch(\Exception $e){
            /*$bug=$e->errorInfo[1];
            DB::rollback();*/
            return $e->getMessage();
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
    public function deletePurchaseItem($id, $tok){
        
        DB::beginTransaction();
        try{
            $bug=0;
            $total=0;
            $totalQnty=0;
            // get item info
            $deletedItemInfo = DB::table('product_purchase_details')->where([['tok', $tok],['id', $id]])->first();
            $update=DB::table('stock_product')->where([['product_id', $deletedItemInfo->product_id],['branch_id', '0']])->increment('quantity', $deletedItemInfo->quantity);
            
            // delete
            $delete = DB::table('product_purchase_details')->where([['tok', $tok],['id', $id]])->delete();
            
           
            $totalSql = DB::table('product_purchase_details')->where('tok', $tok)->select('product_purchase_details.*')->get();
            foreach($totalSql as $qnty){
                $total += $qnty->quantity*$qnty->unit_price;
                $totalQnty += $qnty->quantity;
            }
            
            $update=ProductPurchase::where('tok', $tok)->update(array('sub_total' => $total,'total_qnty' => $totalQnty));
            $update=SupplierLedger::where('tok', $tok)->where('reason', '=', 'purchase')->update(array('amount' => $total));
            
            

            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
            //return $e->getMessage();
        }

        if($bug==0){
            Session::flash('flash_message','Purchase Successfully Deleted !');
            return redirect()->back()->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
     
     
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
