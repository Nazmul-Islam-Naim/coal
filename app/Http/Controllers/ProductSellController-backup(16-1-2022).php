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
       //
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
            'job_card_no' => 'required',
            'customer_id' => 'required',
            'total_amount' => 'required|numeric|gt:0',
            'payment_method' => 'required',
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
            
            foreach ($request->service_details as $value) {
                $input['customer_id'] = $request->customer_id;
                $input['instruction'] = $value['instruction'];
                $input['cost'] = $value['cost'];
                $input['technician_id'] = $value['technician_id'];
                $input['sell_date'] = date('Y-m-d');
                $input['tok'] = Session::get('sellSession');
                $input['job_card_no'] = $request->job_card_no;
                $input['created_by'] = Auth::id();
                $insert= SellServiceDetails::create($input);
            }
            
            foreach ($request->parts_details as $value) {
                $input2['customer_id'] = $request->customer_id;
                $input2['product_id'] = $value['product_id'];
                $input2['unit_price'] = $value['unit_price'];
                $input2['quantity'] = $value['quantity'];
                $input2['sell_date'] = date('Y-m-d');
                $input2['tok'] = Session::get('sellSession');
                $input2['job_card_no'] = $request->job_card_no;
                $input2['created_by'] = Auth::id();
                $insert= ProductSellDetails::create($input2);
                
                // updating stock product
                $update=DB::table('stock_product')->where('product_id', $value['product_id'])->decrement('quantity', $value['quantity']);
            }
            
            $insert= ProductSell::create([
                'customer_id'=>$request->customer_id,
                'job_card_no'=>$request->job_card_no,
                'job_card_date'=>date('Y-m-d'),
                'receive_date_time'=>$request->receive_date_time,
                'delivery_date_time'=>$request->delivery_date_time,
                'reg_no'=>$request->reg_no,
                'car_band'=>$request->car_band,
                'car_engine'=>$request->car_engine,
                'car_vin'=>$request->car_vin,
                'car_odometer'=>$request->car_odometer,
                'total_amount'=>$request->total_amount,
                'advance'=>$request->advance,
                'vat_percent'=>$request->vat_percent,
                'vat_amount'=>$request->vat_amount,
                'paid_amount'=>$request->advance,
                'payment_method'=>$request->payment_method,
                'tok'=>Session::get('sellSession'),
                'created_by'=>Auth::id(),
            ]);

            // Inserting into customer_ledger table
            $insert= CustomerLedger::create([
                'date'=>date('Y-m-d'),
                'bank_id'=>$request->payment_method,
                'customer_id'=>$request->customer_id,
                'amount'=>$request->total_amount,
                'reason'=>'sell',
                'tok'=>Session::get('sellSession'),
                'job_card_no'=>$request->job_card_no,
                'created_by'=>Auth::id()
            ]);
           
            if ($request->advance != '0' || $request->advance > '0') {
                $insertIntoReport = TransactionReport::create([
                    'bank_id'=>$request->payment_method,
                    'transaction_date'=>date('Y-m-d'),
                    'reason'=>'receive(sell advance)',
                    'amount'=>$request->advance,
                    'tok'=>Session::get('sellSession'),
                    'job_card_no'=>$request->job_card_no,
                    'status'=>'1',
                    'created_by'=>Auth::id()
                ]);
                $insertIntoTransaction = Transaction::create([
                    'date'=>date('Y-m-d'),
                    'reason'=>'Receive(sell advance)',
                    'amount'=>$request->advance,
                    'tok'=>Session::get('sellSession'),
                    'job_card_no'=>$request->job_card_no,
                    'status'=>'1',
                    'created_by'=>Auth::id()
                ]);
                // Inserting into customer_ledger table
                $insert= CustomerLedger::create([
                    'date'=>date('Y-m-d'),
                    'bank_id'=>$request->payment_method,
                    'customer_id'=>$request->customer_id,
                    'amount'=>$request->advance,
                    'reason'=>'receive',
                    'tok'=>Session::get('sellSession'),
                    'job_card_no'=>$request->job_card_no,
                    'created_by'=>Auth::id()
                ]);
                // updating bank balance
                $update=DB::table('bank_account')->where('id', $request->payment_method)->increment('balance', $request->advance);
            }
            DB::commit();
        }catch(\Exception $e){
            //$bug=$e->errorInfo[1];
            $bug=$e->getMessage();
            DB::rollback();
        }

        if($bug==0){
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
            $data['alldata']= ProductSell::whereBetween('sell_date', [$request->start_date, $request->end_date])->orderBy('id', 'DESC')->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('sell.sellReport', $data);
        }elseif ($request->search && $request->start_date =="" && $request->end_date =="" && $request->input !="") {
            $data['alldata']= ProductSell::join('customer', 'customer.id', '=', 'product_sell.customer_id')->where('customer.name', 'like', '%' . $request->input . '%')->orWhere('product_sell.invoice_no', 'like', '%' . $request->input . '%')->select('product_sell.*')->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('sell.sellReport', $data);
        }elseif ($request->search && $request->start_date !="" && $request->end_date !="" && $request->input !="") {
            $data['alldata']= ProductSell::join('customer', 'customer.id', '=', 'product_sell.customer_id')->whereBetween('product_sell.sell_date', [$request->start_date, $request->end_date])->where('customer.name', 'like', '%' . $request->input . '%')->orWhere('product_sell.invoice_no', 'like', '%' . $request->input . '%')->select('product_sell.*')->paginate(250);
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
            $data['alldata']= ProductSellDetails::join('product', 'product.id', '=', 'product_sell_details.product_id')->where('product.name', 'like', '%' . $request->name . '%')->select('product_sell_details.*')->orderBy('product_sell_details.id', 'DESC')->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('sell.productWiseSellReport', $data);
        }elseif ($request->search && $request->start_date !="" && $request->end_date !="" && $request->name !="") {
            $data['alldata']= ProductSellDetails::join('product', 'product.id', '=', 'product_sell_details.product_id')->whereBetween('product_sell_details.sell_date', [$request->start_date, $request->end_date])->where('product.name', 'like', '%' . $request->name . '%')->select('product_sell_details.*')->orderBy('product_sell_details.id', 'DESC')->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('sell.productWiseSellReport', $data);
        }else{
            $data['alldata']= ProductSellDetails::orderBy('id', 'DESC')->paginate(250);
            return view('sell.productWiseSellReport', $data);
        }
    }

    public function findProductDetailWithId(Request $request)
    {
        //$packageDetails = Product::where('id',$request->id)->where('status', '1')->first();
        
        $packageDetails = DB::table('product')
            ->join('stock_product', 'product.id', '=', 'stock_product.product_id')
            ->where('product.id', $request->id)
            ->where('product.status', '1')
            ->select('product.*', 'stock_product.quantity', 'stock_product.unit_price')
            ->first();
        return Response::json($packageDetails);
        die;
    }
}
