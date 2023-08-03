<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\lcInfo;
use App\Models\BankAccount;
use App\Models\LcPayment;
use App\Models\TransactionReport;
use Validator;
use Response;
use Session;
use Auth;
use DB;

class LCPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!empty($request->lc_no)){
            $data['row']='1';
            $data['single_data']= lcInfo::where([['status', '1'],['lc_no', $request->lc_no]])->first();
            $data['allaccounts']= BankAccount::where('status', '1')->get();
            $data['lcInfos']= lcInfo::where('status', '1')->select('lc_no')->get();
            $data['lc_no'] = $request->lc_no;
            return view('purchase.lcPayment ', $data);
        }else{
            $data['lcInfos']= lcInfo::where('status', '1')->select('lc_no')->get();
            return view('purchase.lcPayment',$data); 
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
            'date' => 'required',
            'lc_id' => 'required',
            'lc_no' => 'required',
            'bank_id' => 'required',
            'bank_due' => 'required',
            'dollar_rate' => 'required|numeric|gt:0',
            'amount' => 'required|numeric|gt:0',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }

        $input = $request->all();
        $input['status'] = 1;
        $input['created_by'] = Auth::id();
        $input['date'] = date('Y-m-d', strtotime($request->date));
        if (empty(Session::has('sellSession'))) {
            //$tok = md5(date("Ymdhis"));
            $tok = date("Ymdhis");
            // creating a session variable
            Session::put('sellSession', $tok);
        }
        $input['tok'] = Session::get('sellSession');

        DB::beginTransaction();
        try{
            $bug=0;
            $insert= LcPayment::create($input);
            lcInfo::where('id', $request->lc_id)->decrement('bank_due', $request->bank_due);
            
            TransactionReport::create([
                'bank_id'=>$request->bank_id,
                'transaction_date'=>date('Y-m-d', strtotime($request->date)),
                'reason'=>'payment(Next pay LC - '.$request->lc_no.')',
                'amount'=>$request->amount,
                'tok'=>Session::get('sellSession'),
                'note'=>$request->note,
                'status'=>'1',
                'created_by'=>Auth::id()
            ]);
            BankAccount::where('id', $request->bank_id)->decrement('balance', $request->amount);
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::forget('sellSession');
            Session::flash('flash_message','Payment Successfully Done !');
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
}
