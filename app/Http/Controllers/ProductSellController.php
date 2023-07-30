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
use App\Models\StockProductDetail;
use Validator;
use Response;
use Session;
use Auth;
use DB;
use URL;


class ProductSellController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['allbank']= BankAccount::where('status', '1')->get();
        $data['allcustomer']= Customer::where('status', '1')->get();
        $data['allproduct']= Product::where('status', '1')->get();
        return view('sell.productSell', $data);
    }
    
    public function createJobCard($id)
    {
        //$data['alldata']= Product::where('status', '1')->get();
        $data['alldata'] = DB::table('product')
            ->join('stock_product', 'product.id', '=', 'stock_product.product_id')
            ->where('product.status', '1')
            ->where('stock_product.quantity', '>', '0')
            ->select('product.*')
            ->get();
        $data['allbank']= BankAccount::where('status', '1')->get();
        $data['alltechnician']= Technician::where('status', '1')->get();
        $data['singlecustomer']= Customer::where('id', $id)->first();
        return view('sell.productSell', $data);
    }
    
    public function customerList()
    {
        $data['alldata']= Customer::get();
        return view('sell.customerList', $data);
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
        die;*/
        
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'sell_date' => 'required',
            'branch_id' => 'required',
            'sub_total' => 'required|numeric|gt:0',
            'bank_id' => 'required',
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
            $ttlPurchase = 0;
            $ttlQnty = 0;
            $truck_no = 0;
            $qnty = 0;
            $unitPrice = 0;
            foreach ($request->sell_details as $value) {
                $input['customer_id'] = $request->customer_id;
                $input['product_id'] = $value['product_id'];
                $input['truck_no'] = $value['truck_no'];
                $input['unit_price'] = $value['unit_price'];
                $input['quantity'] = $value['quantity'];
                $input['sell_date'] = $request->sell_date;
                $input['tok'] = Session::get('sellSession');
                $input['created_by'] = Auth::id();
                $insert= ProductSellDetails::create($input);
                $ttlQnty += $value['quantity'];
                $truck_no=$value['truck_no'];
                $qnty=$value['quantity'];
                $unitPrice += $value['unit_price'];
                // update stock
                DB::table('stock_product')->where([['product_id', $value['product_id']],['branch_id',$request->branch_id]])->decrement('quantity', $value['quantity']);
            }
            
            $insert= ProductSell::create([
                'customer_id' => $request->customer_id,
                'bank_id' => $request->bank_id,
                'sell_date' => $request->sell_date,
                'truck_no' => $request->truck_no,
                'note' => $request->note,
                'branch_id' => $request->branch_id,
                'total_qnty' => $ttlQnty,
                'tok' => Session::get('sellSession'),
                'sub_total' => $request->sub_total,
                'paid_amount' => $request->paid_amount,
                'created_by' => Auth::id()
            ]);

            // Inserting into customer_ledger table
            $insert= CustomerLedger::create([
                'date'=>$request->sell_date,
                'bank_id'=>$request->bank_id,
                'customer_id'=>$request->customer_id,
                'truck_no'=>$truck_no,
                'quantity'=>$qnty,
                'unit_price'=>$unitPrice,
                'amount'=>$request->sub_total,
                'reason'=>'sell',
                'note'=>$request->note,
                'tok'=>Session::get('sellSession'),
                'created_by'=>Auth::id()
            ]);
           
            if ($request->paid_amount != '0' || $request->paid_amount > '0') {
                $insertIntoReport = TransactionReport::create([
                    'bank_id'=>$request->bank_id,
                    'transaction_date'=>$request->sell_date,
                    'reason'=>'receive(sell paid)',
                    'amount'=>$request->paid_amount,
                    'tok'=>Session::get('sellSession'),
                    'status'=>'1',
                    'created_by'=>Auth::id()
                ]);
                $insertIntoTransaction = Transaction::create([
                    'date'=>$request->sell_date,
                    'reason'=>'Receive(sell paid)',
                    'amount'=>$request->paid_amount,
                    'tok'=>Session::get('sellSession'),
                    'status'=>'1',
                    'created_by'=>Auth::id()
                ]);
                // Inserting into customer_ledger table
                $insert= CustomerLedger::create([
                    'date'=>$request->sell_date,
                    'bank_id'=>$request->bank_id,
                    'customer_id'=>$request->customer_id,
                    'amount'=>$request->paid_amount,
                    'reason'=>'receive',
                    'note'=>$request->note,
                    'tok'=>Session::get('sellSession'),
                    'created_by'=>Auth::id()
                ]);
                // updating bank balance
                $update=DB::table('bank_account')->where('id', $request->bank_id)->increment('balance', $request->paid_amount);
            }
            DB::commit();
        }catch(\Exception $e){
            //$bug=$e->errorInfo[1];
            $bug=$e->getMessage();
            DB::rollback();
        }

        if($bug==0){
            Session::forget('sellSession');
            Session::flash('flash_message','Sale Saved ! Collect Invoice');
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

    public function findUnitPriceWithPackageId(Request $request)
    {
        $packageDetails = ProductPackage::select('price')->where('id',$request->id)->where('status', '!=', '0')->get();
        return Response::json($packageDetails);
        die;
    }

    public function showReport(Request $request)
    {
        $data['alldata']= ProductSell::orderBy('id', 'DESC')->paginate(250);
        return view('sell.sellReport', $data);
    }

    public function showReportFilter(Request $request)
    {
        if ($request->search && $request->start_date !="" && $request->end_date !="" && $request->input =="") {
            $data['alldata']= ProductSell::whereBetween('job_card_date', [$request->start_date, $request->end_date])->orderBy('id', 'DESC')->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('sell.sellReport', $data);
        }elseif ($request->search && $request->start_date =="" && $request->end_date =="" && $request->input !="") {
            $data['alldata']= ProductSell::join('customer', 'customer.id', '=', 'product_sell.customer_id')->where('customer.name', 'like', '%' . $request->input . '%')->orWhere('product_sell.job_card_no', 'like', '%' . $request->input . '%')->orWhere('product_sell.reg_no', 'like', '%' . $request->input . '%')->select('product_sell.*')->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('sell.sellReport', $data);
        }elseif ($request->search && $request->start_date !="" && $request->end_date !="" && $request->input !="") {
            $data['alldata']= ProductSell::join('customer', 'customer.id', '=', 'product_sell.customer_id')->whereBetween('product_sell.job_card_date', [$request->start_date, $request->end_date])->where('customer.name', 'like', '%' . $request->input . '%')->orWhere('product_sell.job_card_no', 'like', '%' . $request->input . '%')->orWhere('product_sell.reg_no', 'like', '%' . $request->input . '%')->select('product_sell.*')->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('sell.sellReport', $data);
        }else{
            $data['alldata']= ProductSell::orderBy('id', 'DESC')->paginate(250);
            return view('sell.sellReport', $data);
        }
    }

    public function sellInvoice(Request $request)
    {
        $data['alldata']= ProductSellDetails::where('tok', $request->id)->get();
        $data['singleData']= ProductSell::where('tok', $request->id)->first();
        $data['siteInfo']= SiteSetting::where('id', 1)->first();
        return view('sell.sellInvoice', $data);
    }

    public function productWiseSellReport(Request $request)
    {
        $data['alldata']= ProductSellDetails::orderBy('id', 'DESC')->paginate(250);
        return view('sell.productWiseSellReport', $data);
    }

    public function productWiseSellReportFilter(Request $request)
    {
        if ($request->search && $request->start_date !="" && $request->end_date !="" && $request->name =="") {
            $data['alldata']= ProductSellDetails::whereBetween('sell_date', [$request->start_date, $request->end_date])->orderBy('id', 'DESC')->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('sell.productWiseSellReport', $data);
        }elseif ($request->search && $request->start_date =="" && $request->end_date =="" && $request->name !="") {
            $data['alldata']= ProductSellDetails::join('product', 'product.id', '=', 'product_sell_details_for_report.product_id')->where('product.name', 'like', '%' . $request->name . '%')->select('product_sell_details_for_report.*')->orderBy('product_sell_details_for_report.id', 'DESC')->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('sell.productWiseSellReport', $data);
        }elseif ($request->search && $request->start_date !="" && $request->end_date !="" && $request->name !="") {
            $data['alldata']= ProductSellDetails::join('product', 'product.id', '=', 'product_sell_details_for_report.product_id')->whereBetween('product_sell_details_for_report.sell_date', [$request->start_date, $request->end_date])->where('product.name', 'like', '%' . $request->name . '%')->select('product_sell_details_for_report.*')->orderBy('product_sell_details_for_report.id', 'DESC')->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('sell.productWiseSellReport', $data);
        }else{
            $data['alldata']= ProductSellDetails::orderBy('id', 'DESC')->paginate(250);
            return view('sell.productWiseSellReport', $data);
        }
    }

    public function findProductDetailWithBranchId(Request $request)
    {
        $packageDetails = DB::table('stock_product')
            ->join('product', 'product.id', '=', 'stock_product.product_id')
            ->where('stock_product.branch_id', $request->branch_id)
            ->where('stock_product.quantity', '>', '0')
            ->select('product.id','product.name','stock_product.quantity')
            ->get();
        
        return Response::json($packageDetails);
        die;
    }
    
    public function deleteAddedService($cid, $tok)
    {

        //delete service
        $delete = DB::table('sell_service_details')->where([['id', $cid],['tok', $tok]])->delete();
        
        $getRestServiceTotal = DB::table('sell_service_details')->where('tok', $tok)->sum('cost');
        $getRestProductTotal = DB::table('product_sell_details')->where('tok', $tok)->sum(DB::raw('unit_price*quantity'));
        $getJobCardInfo = DB::table('product_sell')->where('tok', $tok)->first();
        $totalVatAmount = ($getRestServiceTotal*$getJobCardInfo->vat_percent)/100;
        // get total amount
        $getTotalAmount = $getRestProductTotal+$getRestServiceTotal+$totalVatAmount;
        
        $update = DB::table('product_sell')->where('tok', $tok)->update(['total_amount'=>$getTotalAmount,'vat_amount'=>$totalVatAmount]);
        $update = DB::table('customer_ledger')->where([['tok', $tok],['reason', 'LIKE', '%sell%']])->update(['amount'=>$getTotalAmount]);
        
        
        return redirect()->back()->with('status_color','success');
    }
    
    public function deleteAddedParts($cid, $tok)
    {

        //delete service
        $deleteInfo = DB::table('product_sell_details')->where([['product_id', $cid],['tok', $tok]])->sum('quantity');
        $increment = DB::table('stock_product')->where('product_id', $cid)->increment('quantity', $deleteInfo);
        $delete = DB::table('product_sell_details')->where([['product_id', $cid],['tok', $tok]])->delete();
        $delete = DB::table('product_sell_details_for_report')->where([['product_id', $cid],['tok', $tok]])->delete();
        
        $getRestServiceTotal = DB::table('sell_service_details')->where('tok', $tok)->sum('cost');
        $getRestProductTotal = DB::table('product_sell_details')->where('tok', $tok)->sum(DB::raw('unit_price*quantity'));
        $getRestProductQntyTotal = DB::table('product_sell_details')->where('tok', $tok)->sum('quantity');
        $getRestProductPurchaseTotal = DB::table('product_sell_details')->where('tok', $tok)->sum(DB::raw('purchase_value*quantity'));
        $getJobCardInfo = DB::table('product_sell')->where('tok', $tok)->first();
        $totalVatAmount = ($getRestServiceTotal*$getJobCardInfo->vat_percent)/100;
        // get total amount
        $getTotalAmount = $getRestProductTotal+$getRestServiceTotal+$totalVatAmount;
        
        $update = DB::table('product_sell')->where('tok', $tok)->update(['total_amount'=>$getTotalAmount,'total_qnty'=>$getRestProductQntyTotal,'purchase_value'=>$getRestProductPurchaseTotal]);
        $update = DB::table('customer_ledger')->where([['tok', $tok],['reason', 'LIKE', '%sell%']])->update(['amount'=>$getTotalAmount]);
        
        
        return redirect()->back()->with('status_color','success');
    }
    
    public function deleteAddedServiceFromSavedQuotation($cid, $tok)
    {

        //delete service
        $delete = DB::table('service_details_for_save_quotation')->where([['id', $cid],['tok', $tok]])->delete();
        
        $getRestServiceTotal = DB::table('service_details_for_save_quotation')->where('tok', $tok)->sum('cost');
        $getRestProductTotal = DB::table('product_details_for_save_quotation')->where('tok', $tok)->sum(DB::raw('unit_price*quantity'));
        $getJobCardInfo = DB::table('save_quotation')->where('tok', $tok)->first();
        $totalVatAmount = ($getRestServiceTotal*$getJobCardInfo->vat_percent)/100;
        // get total amount
        $getTotalAmount = $getRestProductTotal+$getRestServiceTotal+$totalVatAmount;
        
        $update = DB::table('save_quotation')->where('tok', $tok)->update(['total_amount'=>$getTotalAmount,'vat_amount'=>$totalVatAmount]);
        
        
        return redirect()->back()->with('status_color','success');
    }
    
    public function deleteAddedPartsFromSavedQuotation($cid, $tok)
    {

        //delete service
        $deleteInfo = DB::table('product_details_for_save_quotation')->where([['product_id', $cid],['tok', $tok]])->sum('quantity');
        $delete = DB::table('product_details_for_save_quotation')->where([['product_id', $cid],['tok', $tok]])->delete();
        
        $getRestServiceTotal = DB::table('service_details_for_save_quotation')->where('tok', $tok)->sum('cost');
        $getRestProductTotal = DB::table('product_details_for_save_quotation')->where('tok', $tok)->sum(DB::raw('unit_price*quantity'));
        $getRestProductQntyTotal = DB::table('product_details_for_save_quotation')->where('tok', $tok)->sum('quantity');
        $getRestProductPurchaseTotal = DB::table('product_details_for_save_quotation')->where('tok', $tok)->sum(DB::raw('purchase_value*quantity'));
        $getJobCardInfo = DB::table('save_quotation')->where('tok', $tok)->first();
        $totalVatAmount = ($getRestServiceTotal*$getJobCardInfo->vat_percent)/100;
        // get total amount
        $getTotalAmount = $getRestProductTotal+$getRestServiceTotal+$totalVatAmount;
        
        $update = DB::table('save_quotation')->where('tok', $tok)->update(['total_amount'=>$getTotalAmount,'total_qnty'=>$getRestProductQntyTotal,'purchase_value'=>$getRestProductPurchaseTotal]);
        
        
        return redirect()->back()->with('status_color','success');
    }
    
    public function findproductDetailWithId(Request $request)
    {
        $bookDetails = DB::table('stock_product')->where([['branch_id', '0'],['product_id', $request->id]])
            ->select('stock_product.quantity')
            ->first();
        return Response::json($bookDetails);
        die;
    }
}
