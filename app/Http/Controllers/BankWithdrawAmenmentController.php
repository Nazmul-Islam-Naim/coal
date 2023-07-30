<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionReport;
use Validator;
use Response;
use Session;
use Auth;
use DB;

class BankWithdrawAmenmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata']= TransactionReport::where('reason', 'LIKE', '%withdraw%')->orderBy('id', 'DESC')->paginate(250);
        return view('amenment.bankWithdrawAmenment', $data);
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
        DB::beginTransaction();
        try{
            $bug=0;
            $info = TransactionReport::where('tok', $id)->first();
            
            if($info->amount > $request->amount){
                $amount = $info->amount - $request->amount;
                $action = DB::table('bank_account')->where('id', $info->bank_id)->decrement('balance', $amount);
            }elseif($request->amount > $info->amount){
                $amount = $request->amount - $info->amount;
                $action = DB::table('bank_account')->where('id', $info->bank_id)->increment('balance', $amount);
            }
            
            $action = DB::table('transaction')->where('tok', $id)->update(['amount'=>$request->amount]);
            $action = DB::table('transation_report')->where('tok', $id)->update(['amount'=>$request->amount]);
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Data Successfully Updated !');
            return redirect()->back()->with('status_color','success');
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
            // Getting amount
            $payment = DB::table('transation_report')->where('tok', $id)->first();
            $action = DB::table('bank_account')->where('id', $payment->bank_id)->increment('balance', $payment->amount);
            $action = TransactionReport::where('tok', $id)->delete();
            $action = Transaction::where('tok',$id)->delete();

            $update = DB::table('cheque_no')->where('tok', $id)->update(array('status'=>'1'));
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Bank Withdraw Successfully Deleted !');
            return redirect()->back()->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    public function filter(Request $request)
    {
        if ($request->search && $request->start_date !="" && $request->end_date !="") {
            $data['alldata']= TransactionReport::where('reason', 'LIKE', '%withdraw%')->whereBetween('transaction_date', [$request->start_date, $request->end_date])->orderBy('id', 'DESC')->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('amenment.bankWithdrawAmenment', $data);
        }else{
            $data['alldata']= TransactionReport::where('reason', 'LIKE', '%withdraw%')->orderBy('id', 'DESC')->paginate(250);
            return view('amenment.bankWithdrawAmenment', $data);
        }
    }
}
