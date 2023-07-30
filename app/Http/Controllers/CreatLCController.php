<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Supplier;
use App\Models\Importer;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\BankAccount;
use App\Models\lcInfo;
use App\Models\LcProductDetails;
use App\Models\TransactionReport;
use App\Models\LcPayment;
use Validator;
use Response;
use Session;
use Auth;
use DB;
use Carbon\Carbon;

include(app_path() . '/library/common.php');

class CreatLCController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->start_date !="" && $request->end_date !="" && $request->importer_id =="" && $request->exporter_id =="") {
            $data['alldata']= lcInfo::where('status', '=', '1')->whereBetween('opening_date', [dateFormateForDB($request->start_date), dateFormateForDB($request->end_date)])->orderBy('opening_date', 'ASC')->paginate(250);
            return view('purchase.viewLC', $data); 
        }elseif ($request->start_date !="" && $request->end_date !="" && $request->importer_id !="" && $request->exporter_id !="") {
            $data['alldata']= lcInfo::where('status', '=', '1')->whereBetween('opening_date', [dateFormateForDB($request->start_date), dateFormateForDB($request->end_date)])->where([['importer_id',$request->importer_id],['exporter_id',$request->exporter_id]])->orderBy('opening_date', 'ASC')->paginate(250);
            return view('purchase.viewLC', $data); 
        }elseif ($request->start_date =="" && $request->end_date =="" && $request->importer_id !="" && $request->exporter_id !="") {
            $data['alldata']= lcInfo::where('status', '=', '1')->where([['importer_id',$request->importer_id],['exporter_id',$request->exporter_id]])->orderBy('opening_date', 'ASC')->paginate(250);
            return view('purchase.viewLC', $data); 
        }elseif ($request->start_date =="" && $request->end_date =="" && $request->importer_id !="" && $request->exporter_id =="") {
            $data['alldata']= lcInfo::where('status', '=', '1')->where('importer_id',$request->importer_id)->orderBy('opening_date', 'ASC')->paginate(250);
            return view('purchase.viewLC', $data); 
        }elseif ($request->start_date =="" && $request->end_date =="" && $request->importer_id =="" && $request->exporter_id !="") {
            $data['alldata']= lcInfo::where('status', '=', '1')->where('exporter_id',$request->exporter_id)->orderBy('opening_date', 'ASC')->paginate(250);
            return view('purchase.viewLC', $data); 
        }else{
            $data['alldata']= lcInfo::where('status', '=', '1')->orderBy('opening_date', 'ASC')->paginate(250);
            return view('purchase.viewLC', $data); 
        }
    }
    
    public function lcDetail($id)
    {
        $data['alldata'] = LcProductDetails::where('lc_id', $id)->get();
        $data['singledata'] =  lcInfo::where('id', $id)->first();
        return view('purchase.lcDetailRepost', $data);
    }
    
    public function getLcReport(Request $request){
        /*if ($request->start_date !="" && $request->end_date !="") {
            $data['alldata']= lcInfo::where('status', '=', '2')->whereBetween('opening_date', [dateFormateForDB($request->start_date), dateFormateForDB($request->end_date)])->paginate(250);
            return view('purchase.lcReport', $data); 
        }else{
            $data['alldata']= lcInfo::where('status', '=', '2')->paginate(250);
            return view('purchase.lcReport', $data); 
        }*/
        
        if ($request->start_date !="" && $request->end_date !="" && $request->importer_id =="" && $request->exporter_id =="") {
            $data['alldata']= lcInfo::where('status', '=', '2')->whereBetween('opening_date', [dateFormateForDB($request->start_date), dateFormateForDB($request->end_date)])->paginate(250);
            return view('purchase.lcReport', $data); 
        }elseif ($request->start_date !="" && $request->end_date !="" && $request->importer_id !="" && $request->exporter_id !="") {
            $data['alldata']= lcInfo::where('status', '=', '2')->whereBetween('opening_date', [dateFormateForDB($request->start_date), dateFormateForDB($request->end_date)])->where([['importer_id',$request->importer_id],['exporter_id',$request->exporter_id]])->paginate(250);
            return view('purchase.lcReport', $data); 
        }elseif ($request->start_date =="" && $request->end_date =="" && $request->importer_id !="" && $request->exporter_id !="") {
            $data['alldata']= lcInfo::where('status', '=', '2')->where([['importer_id',$request->importer_id],['exporter_id',$request->exporter_id]])->paginate(250);
            return view('purchase.lcReport', $data); 
        }elseif ($request->start_date =="" && $request->end_date =="" && $request->importer_id !="" && $request->exporter_id =="") {
            $data['alldata']= lcInfo::where('status', '=', '2')->where('importer_id',$request->importer_id)->paginate(250);
            return view('purchase.lcReport', $data); 
        }elseif ($request->start_date =="" && $request->end_date =="" && $request->importer_id =="" && $request->exporter_id !="") {
            $data['alldata']= lcInfo::where('status', '=', '2')->where('exporter_id',$request->exporter_id)->paginate(250);
            return view('purchase.lcReport', $data); 
        }else{
            $data['alldata']= lcInfo::where('status', '=', '2')->paginate(250);
            return view('purchase.lcReport', $data); 
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['alldata']= Branch::where('status', '1')->paginate(15);
        $data['allproduct']= Product::where('status', '1')->get();
        $data['allproducttype']= ProductType::where('status', '1')->get();
        $data['allaccounts']= BankAccount::where('status', '1')->get();
        $data['allsupplier']= Supplier::where('status', '1')->get();
        $data['allimporter']= Importer::where('status', '1')->get();
        $data['allborder']= Branch::where('status', '1')->get();
        return view('purchase.creatLC', $data);
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
            'lc_no' => 'required|unique:lc_info',
            'bank_id' => 'required',
            'importer_id' => 'required',
            'exporter_id' => 'required',
            'opening_date' => 'required',
            'expire_date' => 'required',
            'shipment_date' => 'required',
            'border_id' => 'required',
            'sub_total' => 'required|numeric|gt:0',
            'dollar_rate' => 'required|numeric|gt:0',
            'total_bdt' => 'required|numeric|gt:0',
            'margin_percent' => 'required|numeric|gt:0',
            'margin_amount' => 'required|numeric|gt:0',
            'bank_due' => 'required|numeric|gt:0',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }

        $input = $request->all();
        if(!empty($request->opening_date)){
            $input['opening_date']=date('Y-m-d', strtotime($request->opening_date));
        }
        if(!empty($request->opening_date)){
            $input['expire_date']=date('Y-m-d', strtotime($request->expire_date));
        }
        if(!empty($request->opening_date)){
           $input['shipment_date']=date('Y-m-d', strtotime($request->shipment_date)); 
        }
        if(!empty($request->commission)){
            $input['commission']=$request->commission;
        }else{
            $input['commission']=0;
        }
        if(!empty($request->insurance)){
            $input['insurance']=$request->insurance;
        }else{
            $input['insurance']=0;
        }
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
            $ttlQnty=0;
            $insert=lcInfo::create($input);
            foreach ($request->purchase_details as $value) {
                $input['lc_id'] = $insert->id;
                $input['product_type_id'] = $value['product_type_id'];
                $input['product_id'] = $value['product_id'];
                $input['unit_price'] = $value['unit_price'];
                $input['quantity'] = $value['quantity'];
                $input['tok'] = Session::get('sellSession');
                $input['created_by'] = Auth::id();
                LcProductDetails::create($input);
                
                $ttlQnty += $value['quantity'];
            }
            // update ttl qnty
            $update= lcInfo::where('id', $insert->id)->update(['total_qnty'=>$ttlQnty]);
            
            LcPayment::create([
                'date'=>date('Y-m-d', strtotime($request->opening_date)),
                'lc_id'=>$insert->id,
                'lc_no'=>$request->lc_no,
                'bank_id'=>$request->bank_id,
                'bank_due'=>$request->margin_percent,
                'dollar_rate'=>$request->dollar_rate,
                'amount'=>$request->margin_amount,
                'status'=>'1',
                'created_by'=>Auth::id(),
                'tok'=>Session::get('sellSession')
            ]);
            
            // insert margin amount into transaction
            if($request->margin_amount>0){
                TransactionReport::create([
                    'bank_id'=>$request->bank_id,
                    'transaction_date'=>date('Y-m-d', strtotime($request->opening_date)),
                    'reason'=>'payment(Margin LC - '.$request->lc_no.')',
                    'amount'=>$request->margin_amount,
                    'tok'=>Session::get('sellSession'),
                    'status'=>'1',
                    'created_by'=>Auth::id()
                ]);
            }
            
            // insert Comission amount into transaction
            if($request->commission>0){
                TransactionReport::create([
                    'bank_id'=>$request->bank_id,
                    'transaction_date'=>date('Y-m-d', strtotime($request->opening_date)),
                    'reason'=>'payment(Comission LC - '.$request->lc_no.')',
                    'amount'=>$request->commission,
                    'tok'=>Session::get('sellSession'),
                    'status'=>'1',
                    'created_by'=>Auth::id()
                ]);
            }
            
            // insert Insurance amount into transaction
            if($request->insurance>0){
                TransactionReport::create([
                    'bank_id'=>$request->bank_id,
                    'transaction_date'=>date('Y-m-d', strtotime($request->opening_date)),
                    'reason'=>'payment(Insurance LC - '.$request->lc_no.')',
                    'amount'=>$request->insurance,
                    'tok'=>Session::get('sellSession'),
                    'status'=>'1',
                    'created_by'=>Auth::id()
                ]);
            }
            
            // adjust amount from bank account
            $deductAmount = $request->margin_amount+$request->commission+$request->insurance;
            BankAccount::where('id', $request->bank_id)->decrement('balance', $deductAmount);

            DB::commit();
        }catch(\Exception $e){
            /*$bug=$e->errorInfo[1];
            DB::rollback();*/
            return $e->getMessage();
        }

        if($bug==0){
            Session::forget('sellSession');
            Session::flash('flash_message','LC Successfully Created !');
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
        $data['alldata']= Branch::where('status', '1')->paginate(15);
        $data['allproduct']= Product::where('status', '1')->get();
        $data['allproducttype']= ProductType::where('status', '1')->get();
        $data['allaccounts']= BankAccount::where('status', '1')->get();
        $data['allsupplier']= Supplier::where('status', '1')->get();
        $data['allimporter']= Importer::where('status', '1')->get();
        $data['allborder']= Branch::where('status', '1')->get();
        $data['single_data']=lcInfo::find($id);
        $data['alllcproducts']=LcProductDetails::where('lc_id',$id)->get();
        return view('purchase.creatLC', $data);
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
            'importer_id' => 'required',
            'exporter_id' => 'required',
            'opening_date' => 'required',
            'expire_date' => 'required',
            'shipment_date' => 'required',
            'border_id' => 'required',
            'sub_total' => 'required|numeric|gt:0',
            'dollar_rate' => 'required|numeric|gt:0',
            'total_bdt' => 'required|numeric|gt:0',
            'margin_percent' => 'required|numeric|gt:0',
            'margin_amount' => 'required|numeric|gt:0',
            'bank_due' => 'required|numeric|gt:0',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
        $data=lcInfo::findOrFail($id);
        $input = $request->all();
        if(!empty($request->opening_date)){
            $input['opening_date']=date('Y-m-d', strtotime($request->opening_date));
        }
        if(!empty($request->opening_date)){
            $input['expire_date']=date('Y-m-d', strtotime($request->expire_date));
        }
        if(!empty($request->opening_date)){
           $input['shipment_date']=date('Y-m-d', strtotime($request->shipment_date)); 
        }
        if(!empty($request->commission)){
            $input['commission']=$request->commission;
        }else{
            $input['commission']=0;
        }
        if(!empty($request->insurance)){
            $input['insurance']=$request->insurance;
        }else{
            $input['insurance']=0;
        }
        $input['created_by'] = Auth::id();
        $input['tok'] = $data->tok;

        DB::beginTransaction();
        try{
            $bug=0;
            $ttlQnty=0;
            $data->update($input);
            
            // delete old detail and insert new data
            LcProductDetails::where('lc_id', $id)->delete();
            foreach ($request->purchase_details as $value) {
                $input['lc_id'] = $id;
                $input['product_type_id'] = $value['product_type_id'];
                $input['product_id'] = $value['product_id'];
                $input['unit_price'] = $value['unit_price'];
                $input['quantity'] = $value['quantity'];
                $input['tok'] = $data->tok;
                $input['created_by'] = Auth::id();
                LcProductDetails::create($input);
                
                $ttlQnty += $value['quantity'];
            }
            // update ttl qnty
            $update= lcInfo::where('id', $id)->update(['total_qnty'=>$ttlQnty]);
            
            // delete old detail and insert margin amount into transaction
            $oldMarginDataCount = TransactionReport::where([['tok', $data->tok],['reason', 'LIKE', '%Margin LC%']])->count();
            if($oldMarginDataCount==1){
                $oldMarginData = TransactionReport::where([['tok', $data->tok],['reason', 'LIKE', '%Margin LC%']])->first();
                BankAccount::where('id', $data->bank_id)->increment('balance', $oldMarginData->amount);
                $oldMarginData->delete();
            }
            if($request->margin_amount>0){
                TransactionReport::create([
                    'bank_id'=>$data->bank_id,
                    'transaction_date'=>date('Y-m-d', strtotime($request->opening_date)),
                    'reason'=>'payment(Margin LC - '.$request->lc_no.')',
                    'amount'=>$request->margin_amount,
                    'tok'=>$data->tok,
                    'status'=>'1',
                    'created_by'=>Auth::id()
                ]);
            }
            
            // delete old detail and insert Comission amount into transaction
            $oldComissionDataCount = TransactionReport::where([['tok', $data->tok],['reason', 'LIKE', '%Comission LC%']])->count();
            if($oldComissionDataCount==1){
                $oldComissionData = TransactionReport::where([['tok', $data->tok],['reason', 'LIKE', '%Comission LC%']])->first();
                BankAccount::where('id', $data->bank_id)->increment('balance', $oldComissionData->amount);
                $oldComissionData->delete();
            }
            if($request->commission>0){
                TransactionReport::create([
                    'bank_id'=>$data->bank_id,
                    'transaction_date'=>date('Y-m-d', strtotime($request->opening_date)),
                    'reason'=>'payment(Comission LC - '.$request->lc_no.')',
                    'amount'=>$request->commission,
                    'tok'=>$data->tok,
                    'status'=>'1',
                    'created_by'=>Auth::id()
                ]);
            }
            
            // delete old detail and insert Insurance amount into transaction
            $oldInsuranceDataCount = TransactionReport::where([['tok', $data->tok],['reason', 'LIKE', '%Insurance LC%']])->count();
            if($oldInsuranceDataCount==1){
                $oldInsuranceData = TransactionReport::where([['tok', $data->tok],['reason', 'LIKE', '%Insurance LC%']])->first();
                BankAccount::where('id', $data->bank_id)->increment('balance', $oldInsuranceData->amount);
                $oldInsuranceData->delete();
            }
            if($request->insurance>0){
                TransactionReport::create([
                    'bank_id'=>$data->bank_id,
                    'transaction_date'=>date('Y-m-d', strtotime($request->opening_date)),
                    'reason'=>'payment(Insurance LC - '.$request->lc_no.')',
                    'amount'=>$request->insurance,
                    'tok'=>$data->tok,
                    'status'=>'1',
                    'created_by'=>Auth::id()
                ]);
            }
            
            // adjust amount from bank account
            $deductAmount = $request->margin_amount+$request->commission+$request->insurance;
            BankAccount::where('id', $request->bank_id)->decrement('balance', $deductAmount);

            DB::commit();
        }catch(\Exception $e){
            /*$bug=$e->errorInfo[1];
            DB::rollback();*/
            return $e->getMessage();
        }

        if($bug==0){
            Session::forget('sellSession');
            Session::flash('flash_message','LC Successfully Created !');
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
        //
    }
    
    public function completeLC($id){
        $data=lcInfo::findOrFail($id);
        $input['status']='2';
        try{
            $bug=0;
            $data->update($input);
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','LC Successfully Completed !');
            return redirect()->back()->with('status_color','warning');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
}
