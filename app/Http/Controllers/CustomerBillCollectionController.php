<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\ProductSell;
use App\Models\BankAccount;
use App\Models\CustomerLedger;
use App\Models\TransactionReport;
use App\Models\Transaction;
use Validator;
use Session;
use Response;
use Auth;
use DB;

class CustomerBillCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$data['alldata']= DB::table('product_sell')->join('customer', 'customer.id', '=', 'product_sell.customer_id')->join('bank_account', 'bank_account.id', '=', 'product_sell.bank_id')->select('customer.name', 'product_sell.*', 'bank_account.bank_name')->get();
        $data['allbank']= BankAccount::all();
        return view('customers.billCollection', $data);*/
        
        $data['alldata']= Customer::all();
        $data['allbank']= BankAccount::all();
        return view('customers.billCollection', $data);
    }
    
    public function billCollectionFilter(Request $request)
    {
        if ($request->start_date !="" && $request->end_date !="" && $request->input =="") {
            $data['alldata']= DB::table('product_sell')->join('customer', 'customer.id', '=', 'product_sell.customer_id')->join('bank_account', 'bank_account.id', '=', 'product_sell.payment_method')->whereBetween('product_sell.job_card_date', [$request->start_date, $request->end_date])->select('customer.name', 'product_sell.*', 'bank_account.bank_name')->get();
            $data['allbank']= BankAccount::all();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('customers.billCollection', $data);
        }elseif ($request->start_date =="" && $request->end_date =="" && $request->input !="") {
            
            $data['alldata']= DB::table('product_sell')->join('customer', 'customer.id', '=', 'product_sell.customer_id')->join('bank_account', 'bank_account.id', '=', 'product_sell.payment_method')->where('customer.name', 'like', '%' . $request->input . '%')->orWhere('product_sell.job_card_no', 'like', '%' . $request->input . '%')->select('customer.name', 'product_sell.*', 'bank_account.bank_name')->get();
            $data['allbank']= BankAccount::all();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('customers.billCollection', $data);
        }elseif ($request->start_date !="" && $request->end_date !="" && $request->input !="") {
            
            $data['alldata']= DB::table('product_sell')->join('customer', 'customer.id', '=', 'product_sell.customer_id')->join('bank_account', 'bank_account.id', '=', 'product_sell.payment_method')->whereBetween('product_sell.job_card_date', [$request->start_date, $request->end_date])->where('customer.name', 'like', '%' . $request->input . '%')->orWhere('product_sell.job_card_no', 'like', '%' . $request->input . '%')->select('customer.name', 'product_sell.*', 'bank_account.bank_name')->get();
            $data['allbank']= BankAccount::all();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('customers.billCollection', $data);
        }else{
            $data['alldata']= DB::table('product_sell')->join('customer', 'customer.id', '=', 'product_sell.customer_id')->join('bank_account', 'bank_account.id', '=', 'product_sell.payment_method')->select('customer.name', 'product_sell.*', 'bank_account.bank_name')->get();
            $data['allbank']= BankAccount::all();
            return view('customers.billCollection', $data);
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
        /*echo "<pre>";
        print_r($request->all());
        die();*/
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'paid_amount' => 'required|numeric|gt:0',
            'collect_date' => 'required',
            'payment_method' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }

        DB::beginTransaction();
        try{
            $bug=0;
            // inserting into ledger table
            $insert= CustomerLedger::create([
                'date'=>$request->collect_date,
                'bank_id'=>$request->payment_method,
                'customer_id'=>$request->customer_id,
                'amount'=>$request->paid_amount,
                'reason'=>'receive(bill collection)',
                'note'=>$request->note,
                'tok'=>date('Ymdhis'),
                'created_by'=>Auth::id()
            ]);

            // inserting into report table
            $insertIntoReport = TransactionReport::create([
                'bank_id'=>$request->payment_method,
                'transaction_date'=>$request->collect_date,
                'reason'=>'receive(bill collection)',
                'amount'=>$request->paid_amount,
                'tok'=>date('Ymdhis'),
                'status'=>'1',
                'created_by'=>Auth::id()
            ]);

            // inserting into transaction table
            $insertIntoTransaction = Transaction::create([
                'date'=>date('Y-m-d'),
                'reason'=>'Receive(bill collection)',
                'amount'=>$request->paid_amount,
                'tok'=>date('Ymdhis'),
                'status'=>'1',
                'created_by'=>Auth::id()
            ]);

                // update bank amount
                $update=DB::table('bank_account')->where('id', $request->payment_method)->increment('balance', $request->paid_amount);

                DB::commit();
            }catch(\Exception $e){
                $bug=$e->errorInfo[1];
                DB::rollback();
                //return $e->getMessage();
            }

            if($bug==0){
                Session::flash('flash_message','Bill Collection Successfully Done !');
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

    public function report(Request $request)
    {
        $data['alldata']= CustomerLedger::where('reason', 'like', '%' .'receive'. '%')->paginate(250);
        return view('customers.billCollectionReport', $data);
    }

    public function filter(Request $request)
    {
        if ($request->start_date !="" && $request->end_date !="" && $request->input =="") {
            $data['alldata']= DB::table('product_sell')->join('customer', 'customer.id', '=', 'product_sell.customer_id')->join('bank_account', 'bank_account.id', '=', 'product_sell.payment_method')->whereBetween('product_sell.job_card_date', [$request->start_date, $request->end_date])->select('customer.name', 'product_sell.*', 'bank_account.bank_name')->get();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('customers.billCollectionReport', $data);
        }elseif ($request->start_date =="" && $request->end_date =="" && $request->input !="") {
            
            $data['alldata']= DB::table('product_sell')->join('customer', 'customer.id', '=', 'product_sell.customer_id')->join('bank_account', 'bank_account.id', '=', 'product_sell.payment_method')->where('customer.name', 'like', '%' . $request->input . '%')->orWhere('product_sell.job_card_no', 'like', '%' . $request->input . '%')->select('customer.name', 'product_sell.*', 'bank_account.bank_name')->get();
            $data['allbank']= BankAccount::all();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('customers.billCollectionReport', $data);
        }elseif ($request->start_date !="" && $request->end_date !="" && $request->input !="") {
            
            $data['alldata']= DB::table('product_sell')->join('customer', 'customer.id', '=', 'product_sell.customer_id')->join('bank_account', 'bank_account.id', '=', 'product_sell.payment_method')->whereBetween('product_sell.job_card_date', [$request->start_date, $request->end_date])->where('customer.name', 'like', '%' . $request->input . '%')->orWhere('product_sell.invoice_no', 'like', '%' . $request->input . '%')->select('customer.name', 'product_sell.*', 'bank_account.bank_name')->get();
            $data['allbank']= BankAccount::all();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('customers.billCollectionReport', $data);
        }else{
            $data['alldata']= DB::table('product_sell')->join('customer', 'customer.id', '=', 'product_sell.customer_id')->join('bank_account', 'bank_account.id', '=', 'product_sell.payment_method')->select('customer.name', 'product_sell.*', 'bank_account.bank_name')->get();
            return view('customers.billCollectionReport', $data);
        }
    }
    
    public function dailyReport(Request $request)
    {
        /*$data['alldata']= CustomerLedger::where('reason', 'like', '%' .'receive'. '%')->paginate(250);
        return view('customers.billCollectionReport', $data);*/
        
        //$data['alldata']= DB::table('product_sell')->join('customer', 'customer.id', '=', 'product_sell.customer_id')->join('bank_account', 'bank_account.id', '=', 'product_sell.payment_method')->select('customer.name', 'product_sell.*', 'bank_account.bank_name')->get();
        $data['alldata']= DB::table('customer_ledger')->join('customer', 'customer.id', '=', 'customer_ledger.customer_id')->join('bank_account', 'bank_account.id', '=', 'customer_ledger.bank_id')->where('customer_ledger.reason', 'LIKE', '%receive%')->select('customer.name', 'customer_ledger.*', 'bank_account.bank_name')->get();
        return view('customers.dailyDillCollectionReport', $data);
    }
    
    public function dailyReportFilter(Request $request)
    {
        if ($request->start_date !="" && $request->end_date !="" && $request->input =="") {
            $data['alldata']= DB::table('customer_ledger')->join('customer', 'customer.id', '=', 'customer_ledger.customer_id')->join('bank_account', 'bank_account.id', '=', 'customer_ledger.bank_id')->whereBetween('customer_ledger.date', [$request->start_date, $request->end_date])->where('customer_ledger.reason', 'LIKE', '%receive%')->select('customer.name', 'customer_ledger.*', 'bank_account.bank_name')->get();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('customers.dailyDillCollectionReport', $data);
        }elseif ($request->start_date =="" && $request->end_date =="" && $request->input !="") {
            
            $data['alldata']= DB::table('customer_ledger')->join('customer', 'customer.id', '=', 'customer_ledger.customer_id')->join('bank_account', 'bank_account.id', '=', 'customer_ledger.bank_id')->where([['customer.name', 'like', '%' . $request->input . '%'],['customer_ledger.reason', 'LIKE', '%receive%']])->orWhere([['customer_ledger.job_card_no', 'like', '%' . $request->input . '%'],['customer_ledger.reason', 'LIKE', '%receive%']])->select('customer.name', 'customer_ledger.*', 'bank_account.bank_name')->get();
            $data['allbank']= BankAccount::all();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('customers.dailyDillCollectionReport', $data);
        }elseif ($request->start_date !="" && $request->end_date !="" && $request->input !="") {
            
            $data['alldata']= DB::table('customer_ledger')->join('customer', 'customer.id', '=', 'customer_ledger.customer_id')->join('bank_account', 'bank_account.id', '=', 'customer_ledger.bank_id')->whereBetween('customer_ledger.date', [$request->start_date, $request->end_date])->where('customer.name', 'like', '%' . $request->input . '%')->orWhere('customer_ledger.invoice_no', 'like', '%' . $request->input . '%')->where('customer_ledger.reason', 'LIKE', '%receive%')->select('customer.name', 'customer_ledger.*', 'bank_account.bank_name')->get();
            $data['allbank']= BankAccount::all();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('customers.dailyDillCollectionReport', $data);
        }else{
            /*$data['alldata']= CustomerLedger::where('reason', 'like', '%' .'receive'. '%')->paginate(250);
            return view('customers.billCollectionReport', $data);*/
            
            //$data['alldata']= DB::table('product_sell')->join('customer', 'customer.id', '=', 'product_sell.customer_id')->join('bank_account', 'bank_account.id', '=', 'product_sell.payment_method')->select('customer.name', 'product_sell.*', 'bank_account.bank_name')->get();
            $data['alldata']= DB::table('customer_ledger')->join('customer', 'customer.id', '=', 'customer_ledger.customer_id')->join('bank_account', 'bank_account.id', '=', 'customer_ledger.bank_id')->where('customer_ledger.reason', 'LIKE', '%receive%')->select('customer.name', 'customer_ledger.*', 'bank_account.bank_name')->get();
            return view('customers.dailyDillCollectionReport', $data);
        }
    }
}
