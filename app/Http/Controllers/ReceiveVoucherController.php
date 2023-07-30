<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OtherReceiveType;
use App\Models\OtherReceiveSubType;
use App\Models\BankAccount;
use App\Models\OtherReceiveVoucher;
use App\Models\Transaction;
use App\Models\TransactionReport;
use Validator;
use Response;
use Session;
use Auth;
use DB;

class ReceiveVoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alltype']= OtherReceiveType::where('status', '1')->get();
        $data['allbank']= BankAccount::all();
        return view('otherReceive.voucher', $data);
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
            'receive_type_id' => 'required',
            'receive_sub_type_id' => 'required',
            'amount' => 'required|numeric|gt:0',
            'receive_from' => 'required',
            'receive_date' => 'required',
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
            $insert= OtherReceiveVoucher::create($input);

            $update=DB::table('bank_account')->where('id', $request->bank_id)->increment('balance', $request->amount);

            // get receive type name
            $receiveTypeName=DB::table('other_receive_type')->where('id', $request->receive_type_id)->first();

            $insertIntoTransaction = Transaction::create([
                'date'=>$request->receive_date,
                'reason'=>'Receive(others-'.$receiveTypeName->name.')',
                'amount'=>$request->amount,
                'tok'=> date('Ymdhis'),
                'status'=> '1',
                'created_by'=> Auth::id(),
            ]);

            $insertIntoReportForReceive = TransactionReport::create([
                'bank_id'=>$request->bank_id,
                'transaction_date'=>$request->receive_date,
                'reason'=>'receive(others-'.$receiveTypeName->name.')',
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
            Session::flash('flash_message','Receive Voucher Successfully Added !');
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

    public function findReceiveSubTypeWithType(Request $request)
    {
        $subType = OtherReceiveSubType::where('receive_type_id',$request->id)->get();
        return Response::json($subType);
        die;
    }

    public function report(Request $request)
    {
        $data['alldata']= OtherReceiveVoucher::where('status', '1')->paginate(250);
        $data['alltype']= OtherReceiveType::where('status', '1')->get();
        $data['allbank']= BankAccount::all();
        return view('otherReceive.voucherReport', $data);
    }

    public function filter(Request $request)
    {
        if ($request->start_date !="" && $request->end_date !="") {
            $data['alldata']= OtherReceiveVoucher::whereBetween('receive_date', [$request->start_date, $request->end_date])->paginate(250);
            $data['alltype']= OtherReceiveType::where('status', '1')->get();
            $data['allbank']= BankAccount::all();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('otherReceive.voucherReport', $data);
        }
    }
    
    public function receiveDetail($id)
    {
        $data['single_data']= OtherReceiveVoucher::where('id', $id)->first();
        return view('otherReceive.receiveDetail', $data);
    }
}
