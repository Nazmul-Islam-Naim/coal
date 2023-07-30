<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Agency;
use App\Models\Transaction;
use App\Models\AgencyLedger;
use App\Models\TransactionReport;
use Validator;
use Response;
use Session;
use Auth;
use DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata']= Agency::all();
        return view('lighterAgency.payment ', $data);
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
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'bank_id' => 'required',
            'amount' => 'required|numeric|gt:0',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
              
        $input = $request->all();
        try{
            $bug=0;
            // inserting into ledger table
                $insert= AgencyLedger::create([
                    'date'=>$request->date,
                    'bank_id'=>$request->bank_id,
                    'agency_id'=>$id,
                    'amount'=>$request->amount,
                    'reason'=>'payment',
                    'tok'=>date('Ymdhis'),
                    'created_by'=>Auth::id()
                ]);

                // inserting into report table
                $insertIntoReport = TransactionReport::create([
                    'bank_id'=>$request->bank_id,
                    'transaction_date'=>$request->date,
                    'reason'=>'payment(lighter agency - '.$request->agency_name.')',
                    'amount'=>$request->amount,
                    'tok'=>date('Ymdhis'),
                    'status'=>'1',
                    'created_by'=>Auth::id()
                ]);

                // inserting into transaction table
                $insertIntoTransaction = Transaction::create([
                    'date'=>$request->date,
                    'reason'=>'payment(lighter agency - '.$request->agency_name.')',
                    'amount'=>$request->amount,
                    'tok'=>date('Ymdhis'),
                    'status'=>'1',
                    'created_by'=>Auth::id()
                ]);

                // update bank amount
                $update=DB::table('bank_account')->where('id', $request->bank_id)->decrement('balance', $request->amount);
            
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','Payment Successfully done !');
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
}
