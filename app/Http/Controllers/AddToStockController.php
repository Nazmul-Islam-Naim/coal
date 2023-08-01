<?php

namespace App\Http\Controllers;

use App\Models\lcInfo;
use App\Models\LcProductStatus;
use Illuminate\Http\Request;
use App\Models\BankAccount;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\ProductPurchase;
use App\Models\StockProduct;
use App\Models\ProductPurchaseDetails;
use App\Models\SupplierLedger;
use App\Models\TransactionReport;
use App\Models\Transaction;
use App\Models\StockProductDetail;
use Validator;
use Session;
use Response;
use Auth;
use DB;

class AddToStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['allbank']= BankAccount::where('status', '1')->get();
        $data['allsupplier']= Supplier::where('status', '1')->get();
        $data['allproduct']= Product::where('status', '1')->get();

        $data['lcInfos']= lcInfo::where('status', '1')->get();
        $data['lcProducts'] = LcProductStatus::where('due_quantity', '>', 0)->get();
        return view('purchase.add-to-stock', $data);
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
            'product_type_id' => 'required',
            'stock_date' => 'required',
            'sub_total' => 'required|numeric|gt:0',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }

        $input = $request->all();
      
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
            foreach ($request->purchase_details as $value) {
                // Creating product Stock
                $stockProduct = StockProduct::where([['product_id', $value['product_id']],['branch_id', '0']])->first();
                if (!empty($stockProduct)) {
                    
                    $stockProductPrice = $stockProduct->quantity * $stockProduct->unit_price; 
                    $purchaseProductPrice = $value['quantity'] * $value['unit_price'];
                    $amendmentProductPrice = $stockProductPrice + $purchaseProductPrice;

                    $stockProductQuantity = $stockProduct->quantity + $value['quantity'];
                    
                    if ($stockProductQuantity == 0) {
                        $productAvgPrice = 0;
                    } else {
                        $productAvgPrice = $amendmentProductPrice / $stockProductQuantity;
                    }

                    $stockProduct->update([
                        'quantity' => $stockProductQuantity,
                        'unit_price' => $productAvgPrice,
                    ]);

                }else{
                    StockProduct::create([
                        'branch_id'=>'0',
                        'product_id'=>$value['product_id'],
                        'quantity'=>$value['quantity'],
                        'unit_price'=>$value['unit_price'],
                        'status'=>'1'
                    ]);
                }
                
                StockProductDetail::create([
                    'date'=>date('Y-m-d', strtotime($request->stock_date)),
                    'branch_id'=>'0',
                    'product_type_id'=>$stockProduct->stockproduct_product_object->product_type_id ?? 1,
                    'product_id'=>$value['product_id'],
                    'quantity'=>$value['quantity'],
                    'unit_price'=>$value['unit_price'],
                    'reason'=>'Add to Stock',
                    'note'=>$request->note,
                    'tok'=>Session::get('sellSession'),
                    'status'=>'1'
                ]);

                LcProductStatus::where([['product_id', $value['product_id']],['lc_no', $request->product_type_id]])->increment('receive_quantity', $value['quantity']);
                LcProductStatus::where([['product_id', $value['product_id']],['lc_no', $request->product_type_id]])->decrement('due_quantity', $value['quantity']);
                
                $ttlQnty += $value['quantity'];
            }

            DB::commit();
        }catch(\Exception $e){
            /*$bug=$e->errorInfo[1];
            DB::rollback();*/
            return $e->getMessage();
        }

        if($bug==0){
            Session::forget('sellSession');
            Session::flash('flash_message','Product Successfully Added to Stock !');
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
        $data = Cart::findOrFail($id);
        $action = $data->delete();

        if($action){
            Session::flash('flash_message','Product Successfully Deleted !');
            return redirect()->back()->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    public function showReport(Request $request)
    {
        $data['alldata']= ProductPurchase::paginate(250);
        return view('purchase.purchaseReport', $data);
    }

    public function filter(Request $request)
    {
        if ($request->start_date !="" && $request->end_date !="" && $request->input =="") {
            $data['alldata']= ProductPurchase::whereBetween('purchase_date', [$request->start_date, $request->end_date])->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('purchase.purchaseReport', $data);
        }elseif ($request->start_date =="" && $request->end_date =="" && $request->input !="") {
            $data['alldata']= ProductPurchase::join('supplier', 'supplier.id', '=', 'product_purchase.supplier_id')->where('supplier.name', 'like', '%' . $request->input . '%')->select('product_purchase.*')->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('purchase.purchaseReport', $data);
        }elseif ($request->start_date !="" && $request->end_date !="" && $request->input !="") {
            $data['alldata']= ProductPurchase::join('supplier', 'supplier.id', '=', 'product_purchase.supplier_id')->whereBetween('product_purchase.purchase_date', [$request->start_date, $request->end_date])->where('supplier.name', 'like', '%' . $request->input . '%')->select('product_purchase.*')->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('purchase.purchaseReport', $data);
        }
    }

    public function showDetailsReport($id)
    {
        $data['alldata'] = ProductPurchaseDetails::where('tok', $id)->get();
        $data['singledata'] =  ProductPurchase::where('tok', $id)->first();
        return view('purchase.purchaseDetailRepost', $data);
    }
    
    public function showProductWiseReport()
    {
        $data['alldata'] = ProductPurchaseDetails::all();
        return view('purchase.productWisePurchaseDetailRepost', $data);
    }
    
    public function showProductWiseReportFilter(Request $request)
    {
        if ($request->start_date !="" && $request->end_date !="" && $request->input =="") {
            $data['alldata']= ProductPurchaseDetails::whereBetween('purchase_date', [$request->start_date, $request->end_date])->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('purchase.productWisePurchaseDetailRepost', $data);
        }elseif ($request->start_date =="" && $request->end_date =="" && $request->input !="") {
            $data['alldata']= ProductPurchaseDetails::join('product', 'product.id', '=', 'product_purchase_details.product_id')->where('product.name', 'like', '%' . $request->input . '%')->select('product_purchase_details.*')->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('purchase.productWisePurchaseDetailRepost', $data);
        }elseif ($request->start_date !="" && $request->end_date !="" && $request->input !="") {
            $data['alldata']= ProductPurchaseDetails::join('product', 'product.id', '=', 'product_purchase_details.product_id')->whereBetween('product_purchase_details.purchase_date', [$request->start_date, $request->end_date])->where('product.name', 'like', '%' . $request->input . '%')->select('product_purchase_details.*')->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('purchase.productWisePurchaseDetailRepost', $data);
        }
    }
    
    public function discountOnPurchase(Request $request)
    {
        $data['alldata']= ProductPurchase::paginate(250);
        return view('purchase.discountOnPurchaseReport', $data);
    }
    
    public function saveDiscountOnPurchase(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required',
            'discount' => 'required|gt:0',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }

        $input = $request->all();
      
        $input['created_by'] = Auth::id();

        DB::beginTransaction();
        try{
            $bug=0;

            // Inserting into purchase product table
            $update=ProductPurchase::where('tok', $request->tok)->increment('discount',$request->discount);

            // Inserting into supplier_ledger table
            $insert= SupplierLedger::create([
                'date'=>date('Y-m-d'),
                'supplier_id'=>$request->supplier_id,
                'amount'=>$request->discount,
                'reason'=>'payment(discount)',
                'tok'=>$request->tok,
                'created_by'=>Auth::id()
            ]);

            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::forget('sellSession');
            Session::flash('flash_message','Discount Successfully Added !');
            return redirect()->back()->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        } 
    }
    
    public function getTypeWiseProduct(Request $request)
    {
        $productDetails = DB::table('product')
            ->where('product.status', '1')
            ->where('product.product_type_id', $request->type_id)
            ->select('product.id','product.name')
            ->get();
        return Response::json($productDetails);
        die;
    }
    
    public function lcProduct(Request $request)
    {
        $productDetails = DB::table('lc_product_statuses')
            ->join('product', 'lc_product_statuses.product_id', 'product.id')
            ->where('lc_product_statuses.lc_no', $request->type_id)
            ->where('lc_product_statuses.due_quantity', '>', 0)
            ->select('product.id','product.name')
            ->get();
        return Response::json($productDetails);
        die;
    }
}
