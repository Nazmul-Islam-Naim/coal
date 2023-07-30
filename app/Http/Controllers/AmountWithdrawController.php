<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankAccount;
use App\Models\TransactionReport;
use App\Models\Transaction;
use App\Models\Chequebook;
use App\Models\Chequeno;
use Validator;
use Response;
use Session;
use Auth;
use DB;

class AmountWithdrawController extends Controller
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
            'check_book' => 'required',
            'check_no' => 'required',
            'withdraw_amount' => 'required',
            'transaction_date' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
        
        $input = $request->all();
        $input['status'] = 1;
        $input['created_by'] = Auth::id();

        $check_book = $request->check_book;
        $check_no = $request->check_no;
        $tok = date('Ymdhis');

        // getting check book
        $checkBook = DB::table('cheque_book')->where('id', $check_book)->first();
        // getting check no
        $checkNo = DB::table('cheque_no')->where('id', $check_no)->first();

        DB::beginTransaction();
        try{
            $bug=0;

            $decrement=DB::table('bank_account')->where('id', $request->bank_id)->decrement('balance', $request->withdraw_amount);

            $updateStatus = Chequeno::where('id', $check_no)->update(array('status' => '0', 'tok' => $tok));

            $insertIntoReportForWithdraw = TransactionReport::create([
                'bank_id'=>$request->bank_id,
                'transaction_date'=>$request->transaction_date,
                'reason'=>'withdraw ('.$checkBook->name.'-'.$checkNo->cheque_no.')',
                'amount'=>$request->withdraw_amount,
                'note'=>$request->note,
                'tok'=>$tok,
                'status'=>'1',
                'created_by'=>Auth::id()
            ]);

            $insertIntoTransactionForWithdraw = Transaction::create([
                'date'=>$request->transaction_date,
                'reason'=>'Payment(withdraw)',
                'amount'=>$request->withdraw_amount,
                'tok'=>$tok,
                'status'=>'1',
                'created_by'=>Auth::id()
            ]);
            
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Withdraw Successfully Done !');
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

    public function amountWithdraw(Request $request, $id)
    {
        $data['alldata'] = BankAccount::where('id', $id)->first();
        $data['allbank'] = BankAccount::where('id','!=',$id)->get();
        $data['allchequebook'] = Chequebook::where('bank',$id)->get();
        return view('accounts.amountWithdraw', $data);
    }

    public function findChequeNoWithChequeBookId(Request $request)
    {
        $chequeno = Chequeno::select('cheque_no', 'id')->where('cheque_book',$request->id)->where('status', '!=', '0')->get();
        return Response::json($chequeno);
        die;
    }
}
