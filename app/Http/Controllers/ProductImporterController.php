<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Importer;
use App\Models\BankAccount;
use App\Models\SupplierLedger;
use App\Models\TransactionReport;
use App\Models\Transaction;
use App\Models\ProductSupplierArea;
use Validator;
use Session;
use Auth;
use DB;

class ProductImporterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata']= Importer::get();
        $data['allbank']= BankAccount::all();
        $data['allarea']= ProductSupplierArea::all();
        return view('purchase.importer', $data);
    }

    public function supplierList()
    {
        $data['alldata']= Importer::get();
        $data['allbank']= BankAccount::all();
        $data['allarea']= ProductSupplierArea::all();
        return view('purchase.supplierPayment', $data);
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
        if ($request->supplier_payment) {
            $validator = Validator::make($request->all(), [
                'pay_amount' => 'required|gt:0',
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
                $insert= SupplierLedger::create([
                    'date'=>$request->date,
                    'bank_id'=>$request->payment_method,
                    'supplier_id'=>$request->supplier_id,
                    'amount'=>$request->pay_amount,
                    'reason'=>'payment(supplier)',
                    'note'=>$request->note,
                    'tok'=>date('Ymdhis'),
                    'created_by'=>Auth::id()
                ]);

                // inserting into report table
                $insertIntoReport = TransactionReport::create([
                    'bank_id'=>$request->payment_method,
                    'transaction_date'=>$request->date,
                    'reason'=>'payment(supplier-'.$request->supplier_name.')',
                    'amount'=>$request->pay_amount,
                    'tok'=>date('Ymdhis'),
                    'status'=>'1',
                    'created_by'=>Auth::id()
                ]);

                // inserting into transaction table
                $insertIntoTransaction = Transaction::create([
                    'date'=>$request->date,
                    'reason'=>'payment(supplier-'.$request->supplier_name.')',
                    'amount'=>$request->pay_amount,
                    'tok'=>date('Ymdhis'),
                    'status'=>'1',
                    'created_by'=>Auth::id()
                ]);

                // update bank amount
                $update=DB::table('bank_account')->where('id', $request->payment_method)->decrement('balance', $request->pay_amount);

                DB::commit();
            }catch(\Exception $e){
                $bug=$e->errorInfo[1];
                DB::rollback();
            }

            if($bug==0){
                Session::flash('flash_message','Supplier Payment Successfully Done !');
                return redirect()->back()->with('status_color','success');
            }else{
                Session::flash('flash_message','Something Error Found !');
                return redirect()->back()->with('status_color','danger');
            }
        }else{
            $validator = Validator::make($request->all(), [
                'importer_id' => 'required',
                'name' => 'required',
                'phone' => 'required',
            ]);
            if ($validator->fails()) {
                Session::flash('flash_message', $validator->errors());
                return redirect()->back()->with('status_color','warning');
            }

            $input = $request->all();
            $input['status'] = 1;

            DB::beginTransaction();
            try{
                $bug=0;
                $insert= Importer::create($input);
                // inserting into ledger table
                /*$insert= SupplierLedger::create([
                    'date'=>date('Y-m-d', strtotime($request->predue_date)),
                    'supplier_id'=>$insert->id,
                    'amount'=>$request->pre_due,
                    'reason'=>'pre due',
                    'tok'=>date('Ymdhis'),
                    'created_by'=>Auth::id()
                ]);*/
                DB::commit();
            }catch(\Exception $e){
                $bug=$e->errorInfo[1];
                DB::rollback();
            }

            if($bug==0){
                Session::flash('flash_message','Supplier Successfully Added !');
                return redirect()->back()->with('status_color','success');
            }else{
                Session::flash('flash_message','Something Error Found !');
                return redirect()->back()->with('status_color','danger');
            }
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
        $data['single_data'] = Importer::findOrFail($id);
        $data['alldata']= Importer::paginate(10);
        $data['allbank']= BankAccount::all();
        $data['allarea']= ProductSupplierArea::all();
        return view('purchase.importer', $data);
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
            'importer_id' => 'required',
            'name' => 'required',
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
        $data=Importer::findOrFail($id);
        $input = $request->all();

        try{
            $bug=0;
            $data->update($input);
            //check
            /*$cehck = SupplierLedger::where([['supplier_id', $id],['reason', 'LIKE', '%pre due%']])->count();
            if($cehck==1){
                SupplierLedger::where([['supplier_id', $id],['reason', 'LIKE', '%pre due%']])->update(['amount'=>$request->pre_due]);
            }else{
                $insert= SupplierLedger::create([
                    'date'=>date('Y-m-d', strtotime($request->predue_date)),
                    'supplier_id'=>$id,
                    'amount'=>$request->pre_due,
                    'reason'=>'pre due',
                    'tok'=>date('Ymdhis'),
                    'created_by'=>Auth::id()
                ]);
            }*/
            
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','Supplier Successfully Updated !');
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
        $data = Importer::findOrFail($id);
        $action = $data->delete();

        if($action){
            Session::flash('flash_message','Importer Successfully Deleted !');
            return redirect()->back()->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    public function supplierLedger(Request $request)
    {
        //$data['alldata']= ProductSell::where('tok', $request->id)->get();
        //$data['singleData']= Vat::where('tok', $request->id)->first();
        $data['alldata']= SupplierLedger::where('supplier_id', $request->id)->get();
        $data['singledata']= Supplier::where('id', $request->id)->first();
        return view('purchase.supplierLedger', $data);
    }

    public function supplierPaymentReport()
    {
        $data['alldata']= SupplierLedger::where('reason', 'like', '%' . 'payment(supplier)' . '%')->paginate(250);
        return view('purchase.supplierPaymentReport', $data);
    }

    public function filter(Request $request)
    {
        if ($request->start_date !="" && $request->end_date !="") {
            $data['alldata']= SupplierLedger::where('reason', 'like', '%' . 'payment(supplier)' . '%')->whereBetween('date', [$request->start_date, $request->end_date])->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
        return view('purchase.supplierPaymentReport', $data);
        }
    }
    
    public function supplierBillAdjustment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pay_amount' => 'required|gt:0',
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
            $insert= SupplierLedger::create([
                'date'=>$request->date,
                'bank_id'=>$request->payment_method,
                'supplier_id'=>$request->supplier_id,
                'amount'=>$request->pay_amount,
                'reason'=>'payment(Adjustment)',
                'note'=>$request->note,
                'tok'=>date('Ymdhis'),
                'created_by'=>Auth::id()
            ]);

            // inserting into report table
            $insertIntoReport = TransactionReport::create([
                'bank_id'=>$request->payment_method,
                'transaction_date'=>$request->date,
                'reason'=>'receive(supplier bill adjustment-'.$request->supplier_name.')',
                'amount'=>$request->pay_amount,
                'tok'=>date('Ymdhis'),
                'status'=>'1',
                'created_by'=>Auth::id()
            ]);

            // inserting into transaction table
            $insertIntoTransaction = Transaction::create([
                'date'=>$request->date,
                'reason'=>'Receive(supplier bill adjustment-'.$request->supplier_name.')',
                'amount'=>$request->pay_amount,
                'tok'=>date('Ymdhis'),
                'status'=>'1',
                'created_by'=>Auth::id()
            ]);

            // update bank amount
            $update=DB::table('bank_account')->where('id', $request->payment_method)->increment('balance', $request->pay_amount);

            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Data Successfully Done !');
            return redirect()->back()->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
}
