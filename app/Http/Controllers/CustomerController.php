<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerLedger;
use Validator;
use Session;
use Response;
use DB;
use Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata']= Customer::get();
        return view('customers.index', $data);
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
            'customer_id' => 'required',
            'name' => 'required',
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
            $insert= Customer::create($input);
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Customer Successfully Added !');
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
        $data['single_data'] = Customer::findOrFail($id);
        $data['alldata']= Customer::paginate(10);
        return view('customers.index', $data);
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
        $data=Customer::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'name' => 'required',
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
            Session::flash('flash_message','Customer Successfully Updated !');
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
        $data = Customer::findOrFail($id);
        $action = $data->delete();

        if($action){
            Session::flash('flash_message','Customer Successfully Deleted !');
            return redirect()->back()->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    public function addCustomerViaPosPage(Request $request)
    {
        $input = $request->all();
        $input['status'] = 1;

        $cusID = DB::table('customer')->orderBy('id', 'desc')->first();
        if (!empty($cusID->customer_id)) {
            $input['customer_id'] = $cusID->customer_id+1;
        }else{
            $input['customer_id'] = '1000';
        }

        DB::beginTransaction();
        try{
            $bug=0;
            $insert= Customer::create($input);
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            $lastCustomer = Customer::orderBy('id', 'DESC')->take(1)->get();
            return Response::json($lastCustomer);
        }else{
            $lastCustomer = 'Error';
            return Response::json($lastCustomer);
        }
    }

    public function customerLedger(Request $request)
    {
        //$data['alldata']= ProductSell::where('tok', $request->id)->get();
        //$data['singleData']= Vat::where('tok', $request->id)->first();
        $data['alldata']= CustomerLedger::where('customer_id', $request->id)->orderBy('date', 'ASC')->paginate(250);
        $data['singledata']= Customer::where('id', $request->id)->first();
        return view('customers.customerLedger', $data);
    }

    public function filter(Request $request, $id)
    {
        if ($request->search && $request->start_date !="" && $request->end_date !="") {
            $data['alldata']= CustomerLedger::where('customer_id', $id)->whereBetween('date', [$request->start_date, $request->end_date])->orderBy('date', 'ASC')->paginate(250);
            $data['singledata']= Customer::where('id', $id)->first();
            $data['start_date']= $request->start_date;
            $data['end_date']= $request->end_date;
            return view('customers.customerLedger', $data);
        }
    }
    
    public function addCustomerPredue(Request $request, $id)
    {
        $data=Customer::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'pre_due' => 'required',
            'pre_due_date' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
              
        $input = $request->all();

        try{
            $bug=0;
            $data->update($input);
            
            $cehck = CustomerLedger::where([['customer_id', $id],['reason', 'LIKE', '%pre due%']])->count();
            if($cehck==1){
                CustomerLedger::where([['customer_id', $id],['reason', 'LIKE', '%pre due%']])->update(['amount'=>$request->pre_due,'date'=>date('Y-m-d', strtotime($request->pre_due_date))]);
            }else{
                $insert= CustomerLedger::create([
                    'date'=>date('Y-m-d', strtotime($request->pre_due_date)),
                    'customer_id'=>$id,
                    'amount'=>$request->pre_due,
                    'reason'=>'pre due',
                    'tok'=>date('Ymdhis'),
                    'created_by'=>Auth::id()
                ]);
            }
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','Predue Successfully Updated !');
            return redirect()->back()->with('status_color','warning');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
}
