<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exporter;
use Validator;
use Response;
use Session;
use Auth;
use DB;
use App\Models\Truck;
use App\Models\Agency;
use App\Models\AgencyLedger;


class ManageAgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata']= Agency::paginate(15);
        return view('lighterAgency.agency', $data);
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
            'agency_id' => 'required',
            'agency_name' => 'required',
            'owner_name' => 'required',
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
            $insert= Agency::create($input);
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Agency Successfully Added !');
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
        $data=Agency::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'agency_id' => 'required',
            'agency_name' => 'required',
            'owner_name' => 'required',
            'phone' => 'required',
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
            Session::flash('flash_message','Agency Successfully Updated !');
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
        $data = Agency::findOrFail($id);
        $action = $data->delete();

        if($action){
            Session::flash('flash_message','Agency Successfully Deleted !');
            return redirect()->back()->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
    
    public function addPreDueToAgency(Request $request, $id){
        $data=Agency::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'pre_due' => 'required|numeric|gt:0',
            'predue_date' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
              
        $input = $request->all();
        try{
            $bug=0;
            $data->update($input);
            
            $cehck = AgencyLedger::where([['agency_id', $id],['reason', 'LIKE', '%pre due%']])->count();
            if($cehck==1){
                AgencyLedger::where([['agency_id', $id],['reason', 'LIKE', '%pre due%']])->update(['amount'=>$request->pre_due]);
            }else{
                $insert= AgencyLedger::create([
                    'date'=>date('Y-m-d', strtotime($request->predue_date)),
                    'agency_id'=>$id,
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
            Session::flash('flash_message','Previous Due Successfully Updated !');
            return redirect()->back()->with('status_color','warning');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
    
    public function agencyLedger(Request $request)
    {
        //$data['alldata']= ProductSell::where('tok', $request->id)->get();
        //$data['singleData']= Vat::where('tok', $request->id)->first();
        $data['alldata']= AgencyLedger::where('agency_id', $request->id)->get();
        $data['singledata']= Agency::where('id', $request->id)->first();
        return view('lighterAgency.agencyLedger', $data);
    }
}
