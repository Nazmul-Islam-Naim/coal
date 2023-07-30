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

class BankTransferAmenmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata']= TransactionReport::where('reason', 'LIKE', '%transfer%')->orderBy('id', 'DESC')->paginate(250);
        return view('amenment.bankTransferAmenment', $data);
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
            // Getting amount
            $deposit = DB::table('transation_report')->where('tok', $id)->where('reason', 'LIKE', '%deposit(trans)%')->count();
            if ($deposit == 1) {
                $value = DB::table('transation_report')->where('tok', $id)->where('reason', 'LIKE', '%deposit(trans)%')->first();
                $action = DB::table('bank_account')->where('id', $value->bank_id)->decrement('balance', $value->amount);
            }

            $transfer = DB::table('transation_report')->where('tok', $id)->where('reason', 'LIKE', '%transfer%')->count();
            if ($deposit == 1) {
                $value = DB::table('transation_report')->where('tok', $id)->where('reason', 'LIKE', '%transfer%')->first();
                $action = DB::table('bank_account')->where('id', $value->bank_id)->increment('balance', $value->amount);
            }
            $action = TransactionReport::where('tok', $id)->delete();
            $action = Transaction::where('tok',$id)->delete();
            
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Bank Deposit Successfully Deleted !');
            return redirect()->back()->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    public function filter(Request $request)
    {
        if ($request->search && $request->start_date !="" && $request->end_date !="") {
            $data['alldata']= TransactionReport::where('reason', 'LIKE', '%transfer%')->whereBetween('transaction_date', [$request->start_date, $request->end_date])->orderBy('id', 'DESC')->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('amenment.bankTransferAmenment', $data);
        }else{
            $data['alldata']= TransactionReport::where('reason', 'LIKE', '%transfer%')->orderBy('id', 'DESC')->paginate(250);
            return view('amenment.bankTransferAmenment', $data);
        }
    }
}
