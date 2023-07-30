<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OtherPaymentType;
use App\Models\OtherPaymentSubType;
use App\Models\BankAccount;
use App\Models\OtherPaymentVoucher;
use App\Models\Transaction;
use App\Models\TransactionReport;
use App\Models\ProductDistributeToBranch;
use App\Models\StockProduct;
use App\Models\StockProductDetail;
use App\Models\AgencyLedger;
use Validator;
use Response;
use Session;
use Auth;
use DB;

use App\Exports\PaymentVoucherExport;
use Maatwebsite\Excel\Facades\Excel;

class DistributionReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata']= ProductDistributeToBranch::all();
        return view('stockManagement.distributionReport', $data);
    }
    
    public function branchDistribution()
    {
        $data['alldata']= ProductDistributeToBranch::all();
        return view('amenment.distributionReportAmendment', $data);
    }
    
    public function branchDistributionFilter(Request $request)
    {
        if ($request->start_date !="" && $request->end_date !="") {
            $data['alldata']= ProductDistributeToBranch::whereBetween('date', [$request->start_date, $request->end_date])->paginate(250);
            $data['start_date']= $request->start_date;
            $data['end_date']= $request->end_date;
            return view('amenment.distributionReportAmendment', $data);
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
        DB::beginTransaction();
        try{
            $bug=0;
            $info= ProductDistributeToBranch::where('tok', $id)->first();
            
            // update main stock
            $update = StockProduct::where([['product_id',$info->product_id],['branch_id','0']])->increment('quantity',$info->quantity);
            
            $delete = StockProduct::where([['branch_id', $info->branch_id],['product_id', $info->product_id]])->decrement('quantity',$info->quantity);
            $delete = StockProductDetail::where('tok', $id)->delete();
            $delete= AgencyLedger::where('tok', $id)->delete();
            $delete = ProductDistributeToBranch::where('tok', $id)->delete();
            
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
            //return $e->getMessage();
        }

        if($bug==0){
            Session::flash('flash_message','Distribution Successfully Deleted !');
            return redirect()->back()->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
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
