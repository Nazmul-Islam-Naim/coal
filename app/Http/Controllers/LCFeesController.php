<?php

namespace App\Http\Controllers;


use App\Http\Requests\Filter\LcDateFilter;
use Illuminate\Http\Request;
use App\Models\lcInfo;
use App\Models\BankAccount;
use App\Models\LcFeesPayment;
use App\Models\FeeType;
use App\Models\TransactionReport;
use Validator;
use Response;
use Session;
use Auth;
use DB;

class LCFeesController extends Controller
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
            $data['existsData']=LcFeesPayment::where('lc_no', $request->lc_no)->get();
            $data['allaccounts']= BankAccount::where('status', '1')->get();
            $data['lcInfos']= lcInfo::where('status', '1')->select('lc_no')->get();
            $data['lc_no'] = $request->lc_no;
            return view('purchase.lcFees ', $data);
        }else{
            $data['lcInfos']= lcInfo::where('status', '1')->select('lc_no')->get();
            return view('purchase.lcFees',$data); 
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
        //die('saved');
        $validator = Validator::make($request->all(), [
            'lc_no' => 'required',
            'lc_id' => 'required',
            'bank_id' => 'required',
            'date' => 'required',
            'total_amount' => 'required|numeric|gt:0',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }

        $input = $request->all();
        $input['status'] = 1;
        $input['created_by'] = Auth::id();
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
            foreach ($request->fee_details as $value) {
                $input['bank_id'] = $request->bank_id;
                $input['lc_no'] = $request->lc_no;
                $input['lc_id'] = $request->lc_id;
                $input['note'] = $request->note;
                $input['created_by'] = Auth::id();
                $input['fees_type_id'] = $value['fees_type_id'];
                $input['amount'] = $value['amount'];
                $input['tok'] = Session::get('sellSession');
                $input['status'] = '1';
                $input['date'] = date('Y-m-d', strtotime($request->date));
                $insert= LcFeesPayment::create($input);
                
                // fees type details
                $feesType=FeeType::find($value['fees_type_id']);
                // fee type wise amount to transaction tbl
                TransactionReport::create([
                    'bank_id'=>$request->bank_id,
                    'transaction_date'=>date('Y-m-d', strtotime($request->date)),
                    'reason'=>'payment(fees for '.$feesType->name.' LC - '.$request->lc_no.')',
                    'amount'=>$value['amount'],
                    'tok'=>Session::get('sellSession'),
                    'note'=>$request->note,
                    'status'=>'1',
                    'created_by'=>Auth::id()
                ]);
            }
            
            BankAccount::where('id', $request->bank_id)->decrement('balance', $request->total_amount);
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
            //return $e->getMessage();
        }

        if($bug==0){
            Session::forget('sellSession');
            Session::flash('flash_message','Fees Payment Successfully Added !');
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
        $validator = Validator::make($request->all(), [
            'lc_no' => 'required',
            'lc_id' => 'required',
            'bank_id' => 'required',
            'date' => 'required',
            'total_amount' => 'required|numeric|gt:0',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }

        $input = $request->all();
        $input['status'] = 1;
        $input['created_by'] = Auth::id();
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
            // delete past lc fees payment
            $paymentDetail=LcFeesPayment::where('lc_id',$request->lc_id)->select(DB::raw('SUM(amount) as ttl'),'bank_id','tok')->first();
            BankAccount::where('id', $paymentDetail->bank_id)->increment('balance', $paymentDetail->ttl);
            LcFeesPayment::where('tok',$paymentDetail->tok)->delete();
            TransactionReport::where('tok',$paymentDetail->tok)->delete();
            foreach ($request->fee_details as $value) {
                $input['bank_id'] = $request->bank_id;
                $input['lc_no'] = $request->lc_no;
                $input['lc_id'] = $request->lc_id;
                $input['note'] = $request->note;
                $input['created_by'] = Auth::id();
                $input['fees_type_id'] = $value['fees_type_id'];
                $input['amount'] = $value['amount'];
                $input['tok'] = Session::get('sellSession');
                $input['status'] = '1';
                $input['date'] = date('Y-m-d', strtotime($request->date));
                $insert= LcFeesPayment::create($input);
                
                // fees type details
                $feesType=FeeType::find($value['fees_type_id']);
                // fee type wise amount to transaction tbl
                TransactionReport::create([
                    'bank_id'=>$request->bank_id,
                    'transaction_date'=>date('Y-m-d', strtotime($request->date)),
                    'reason'=>'payment(fees for '.$feesType->name.' LC - '.$request->lc_no.')',
                    'amount'=>$value['amount'],
                    'tok'=>Session::get('sellSession'),
                    'note'=>$request->note,
                    'status'=>'1',
                    'created_by'=>Auth::id()
                ]);
            }
            
            BankAccount::where('id', $request->bank_id)->decrement('balance', $request->total_amount);
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
            //return $e->getMessage();
        }

        if($bug==0){
            Session::forget('sellSession');
            Session::flash('flash_message','Fees Payment Successfully Added !');
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
        $data = Branch::findOrFail($id);
        $action = $data->delete();

        if($action){
            Session::flash('flash_message','Branch Successfully Deleted !');
            return redirect()->back()->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    public function lcFeePaymentsReport(LcDateFilter $request){
        if ($request->start_date != '' && $request->end_date != '' && $request->lc_no != '') {
            $data['lcFeesPayments'] = LcFeesPayment::where('lc_no', $request->lc_no)
                                    ->whereBetween('date',[$request->start_date, $request->end_date])
                                    ->paginate(250);
            $data['lcInfos'] = lcInfo::select('lc_no')->get();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('lc.lcFeePaymentsReport', $data);
        } elseif ($request->start_date != '' && $request->end_date != '' && $request->lc_no == ''){
            $data['lcFeesPayments'] = LcFeesPayment::whereBetween('date',[$request->start_date, $request->end_date])
                                    ->paginate(250);
                                    $data['lcInfos'] = lcInfo::select('lc_no')->get();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('lc.lcFeePaymentsReport', $data);
        } elseif ($request->start_date == '' && $request->end_date == '' && $request->lc_no != ''){
            $data['lcFeesPayments'] = LcFeesPayment::where('lc_no', $request->lc_no)
                                    ->paginate(250);
                                    $data['lcInfos'] = lcInfo::select('lc_no')->get();
            return view('lc.lcFeePaymentsReport', $data);
        } else {
            $data['lcInfos'] = lcInfo::select('lc_no')->get();
            $data['lcFeesPayments'] = LcFeesPayment::paginate(250);
            return view('lc.lcFeePaymentsReport', $data);
        }
    }
}
