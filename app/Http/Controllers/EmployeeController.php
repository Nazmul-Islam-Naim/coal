<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\TransactionReport;
use App\Models\Transaction;
use App\Models\AccountType;
use App\Models\EmployeeLedger;
use App\Models\EmployeeSalaryBill;
use Validator;
use Response;
use Session;
use Auth;
use DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata']= Employee::paginate(15);
        return view('employee.index', $data);
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
    public function createBill(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',
            'amount' => 'required|gt:0',
            'month_name' => 'required',
            'year_name' => 'required',
            'date' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }

        $input = $request->all();
        $input['created_by'] = Auth::id();

        DB::beginTransaction();
        try{
            
            // checking duplicate
            $count = EmployeeSalaryBill::where([['employee_id', $request->employee_id],['month_name', $request->month_name],['year_name', $request->year_name]])->count();
            if($count == 1){
                $bug=1;
            }else{
                $insert = EmployeeSalaryBill::create($input);
                $bug=0;
            }
            
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Bill Successfully Created !');
            return redirect()->back()->with('status_color','success');
        }elseif($bug==1){
            Session::flash('flash_message','Bill Already Created !');
            return redirect()->back()->with('status_color','warning');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
    
    public function updateBill(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|gt:0',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
        $input = $request->all();
        DB::beginTransaction();
        try{
            $bug=0;
            
            $update=DB::table('employee_salary_bill')->where('id', $id)->update(['amount'=>$request->amount]);
            DB::commit();
        }catch(\Exception $e){
            //$bug=$e->errorInfo[1];
            $bug=$e->getMessage();
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Bill Updated Successfully!');
            return redirect()->back()->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
    
    public function createdBillList(Request $request)
    {
        $data['alldata']= EmployeeSalaryBill::where('employee_id', $request->id)->paginate(250);
        $data['singledata']= Employee::where('id', $request->id)->first();
        return view('employee.created-bill-list', $data);
    }
    
    public function allBillList(Request $request)
    {
        $data['alldata']= EmployeeSalaryBill::all();
        return view('employee.all-bill-list', $data);
    }
    
    public function allBillListFilter(Request $request)
    {
        $data['alldata']= EmployeeSalaryBill::join('employees', 'employees.id', '=', 'employee_salary_bill.employee_id')->where('employees.name','LIKE', '%'.$request->input.'%')->select('employee_salary_bill.*')->get();
        return view('employee.all-bill-list', $data);
    }
     
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }

        $input = $request->all();
        $input['status'] = 1;
        if ($request->hasFile('employee_image')) {
            $photo=$request->file('employee_image');
            $fileType=$photo->getClientOriginalExtension();
            $fileName=rand(1,1000).date('dmyhis').".".$fileType;
            $photo->move('storage/app/public/uploads/employees', $fileName);
            $input['employee_image']=$fileName;
        }

        DB::beginTransaction();
        try{
            $bug=0;
            $insert= Employee::create($input);
            
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Data Successfully Added !');
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
        $data=Employee::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }

        $input = $request->all();
        if ($request->hasFile('employee_image')) {
            $photo=$request->file('employee_image');
            $fileType=$photo->getClientOriginalExtension();
            $fileName=rand(1,1000).date('dmyhis').".".$fileType;
            $photo->move('storage/app/public/uploads/employees', $fileName);
            $input['employee_image']=$fileName;
        }else{
            $input['employee_image']=$data->employee_image;
        }
        
        DB::beginTransaction();
        try{
            $bug=0;
            $data->update($input);
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Data Successfully Updated !');
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
    
    public function storeSalary(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|gt:0',
            'date' => 'required',
            'employee_id' => 'required',
            'bill_id' => 'required',
            'month' => 'required',
            'year' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }

        $input = $request->all();
        $input['status'] = 1;
        $input['created_by'] = Auth::id();
        $input['reason'] = 'salary - '.$request->note;
        $input['tok'] = date('Ymdhis');

        DB::beginTransaction();
        try{
            $bug=0;
            $insert= EmployeeLedger::create($input);
            
            $decrement=DB::table('bank_account')->where('id', $request->bank_id)->decrement('balance', $request->amount);
            $increment=DB::table('employee_salary_bill')->where('id', $request->bill_id)->increment('paid_amount', $request->amount);

            $insert = TransactionReport::create([
                'bank_id'=>$request->bank_id,
                'transaction_date'=>$request->date,
                'reason'=>'payment(employee salary -'.$request->emp_name.'-'.$request->note.')',
                'amount'=>$request->amount,
                'note'=>$request->note,
                'tok'=>date('Ymdhis'),
                'status'=>'1',
                'created_by'=>Auth::id()
            ]);

            $insert = Transaction::create([
                'date'=>$request->date,
                'reason'=>'Payment(employee salary - '.$request->emp_name.'-'.$request->note.')',
                'amount'=>$request->amount,
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
            Session::flash('flash_message','Data Successfully Added !');
            return redirect()->back()->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
    
    public function employeeLedger(Request $request)
    {
        //$data['alldata']= ProductSell::where('tok', $request->id)->get();
        //$data['singleData']= Vat::where('tok', $request->id)->first();
        $data['alldata']= EmployeeLedger::where('employee_id', $request->id)->paginate(250);
        $data['singledata']= Employee::where('id', $request->id)->first();
        return view('employee.employeeLedger', $data);
    }
    
    public function filter(Request $request, $id)
    {
        if ($request->search && $request->start_date !="" && $request->end_date !="") {
            $data['alldata']= EmployeeLedger::where('employee_id', $id)->whereBetween('date', [$request->start_date, $request->end_date])->paginate(250);
            $data['singledata']= Employee::where('id', $id)->first();
            $data['start_date']= $request->start_date;
            $data['end_date']= $request->end_date;
            return view('employee.employeeLedger', $data);
        }
    }
    
    public function report()
    {
        $data['alldata']= EmployeeLedger::orderBy('id', 'DESC')->paginate(250);
        return view('employee.report', $data);
    }
    
    public function reportFilter(Request $request)
    {
        if ($request->search && $request->start_date !="" && $request->end_date !="" && $request->input =="") {
            $data['alldata']= EmployeeLedger::whereBetween('employee_ledger.date', [$request->start_date, $request->end_date])->orderBy('employee_ledger.id', 'DESC')->select('employee_ledger.*')->paginate(250);
            $data['start_date']= $request->start_date;
            $data['end_date']= $request->end_date;
            return view('employee.report', $data);
        }elseif ($request->search && $request->start_date !="" && $request->end_date !="" && $request->input !="") {
            $data['alldata']= EmployeeLedger::join('employees', 'employees.id', '=', 'employee_ledger.employee_id')->where('employees.name', 'like', '%' . $request->input . '%')->whereBetween('employee_ledger.date', [$request->start_date, $request->end_date])->orderBy('employee_ledger.id', 'DESC')->select('employee_ledger.*')->paginate(250);
            $data['start_date']= $request->start_date;
            $data['end_date']= $request->end_date;
            return view('employee.report', $data);
        }elseif ($request->search && $request->start_date =="" && $request->end_date =="" && $request->input !="") {
            $data['alldata']= EmployeeLedger::join('employees', 'employees.id', '=', 'employee_ledger.employee_id')->where('employees.name', 'like', '%' . $request->input . '%')->orderBy('employee_ledger.id', 'DESC')->select('employee_ledger.*')->paginate(250);
            $data['start_date']= $request->start_date;
            $data['end_date']= $request->end_date;
            return view('employee.report', $data);
        }else{
           $data['alldata']= EmployeeLedger::orderBy('id', 'DESC')->paginate(250);
            return view('employee.report', $data); 
        }
    }
    
    public function getSalaryForAmendment()
    {
        $data['alldata']= EmployeeLedger::orderBy('id', 'DESC')->paginate(250);
        return view('amenment.employeeSalaryReport', $data);
    }
    
    public function deleteSalaryForAmendment($id)
    {
        DB::beginTransaction();
        try{
            $bug=0;
            $info= EmployeeLedger::where('tok', $id)->first();
            
            $decrement=DB::table('bank_account')->where('id', $info->bank_id)->increment('balance', $info->amount);
            $decrement=DB::table('employee_salary_bill')->where('id', $info->bill_id)->decrement('paid_amount', $info->amount);

            $delete = TransactionReport::where('tok', $id)->delete();
            $delete = Transaction::where('tok', $id)->delete();
            $delete = EmployeeLedger::where('tok', $id)->delete();
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Data Successfully Deleted !');
            return redirect()->back()->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
    
    public function searchEmpSalaryAmendmentFilter(Request $request)
    {
        if ($request->search && $request->start_date !="" && $request->end_date !="" && $request->input =="") {
            $data['alldata']= EmployeeLedger::whereBetween('employee_ledger.date', [$request->start_date, $request->end_date])->orderBy('employee_ledger.id', 'DESC')->select('employee_ledger.*')->paginate(250);
            $data['start_date']= $request->start_date;
            $data['end_date']= $request->end_date;
            return view('amenment.employeeSalaryReport', $data);
        }elseif ($request->search && $request->start_date !="" && $request->end_date !="" && $request->input !="") {
            $data['alldata']= EmployeeLedger::join('employees', 'employees.id', '=', 'employee_ledger.employee_id')->where('employees.name', 'like', '%' . $request->input . '%')->whereBetween('employee_ledger.date', [$request->start_date, $request->end_date])->orderBy('employee_ledger.id', 'DESC')->select('employee_ledger.*')->paginate(250);
            $data['start_date']= $request->start_date;
            $data['end_date']= $request->end_date;
            return view('amenment.employeeSalaryReport', $data);
        }elseif ($request->search && $request->start_date =="" && $request->end_date =="" && $request->input !="") {
            $data['alldata']= EmployeeLedger::join('employees', 'employees.id', '=', 'employee_ledger.employee_id')->where('employees.name', 'like', '%' . $request->input . '%')->orderBy('employee_ledger.id', 'DESC')->select('employee_ledger.*')->paginate(250);
            $data['start_date']= $request->start_date;
            $data['end_date']= $request->end_date;
            return view('amenment.employeeSalaryReport', $data);
        }else{
            $data['alldata']= EmployeeLedger::orderBy('id', 'DESC')->paginate(250);
            return view('amenment.employeeSalaryReport', $data);
        }
    }
}
