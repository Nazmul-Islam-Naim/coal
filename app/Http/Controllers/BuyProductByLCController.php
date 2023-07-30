<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OtherPaymentType;
use App\Models\OtherPaymentSubType;
use App\Models\BankAccount;
use App\Models\OtherPaymentVoucher;
use App\Models\Transaction;
use App\Models\TransactionReport;
use App\Models\lcInfo;
use App\Models\Product;
use App\Models\LcProductDetails;
use App\Models\LCWiseAddProduct;
use App\Models\SupplierLedger;
use Validator;
use Response;
use Session;
use Auth;
use DB;

use App\Exports\PaymentVoucherExport;
use Maatwebsite\Excel\Facades\Excel;

class BuyProductByLCController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata']= lcInfo::all();
        return view('products.buyProductByLC', $data);
    }
    
    public function addLCProduct($id){
        $data['single_data']= lcInfo::find($id);
        $data['allproduct']= LcProductDetails::where('lc_id',$id)->get();
        return view('products.lc_wise_add_product', $data); 
    }
    
    public function singleLcDetail($id){
        $data['single_data']= lcInfo::find($id);
        $data['allproduct']= LCWiseAddProduct::where('lc_id',$id)->get();
        return view('products.single-lc-detail', $data); 
    }
    
    public function completeSingleLC(Request $request)
    {
        /*echo "<pre>";
        print_r($request->all());
        die();*/
        $validator = Validator::make($request->all(), [
            'lc_id' => 'required',
            'supplier_id' => 'required',
            'already_gotproducts_rs_value' => 'required|numeric|gt:0',
            'total_lc_value_rs' => 'required|numeric|gt:0',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
        
        $input = $request->all();

        $input['created_by'] = Auth::id();
        $input['tok'] = date('Ymdhis');
        $input['status'] = 1;

        DB::beginTransaction();
        try{
            $bug=0;
            $insert= SupplierLedger::create([
                'date'=>date('Y-m-d'),
                'supplier_id'=>$request->supplier_id,
                'amount'=>$request->already_gotproducts_rs_value-$request->total_lc_value_rs,
                'reason'=>'bill(lc no - '.$request->lc_no.')',
                'note'=>'',
                'tok'=>date('Ymdhis'),
                'created_by'=>Auth::id()
            ]);
            LCWiseAddProduct::where('lc_id',$request->lc_id)->update(array('status'=>'2'));
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Data Successfully Saved !');
            return redirect()->back()->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
    
    public function saveLCProduct(Request $request)
    {
        /*echo "<pre>";
        print_r($request->all());
        die();*/
        $validator = Validator::make($request->all(), [
            'lc_id' => 'required',
            'truck_no' => 'required',
            'quantity' => 'required|numeric|gt:0',
            'date' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
        
        $input = $request->all();

        $input['created_by'] = Auth::id();
        $input['tok'] = date('Ymdhis');
        $input['status'] = 1;

        DB::beginTransaction();
        try{
            $bug=0;
            $insert= LCWiseAddProduct::create($input);
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Data Successfully Saved !');
            return redirect()->back()->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
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
        $validator = Validator::make($request->all(), [
            'payment_type_id' => 'required',
            'payment_sub_type_id' => 'required',
            'amount' => 'required|numeric|gt:0',
            'payment_for' => 'required',
            'payment_date' => 'required',
            'bank_id' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
        
        $input = $request->all();

        $input['created_by'] = Auth::id();
        $input['tok'] = date('Ymdhis');
        $input['status'] = 1;

        DB::beginTransaction();
        try{
            $bug=0;
            $insert= OtherPaymentVoucher::create($input);

            $update=DB::table('bank_account')->where('id', $request->bank_id)->decrement('balance', $request->amount);

            // get payment type name
            $paymentTypeName=DB::table('other_payment_type')->where('id', $request->payment_type_id)->first();

            $insertIntoTransaction = Transaction::create([
                'date'=>$request->payment_date,
                'reason'=>'Payment(others-'.$paymentTypeName->name.')',
                'amount'=>$request->amount,
                'tok'=> date('Ymdhis'),
                'status'=> '1',
                'created_by'=> Auth::id(),
            ]);

            $insertIntoReportForReceive = TransactionReport::create([
                'bank_id'=>$request->bank_id,
                'transaction_date'=>$request->payment_date,
                'reason'=>'payment(others-'.$paymentTypeName->name.')',
                'amount'=>$request->amount,
                'note'=>$request->note,
                'tok'=>date('Ymdhis'),
                'status'=>'1',
                'created_by'=>Auth::id()
            ]);

            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Payment Voucher Successfully Added !');
            return redirect()->back()->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function findPaymentSubTypeWithType(Request $request)
    {
        $subType = OtherPaymentSubType::where('payment_type_id',$request->id)->get();
        return Response::json($subType);
        die;
    }

    public function report(Request $request)
    {
        $data['alldata']= OtherPaymentVoucher::where('status', '1')->paginate(250);
        $data['alltype']= OtherPaymentType::where('status', '1')->get();
        $data['allbank']= BankAccount::all();
        return view('otherPayment.voucherReport', $data);
    }

    public function filter(Request $request)
    {
        if ($request->start_date !="" && $request->end_date !="") {
            $data['alldata']= OtherPaymentVoucher::whereBetween('payment_date', [$request->start_date, $request->end_date])->paginate(250);
            $data['alltype']= OtherPaymentType::where('status', '1')->get();
            $data['allbank']= BankAccount::all();
            $data['start_date']= $request->start_date;
            $data['end_date']= $request->end_date;
            return view('otherPayment.voucherReport', $data);
        }
    }
    
    public function paymentDetail($id)
    {
        $data['single_data']= OtherPaymentVoucher::where('id', $id)->first();
        return view('otherPayment.paymentDetail', $data);
    }
}
