<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankAccount;
use App\Models\TransactionReport;
use App\Models\AccountType;
use Validator;
use Response;
use Session;
use Auth;
use DB;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata']= BankAccount::paginate(15);
        $data['allaccounttype']= AccountType::all();
        return view('accounts.bankAccount', $data);
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
            'bank_name' => 'required',
            'account_name' => 'required',
            'account_no' => 'required',
            'account_type' => 'required',
            'bank_branch' => 'required',
            'opening_balance' => 'required|numeric|gt:0',
            'opening_date' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }

        $input = $request->all();
        $input['status'] = 1;
        $input['balance'] = $request->opening_balance;
        $input['created_by'] = Auth::id();

        DB::beginTransaction();
        try{
            $bug=0;
            $insert= BankAccount::create($input);
            
            $bank_id = $insert->id;
            $tok = date('Ymdhis');
            $inserts= TransactionReport::create([
                'bank_id'=>$bank_id,
                'transaction_date'=>$request->opening_date,
                'amount'=>$request->opening_balance,
                'reason'=>'Opening Balance',
                'tok'=>$tok,
                'status'=>'1',
                'created_by'=>Auth::id(),
            ]);

            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Bank Account Successfully Added !');
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
        $data=BankAccount::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'bank_name' => 'required',
            'account_name' => 'required',
            'account_no' => 'required',
            'account_type' => 'required',
            'bank_branch' => 'required',
            'new_opening_balance' => 'required|numeric|gt:0',
            'opening_date' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }

        $input = $request->all();
        
        $bankBalance = $request->bank_balance;
        $oldOpeningBalance = $request->old_opening_balance;
        $newOpeningBalance = $request->new_opening_balance;

        $restBankBalance = $bankBalance - $oldOpeningBalance;

        $finalBankBalance = $restBankBalance+$newOpeningBalance;
        $input['balance'] = $finalBankBalance;

        DB::beginTransaction();
        try{
            $bug=0;
            $data->update($input);

            $updateBalance = TransactionReport::where('bank_id', $id)->where('reason', 'LIKE', '%' . 'Opening Balance' . '%')->update(array('amount' => $newOpeningBalance));
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Bank Account Successfully Updated !');
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
        //
    }

    public function showBankReport($id)
    {
        $data['singledata'] = BankAccount::where('id', '=', $id)->first();
        $data['alldata'] = TransactionReport::where('bank_id', '=', $id)->orderBy('transaction_date', 'ASC')->get();
        return view('accounts.bankReport', $data);
    }

    public function showBankReportFilter(Request $request, $id)
    {
        if ($request->start_date !="" && $request->end_date !="") {
            $data['singledata'] = BankAccount::where('id', '=', $id)->first();
            $data['alldata'] = TransactionReport::whereBetween('transaction_date', [$request->start_date, $request->end_date])->where('bank_id', $id)->orderBy('transaction_date', 'ASC')->get();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('accounts.bankReport', $data);
        }
    }
}
