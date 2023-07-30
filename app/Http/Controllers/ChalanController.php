<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductSell;
use App\Models\BankAccount;
use App\Models\Vat;
use App\Models\TransactionReport;
use App\Models\Transaction;
use App\Models\Customer;
use App\Models\ProductSellDetails;
use App\Models\SellServiceDetails;
use App\Models\CustomerLedger;
use App\Models\SiteSetting;
use App\Models\GiftPoint;
use App\Models\Technician;
use App\Models\SaveQuotation;
use App\Models\SaveQuotationServiceDetails;
use App\Models\SaveQuotationProDetails;
use App\Models\Chalan;
use Validator;
use Response;
use Session;
use Auth;
use DB;
use URL;


class ChalanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->start_date !="" && $request->end_date !="") {
            $data['alldata']= Chalan::whereBetween('date', [$request->start_date, $request->end_date])->get();
            return view('sell.viewChalan', $data);
        }else{
            $data['alldata']= Chalan::all();
            return view('sell.viewChalan', $data);
        }
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sell.chalan');
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
        die;*/
        
        $validator = Validator::make($request->all(), [
            'buyer_name' => 'required',
            'address' => 'required',
            'chalan_from' => 'required',
            'chalan_to' => 'required',
            'date' => 'required',
            'details' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
        $input = $request->all();
        if (empty(Session::has('sellSession'))) {
            //$tok = md5(date("Ymdhis"));
            $tok = date("Ymdhis");
            // creating a session variable
            Session::put('sellSession', $tok);
        }
        $input['tok'] = Session::get('sellSession');
        $input['created_by'] = Auth::id();
        DB::beginTransaction();
        try{
            $bug=0;
            $insert = Chalan::create($input);
            DB::commit();
        }catch(\Exception $e){
            //$bug=$e->errorInfo[1];
            $bug=$e->getMessage();
            DB::rollback();
        }

        if($bug==0){
            Session::forget('sellSession');
            Session::flash('flash_message','Chalan Successfully Created');
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
        $data = Chalan::findOrFail($id);
        $action = $data->delete();

        if($action){
            Session::flash('flash_message','Chalan Successfully Deleted !');
            return redirect()->back()->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    public function invoice(Request $request)
    {
        $data['singleData']= Chalan::where('id', $request->id)->first();
        return view('sell.chalanInvoice', $data);
    }
}
