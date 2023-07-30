<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\BankAccount;
use App\Models\Customer;
use App\Models\ProductSellDetails;
use App\Models\ProductSell;
use App\Models\TransactionReport;
use App\Models\Transaction;
use App\Models\CustomerLedger;
use App\Models\GiftPoint;
use Validator;
use Response;
use Session;
use Auth;
use DB;

class PosSellController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$data['alldata']= Product::all();
        $data['alldata'] = DB::table('product')
            ->join('stock_product', 'product.id', '=', 'stock_product.product_id')
            ->where('product.status', '1')
            ->where('stock_product.quantity', '>', '0')
            ->select('product.*')
            ->get();
        $data['allsellreport']= ProductSell::orderBy('id', 'DESC')->get();
        $data['allbank']= BankAccount::where('status', '1')->get();
        $data['allcustomer']= Customer::where('status', '1')->orderBy('id', 'DESC')->get();
        return view('sell.posSell', $data);
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
            'multiple.*.product_id' => 'required',
            'multiple.*.quantity' => 'required',
            'multiple.*.unit_price' => 'required',
            'multiple.*.vat_amount' => 'required',
            'sell_date' => 'required',
        ]);
        if ($validator->fails()) {
            $msg = "Validation Failed";
            return Response::json($msg);
        }

        $input = $request->all();

        if (empty(Session::has('sellSession'))) {
            $tok = md5(date("Ymdhis"));
            // creating a session variable
            Session::put('sellSession', $tok);
        }
        $input['session'] = Session::get('sellSession');
        
        if (empty(Session::has('tokToken'))) {
            //$tok = md5(date("Ymdhis"));
            $tok = date("Ymdhis");
            // creating a session variable
            Session::put('tokToken', $tok);
        }

        DB::beginTransaction();
        try{
            $bug=0;

            foreach ($request->multiple as $key => $value) {
                $input['customer_id'] = $request->customer_id;
                $input['product_id'] = $value['product_id'];
                $input['unit_price'] = $value['unit_price'];
                $input['quantity'] = $value['quantity'];
                $input['vat_amount'] = $value['vat_amount'];
                $input['sell_date'] = $request->sell_date;
                $input['tok'] = Session::get('tokToken');
                $input['created_by'] = Auth::id();
                $input['session'] = Session::get('sellSession');
                $insert= ProductSellDetails::create($input);

                // updating stock product
                $update=DB::table('stock_product')->where('product_id', $value['product_id'])->decrement('quantity', $value['quantity']);
            }

            $insert= ProductSell::create([
                'customer_id'=>$request->customer_id,
                'payment_method'=>$request->payment_method,
                'sub_total'=>$request->sub_total,
                'discount'=>$request->discount,
                'paid_amount'=>$request->paid_amount,
                'total_vat'=>$request->total_vat,
                'sell_date'=>$request->sell_date,
                'tok'=>Session::get('tokToken'),
                'pos_or_direct_sell'=>0,
                'created_by'=>Auth::id(),
            ]);

            // Inserting into customer_ledger table
            $insert= CustomerLedger::create([
                'date'=>$request->sell_date,
                'bank_id'=>$request->payment_method,
                'customer_id'=>$request->customer_id,
                'amount'=>$request->grand_total,
                'reason'=>'sell',
                'tok'=>Session::get('tokToken'),
                'created_by'=>Auth::id()
            ]);

            // creating gift point table, suppose 100 taka is 1 point
            $achievePoint = $request->sub_total/100;
            $insertIntoGiftPoint = GiftPoint::create([
                'customer_id'=>$request->customer_id,
                'bill_amount'=>$request->sub_total,
                'achieve_point'=>$achievePoint,
                'date'=>date('Y-m-d'),
                'tok'=>Session::get('tokToken')
            ]);

            if ($request->paid_amount != '0' || $request->paid_amount > '0') {
                $insertIntoReport = TransactionReport::create([
                    'bank_id'=>$request->payment_method,
                    'transaction_date'=>$request->sell_date,
                    'reason'=>'receive(sell)',
                    'amount'=>$request->paid_amount,
                    'tok'=>Session::get('tokToken'),
                    'status'=>'1',
                    'created_by'=>Auth::id()
                ]);

                $insertIntoTransaction = Transaction::create([
                    'date'=>$request->sell_date,
                    'reason'=>'Receive(sell)',
                    'amount'=>$request->paid_amount,
                    'tok'=>Session::get('tokToken'),
                    'status'=>'1',
                    'created_by'=>Auth::id()
                ]);
                // Inserting into customer_ledger table
                $insert= CustomerLedger::create([
                    'date'=>$request->sell_date,
                    'bank_id'=>$request->payment_method,
                    'customer_id'=>$request->customer_id,
                    'amount'=>$request->paid_amount,
                    'reason'=>'receive',
                    'tok'=>Session::get('tokToken'),
                    'created_by'=>Auth::id()
                ]);
                // updating bank balance
                $update=DB::table('bank_account')->where('id', $request->payment_method)->increment('balance', $request->paid_amount);
            }

            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            $msg = "success";
            return Response::json($msg);
        }else{
            $msg = "Sorry ! Something Went Wrong";
            return Response::json($msg);
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

    public function findProductDetailWithBarcode(Request $request)
    {
        //$packageDetails = Product::where('id',$request->id)->where('status', '1')->first();
        
        $packageDetails = DB::table('product')
            ->join('stock_product', 'product.id', '=', 'stock_product.product_id')
            ->where('product.bar_code', $request->id)
            ->where('product.status', '1')
            ->select('product.*', 'stock_product.quantity')
            ->first();
        return Response::json($packageDetails);
        die;
    }

    public function findProductListWithKeyword(Request $request)
    {
        if (!empty($request->id)) {
            //$productDetails = Product::where('name', 'like', '%' . $request->id . '%')->get();
            $productDetails = DB::table('product')
            ->join('stock_product', 'product.id', '=', 'stock_product.product_id')
            ->where('product.status', '1')
            ->where('product.bar_code', $request->id)
            ->where('stock_product.quantity', '>', '0')
            ->select('product.*')
            ->get();
            return Response::json($productDetails);
        }else{
            //$productDetails = Product::all();
            $productDetails = DB::table('product')
            ->join('stock_product', 'product.id', '=', 'stock_product.product_id')
            ->where('product.status', '1')
            ->where('stock_product.quantity', '>', '0')
            ->select('product.*')
            ->get();
            return Response::json($productDetails);
        }
        //die;
    }

    public function printInvoice(Request $request)
    {
        //$sellDetails = ProductSellDetails::where('session', Session::get('sellSession'))->get();

        $sellDetails = DB::table('product_sell_details')
            ->join('product_sell', 'product_sell_details.tok', '=', 'product_sell.tok')
            ->join('product', 'product_sell_details.product_id', '=', 'product.id')
            ->where('product_sell_details.session', Session::get('sellSession'))
            ->select('product_sell_details.*', 'product.name', 'product_sell.discount')
            ->get();

        //$packageDetails = 1;
        Session::forget('sellSession');
        Session::forget('tokToken');
        return Response::json($sellDetails);
        die;
    }
}
