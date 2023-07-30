<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankAccount;
use App\Models\TransactionReport;
use App\Models\Transaction;
use Validator;
use Response;
use Session;
use Auth;
use DB;

class AmountTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'transfer_to' => 'required',
            'transfer_amount' => 'required',
            'transaction_date' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
        
        $input = $request->all();
        $input['status'] = 1;
        $input['created_by'] = Auth::id();

        DB::beginTransaction();
        try{
            $bug=0;

            $decrement=DB::table('bank_account')->where('id', $request->bank_id)->decrement('balance', $request->transfer_amount);
            $increment=DB::table('bank_account')->where('id', $request->transfer_to)->increment('balance', $request->transfer_amount);

            $insertIntoReportForDeposit = TransactionReport::create([
                'bank_id'=>$request->transfer_to,
                'transaction_date'=>$request->transaction_date,
                'reason'=>'deposit(trans)',
                'amount'=>$request->transfer_amount,
                'note'=>$request->note,
                'tok'=>date('Ymdhis'),
                'status'=>'1',
                'created_by'=>Auth::id()
            ]);

            $insertIntoReportForTransfer = TransactionReport::create([
                'bank_id'=>$request->bank_id,
                'transaction_date'=>$request->transaction_date,
                'reason'=>'transfer',
                'amount'=>$request->transfer_amount,
                'note'=>$request->note,
                'tok'=>date('Ymdhis'),
                'status'=>'1',
                'created_by'=>Auth::id()
            ]);

            $insertIntoTransactionForDeposit = Transaction::create([
                'date'=>$request->transaction_date,
                'reason'=>'Receive(trans)',
                'amount'=>$request->transfer_amount,
                'tok'=>date('Ymdhis'),
                'status'=>'1',
                'created_by'=>Auth::id()
            ]);

            $insertIntoTransactionForTransfer = Transaction::create([
                'date'=>$request->transaction_date,
                'reason'=>'Payment(trans)',
                'amount'=>$request->transfer_amount,
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
            Session::flash('flash_message','Transfer Successfully Added !');
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

    public function amountTransfer(Request $request, $id)
    {
        $data['alldata'] = BankAccount::where('id', $id)->first();
        $data['allbank'] = BankAccount::where('id','!=',$id)->get();
        return view('accounts.amountTransfer', $data);
    }
}
