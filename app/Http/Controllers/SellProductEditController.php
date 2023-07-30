<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductSell;
use App\Models\ProductSellDetails;
use App\Models\CustomerLedger;
use App\Models\Transaction;
use App\Models\TransactionReport;
use App\Models\GiftPoint;
use App\Models\Customer;
use Validator;
use Response;
use Session;
use Auth;
use DB;

class SellProductEditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata']= ProductSell::orderBy('id', 'DESC')->get();
        return view('edit.sellProductEditList', $data);
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
        $branchInfo = ProductSell::where('tok', $id)->first();
        $data['alldata']= ProductSellDetails::join('stock_product', 'stock_product.product_id', '=', 'product_sell_details.product_id')->select('product_sell_details.*', 'stock_product.quantity as stockQnty', 'stock_product.unit_price as stockUnitPrice')->where([['product_sell_details.tok', $id],['stock_product.branch_id',$branchInfo->branch_id]])->get();
        $data['singledata']= ProductSell::where('tok', $id)->first();
        $data['allproduct'] = DB::table('product')
            ->join('stock_product', 'stock_product.product_id', '=', 'product.id')
            ->where('stock_product.quantity', '>', '0')
            ->select('product.*')
            ->get();
        $data['allcustomer'] = Customer::where('status', 1)->get();
        return view('edit.sellProductEditForm', $data);
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
        print_r($request->all());
        die;*/
        DB::beginTransaction();
        try{
            $bug=0;
            $ttlQnty = 0;
            $ttlPurchase = 0;
            foreach ($request->sell_details as $value) {
                // update stock product
                $sellData = ProductSell::where(['tok'=>$id])->first();
                $data = ProductSellDetails::where(['tok'=>$id, 'id'=>$value['id']])->first();
                $count = ProductSellDetails::where(['tok'=>$id, 'id'=>$value['id']])->count();
                if($count == 1){
                    
                    //die($request->branch_id);
                    if ($value['quantity']>$data->quantity) {
                        $restQnty = ($value['quantity']-$data->quantity);
                        $update=DB::table('stock_product')->where([['product_id', $value['product_id']], ['branch_id', $request->branch_id]])->decrement('quantity', $restQnty);
                    }elseif ($value['quantity']<$data->quantity) {
                        $restQnty = ($data->quantity-$value['quantity']);
                        $update=DB::table('stock_product')->where([['product_id', $value['product_id']], ['branch_id', $request->branch_id]])->increment('quantity', $restQnty);
                    }
    
                    // update sell details
                    $matchThese = ['tok' => $id, 'id' => $value['id']];
                    $update=ProductSellDetails::where($matchThese)->update(array('quantity' => $value['quantity'], 'unit_price' => $value['unit_price']));
                }else{
                    $update=DB::table('stock_product')->where([['product_id', $value['product_id']], ['branch_id', $request->branch_id]])->decrement('quantity', $value['quantity']);
                    
                    $input['customer_id'] = $request->customer_id;
                    $input['product_id'] = $value['product_id'];
                    $input['unit_price'] = $value['unit_price'];
                    $input['quantity'] = $value['quantity'];
                    $input['sell_date'] = $sellData->sell_date;
                    $input['tok'] = $id;
                    $input['created_by'] = $sellData->created_by;
                    $insert= ProductSellDetails::create($input);
                } 
                
                //$ttlPurchase += $value['quantity']*$value['purchase_value'];
                $ttlQnty += $value['quantity'];
            }
            
            // checking Duplicate for tbl Transaction
            $checkDuplicate = Transaction::where('tok', $id)->count();
            if($checkDuplicate == 0){
                $insertIntoTransaction = Transaction::create([
                    'date'=>$request->sell_date,
                    'reason'=>'Receive(sell)',
                    'amount'=>$request->paid_amount,
                    'tok'=>$id,
                    'status'=>'1',
                    'created_by'=>Auth::id()
                ]);
            }else{
                // update into transaction table
                $update= Transaction::where('tok', $id)->update(['amount'=>$request->paid_amount, 'date'=>$request->sell_date]);
            }
            
            $info= ProductSell::where('tok', $id)->first();
            // checking Duplicate for tbl Transaction Report
            $checkDuplicate = TransactionReport::where('tok', $id)->count();
            if($checkDuplicate == 0){
                $insertIntoReport = TransactionReport::create([
                    'bank_id'=>$info->payment_method,
                    'transaction_date'=>$request->sell_date,
                    'reason'=>'receive(sell)',
                    'amount'=>$request->paid_amount,
                    'tok'=>$id,
                    'status'=>'1',
                    'created_by'=>Auth::id()
                ]);
            }else{
                // update into transaction report table
                $update= TransactionReport::where('tok', $id)->update(['amount'=>$request->paid_amount, 'transaction_date'=>$request->sell_date]);
            }
            
            // updating bank balance
            // checking data
            if($request->paid_amount>$info->paid_amount){
                $updatedAmnt = $request->paid_amount - $info->paid_amount;
                $update=DB::table('bank_account')->where('id', $info->payment_method)->increment('balance', $updatedAmnt);
            }elseif($request->paid_amount<$info->paid_amount){
                $updatedAmnt = $info->paid_amount - $request->paid_amount;
                $update=DB::table('bank_account')->where('id', $info->payment_method)->decrement('balance', $updatedAmnt);
            }
            $insert= ProductSell::where('tok', $id)->update([
                'sell_date'=>date('Y-m-d', strtotime($request->sell_date)),
                'paid_amount'=>$request->paid_amount,
                'customer_id'=>$request->customer_id,
                'truck_no'=>$request->truck_no,
                'note'=>$request->note,
                'sub_total'=>$request->sub_total,
            ]);
            
            $update= CustomerLedger::where('tok', $id)->where('reason', 'like', '%' . 'sell' . '%')->update([
                    'customer_id'=>$request->customer_id,
                    'date'=>$request->sell_date,
                    'amount'=>$request->sub_total,
                ]);
            // update into customer_ledger table
            $ledgerInfo= CustomerLedger::where('tok', $id)->where('reason', 'like', '%' . 'receive' . '%')->count();
            if($ledgerInfo==1){
                $update= CustomerLedger::where('tok', $id)->where('reason', 'like', '%' . 'receive' . '%')->update([
                    'amount'=>$request->paid_amount,
                    'customer_id'=>$request->customer_id,
                    'date'=>$request->sell_date,
                ]);
            }else{
                $insert= CustomerLedger::create([
                    'date'=>$request->sell_date,
                    'bank_id'=>$info->payment_method,
                    'customer_id'=>$request->customer_id,
                    'amount'=>$request->paid_amount,
                    'reason'=>'receive',
                    'tok'=>$id,
                    'created_by'=>Auth::id()
                ]);
            }
            
            // update gift point table, suppose 100 taka is 1 point
            $achievePoint = $request->sub_total/100;
            $update = GiftPoint::where('tok', $id)->update([
                'achieve_point'=>$achievePoint,
                'customer_id'=>$request->customer_id,
            ]);
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Sell Edition Successfully Done !');
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
            $payment = DB::table('product_sell')->where('tok', $id)->first();
            if ($payment->paid_amount > 0) {
                $update=DB::table('bank_account')->where('id', $payment->bank_id)->decrement('balance', $payment->paid_amount);
                $action = Transaction::where('tok',$id)->delete();
                $action = TransactionReport::where('tok',$id)->delete();
            }

            $action = ProductSell::where('tok',$id)->delete();
            // Getting quantity for stock update
            $amount = DB::table('product_sell_details')->where('tok', $id)->get();
            foreach ($amount as $value) {
                $update=DB::table('stock_product')->where([['product_id', $value->product_id],['branch_id', '!=', '0']])->increment('quantity', $value->quantity);
            }

            $action = ProductSellDetails::where('tok',$id)->delete();
            $action = CustomerLedger::where('tok',$id)->delete();

            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
            //return $e->getMessage();
        }

        if($bug==0){
            Session::flash('flash_message','Sell Successfully Deleted !');
            return redirect()->back()->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    public function filter(Request $request)
    {
        if ($request->search && $request->start_date !="" && $request->end_date !="") {
            $data['alldata']= ProductSell::whereBetween('sell_date', [$request->start_date, $request->end_date])->get();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('edit.sellProductEditList', $data);
        }
    }
    
    public function sellProductDelete($id, $tok)
    {
        $sellInfoDetail = DB::table('product_sell_details')->where([['product_id', $id], ['tok', $tok]])->first();
        $sellInfo = DB::table('product_sell')->where([['tok', $tok]])->first();
        if($sellInfoDetail->quantity == $sellInfo->total_qnty){
            // delete all data
            $action = DB::table('product_sell_details')->where([['product_id', $id], ['tok', $tok]])->delete();
            $action = DB::table('product_sell')->where([['tok', $tok]])->delete();
            $action = DB::table('customer_ledger')->where([['tok', $tok]])->delete();
            $action = DB::table('transaction')->where([['tok', $tok]])->delete();
            $action = DB::table('transation_report')->where([['tok', $tok]])->delete();
                
            // update stock and bank
            $action = DB::table('bank_account')->where([['id', $sellInfo->bank_id]])->decrement('balance', $sellInfo->paid_amount);
            $action = DB::table('stock_product')->where([['product_id', $id]])->increment('quantity', $sellInfoDetail->quantity);
              
            if($action){
                Session::flash('flash_message','Item Successfully Deleted !');
                return redirect('amendment/sell-product-edit')->with('status_color','danger');
            }else{
                Session::flash('flash_message','Something Error Found !');
                return redirect()->back()->with('status_color','danger');
            }
        }else{
            //$action = DB::table('product_sell')->where('tok', $tok)->decrement('total_qnty', $sellInfoDetail->quantity);
            //$action = DB::table('product_sell')->where('tok', $tok)->decrement('total_vat', $sellInfoDetail->vat_amount);
            $action = DB::table('product_sell')->where('tok', $tok)->decrement('sub_total', $sellInfoDetail->quantity*$sellInfoDetail->unit_price);
            $action = DB::table('product_sell')->where('tok', $tok)->decrement('total_qnty', $sellInfoDetail->quantity);
                
            //$ttl = ($sellInfo->grand_total+$sellInfo->discount)-($sellInfoDetail->quantity*$sellInfoDetail->unit_price);
            //$action = DB::table('product_sell')->where('tok', $tok)->update(['grand_total'=>$ttl]);
                
            //delete
            $action = DB::table('product_sell_details')->where([['product_id', $id], ['tok', $tok]])->delete();
            $action = DB::table('stock_product')->where([['product_id', $id],['branch_id',$sellInfo->branch_id]])->increment('quantity', $sellInfoDetail->quantity);
            $action = DB::table('customer_ledger')->where([['tok', $tok], ['customer_id', $sellInfo->customer_id]])->decrement('amount', $sellInfoDetail->quantity*$sellInfoDetail->unit_price);
            if($action){
                Session::flash('flash_message','Item Successfully Deleted !');
                return redirect()->back()->with('status_color','danger');
            }else{
                Session::flash('flash_message','Something Error Found !');
                return redirect()->back()->with('status_color','danger');
            }
        }
    }
}
