<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankAccount;
use App\Models\Truck;
use App\Models\TruckRent;
use App\Models\TransactionReport;
use App\Models\Transaction;
use App\Models\Branch;
use App\Models\ProductSupplierArea;
use Validator;
use Session;
use Auth;
use DB;

class TruckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata']= Truck::get();
        $data['allbank']= BankAccount::all();
        $data['allbranch']= Branch::all();
        return view('truck.index', $data);
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
        if ($request->add_rent) {
            $validator = Validator::make($request->all(), [
                'truck_id'=>'required',
                'branch_id'=>'required',
                'date'=>'required',
                'bank_id'=>'required',
                'rent_amount' => 'required|numeric|gt:0',
                'cost_amount' => 'required|numeric|gt:0',
            ]);
            if ($validator->fails()) {
                Session::flash('flash_message', $validator->errors());
                return redirect()->back()->with('status_color','warning');
            }

            DB::beginTransaction();
            try{
                $bug=0;
                // inserting into ledger table
                $insert= TruckRent::create([
                    'branch_id'=>$request->branch_id,
                    'truck_id'=>$request->truck_id,
                    'date'=>$request->date,
                    'bank_id'=>$request->bank_id,
                    'rent_amount'=>$request->rent_amount,
                    'cost_amount'=>$request->cost_amount,
                    'rent_from'=>$request->rent_from,
                    'rent_to'=>$request->rent_to,
                    'note'=>$request->note,
                    'tok'=>date('Ymdhis'),
                    'created_by'=>Auth::id()
                ]);

                // inserting into report table
                $insertIntoReport = TransactionReport::create([
                    'bank_id'=>$request->bank_id,
                    'transaction_date'=>$request->date,
                    'reason'=>'receive(truck rent -'.$request->truck_no.')',
                    'amount'=>$request->rent_amount-$request->cost_amount,
                    'tok'=>date('Ymdhis'),
                    'note'=>$request->note,
                    'status'=>'1',
                    'created_by'=>Auth::id()
                ]);

                // inserting into transaction table
                $insertIntoTransaction = Transaction::create([
                    'date'=>$request->date,
                    'reason'=>'receive(truck rent -'.$request->truck_no.')',
                    'amount'=>$request->rent_amount-$request->cost_amount,
                    'tok'=>date('Ymdhis'),
                    'status'=>'1',
                    'created_by'=>Auth::id()
                ]);

                // update bank amount
                $update=DB::table('bank_account')->where('id', $request->bank_id)->increment('balance', $request->rent_amount-$request->cost_amount);

                DB::commit();
            }catch(\Exception $e){
                $bug=$e->errorInfo[1];
                DB::rollback();
            }

            if($bug==0){
                Session::flash('flash_message','Rent Successfully Added !');
                return redirect()->back()->with('status_color','success');
            }else{
                Session::flash('flash_message','Something Error Found !');
                return redirect()->back()->with('status_color','danger');
            }
        }else{
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'number' => 'required',
                'price' => 'required|numeric|gt:0',
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
                $insert= Truck::create($input);
                DB::commit();
            }catch(\Exception $e){
                $bug=$e->errorInfo[1];
                DB::rollback();
            }

            if($bug==0){
                Session::flash('flash_message','Truck Successfully Added !');
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
        $data['single_data'] = Truck::findOrFail($id);
        $data['alldata'] = Truck::all();
        $data['allbank']= BankAccount::all();
        $data['allbranch']= Branch::all();
        return view('truck.index', $data);
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
        $data=Truck::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'number' => 'required',
            'price' => 'required|numeric|gt:0',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
              
        $input = $request->all();

        try{
            $bug=0;
            $data->update($input);
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','Truck Successfully Updated !');
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
        $data = Truck::findOrFail($id);
        $action = $data->delete();

        if($action){
            Session::flash('flash_message','Truck Successfully Deleted !');
            return redirect()->back()->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    public function rentReport(Request $request)
    {
        $data['alldata']= TruckRent::all();
        $data['alltruck']= Truck::all();
        return view('truck.truckReport', $data);
    }

    public function rentReportFilter(Request $request)
    {
        if ($request->start_date !="" && $request->end_date !="" && $request->search =="") {
            $data['alldata']= TruckRent::whereBetween('date', [date('Y-m-d', strtotime($request->start_date)), date('Y-m-d', strtotime($request->end_date))])->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            $data['alltruck']= Truck::all();
            return view('truck.truckReport', $data);
        }elseif ($request->start_date !="" && $request->end_date !="" && $request->search !="") {
            $data['alldata']= TruckRent::where('truck_id', $request->search)->whereBetween('date', [date('Y-m-d', strtotime($request->start_date)), date('Y-m-d', strtotime($request->end_date))])->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            $data['alltruck']= Truck::all();
            return view('truck.truckReport', $data);
        }elseif ($request->start_date =="" && $request->end_date =="" && $request->search !="") {
            $data['alldata']= TruckRent::where('truck_id', $request->search)->paginate(250);
            $data['alltruck']= Truck::all();
            return view('truck.truckReport', $data);
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
    
    public function rsUserLedger(Request $request)
    {
        //$data['alldata']= ProductSell::where('tok', $request->id)->get();
        //$data['singleData']= Vat::where('tok', $request->id)->first();
        $data['alldata']= RSUserLedger::where('rs_id', $request->id)->get();
        $data['singledata']= RSUser::where('id', $request->id)->first();
        return view('purchase.rsUserLedger', $data);
    }
    
    public function rsRupeeLedger(Request $request)
    {
        //$data['alldata']= ProductSell::where('tok', $request->id)->get();
        //$data['singleData']= Vat::where('tok', $request->id)->first();
        $data['alldata']= RSRupeeLedger::where('rs_id', $request->id)->get();
        $data['singledata']= RSUser::where('id', $request->id)->first();
        return view('purchase.rsRupeeLedger', $data);
    }
}
