<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductReturn;
use App\Models\ProductReturnToSupplier;
use App\Models\ProductSell;
use App\Models\ProductSellDetails;
use App\Models\ProductPurchase;
use App\Models\ProductPurchaseDetails;
use App\Models\ProductWastageDetails;
use App\Models\Product;
use App\Models\BankAccount;
use App\Models\Supplier;
use App\Models\ProductReturnToSupplierDetails;
use Validator;
use Response;
use Session;
use Auth;
use DB;

class ReturnFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$data['allcusreturn'] = ProductReturn::all();
        //$data['allsupplierreturn'] = ProductReturnToSupplier::all();
        //$data['allwastageproduct'] = ProductWastageDetails::all();
        
        $data['allbank']= BankAccount::where('status', '1')->get();
        $data['allsupplier']= Supplier::where('status', '1')->get();
        //$data['allproduct']= Product::where('status', '1')->get();
        $data['allproduct']= Product::join('stock_product', 'stock_product.product_id', '=', 'product.id')->where('stock_product.quantity', '>', '0')->select('product.*')->get();
        return view('returnProduct.returnFormSupplier',$data);
    }

    public function customerReturnForm(Request $request)
    {
        // Count
        $count = ProductSell::where('invoice_no', $request->tok)->count();
        if ($count>0) {
            $data['alldata'] = ProductSellDetails::where('invoice_no', $request->tok)->get();
            $data['singledata'] = ProductSell::where('invoice_no', $request->tok)->first();
            $data['allproduct']= Product::where('status', '1')->get();
            return view('returnProduct.customerReturnForm', $data);
        }else{
            Session::flash('flash_message','Incorrect Invoice No !');
            return redirect()->back()->with('status_color','warning');
        }
    }

    public function supplierReturnForm(Request $request)
    {
        // Count
        $count = ProductPurchase::where('tok', $request->tok)->count();
        if ($count>0) {
          $data['alldata'] = ProductPurchaseDetails::where('tok', $request->tok)->get();
          $data['singledata'] = ProductPurchase::where('tok', $request->tok)->first();
          return view('returnProduct.supplierReturnForm', $data);
        }else{
            Session::flash('flash_message','Incorrect Invoice No !');
            return redirect()->back()->with('status_color','warning');
        }
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
        //
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

    public function showCustomerReturnReport(Request $request)
    {
        $data['alldata']= ProductReturn::paginate(250);
        return view('returnProduct.customerReturnReport', $data);
    }

    public function showCustomerReturnReportFilter(Request $request)
    {
        if ($request->search && $request->start_date !="" && $request->end_date !="") {
            $data['alldata']= ProductReturn::whereBetween('return_date', [$request->start_date, $request->end_date])->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('returnProduct.customerReturnReport', $data);
        }
    }

    public function showSupplierReturnReport(Request $request)
    {
        $data['alldata']= ProductReturnToSupplier::paginate(250);
        return view('returnProduct.supplierReturnReport', $data);
    }

    public function showSupplierReturnReportFilter(Request $request)
    {
        if ($request->search && $request->start_date !="" && $request->end_date !="") {
            $data['alldata']= ProductReturnToSupplier::whereBetween('return_date', [$request->start_date, $request->end_date])->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('returnProduct.supplierReturnReport', $data);
        }
    }

    public function showWastageListReport(Request $request)
    {
        $data['alldata']= ProductWastageDetails::all();
        return view('returnProduct.wastageListReport', $data);
    }

    public function showWastageListReportFilter(Request $request)
    {
        if ($request->search && $request->start_date !="" && $request->end_date !="") {
            $data['alldata']= ProductWastageDetails::get();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('returnProduct.wastageListReport', $data);
        }
    }
    
    public function showSupplierReturnDetail($id)
    {
        $data['alldata'] = ProductReturnToSupplierDetails::where('tok', $id)->get();
        $data['singledata'] =  ProductReturnToSupplier::where('tok', $id)->first();
        return view('returnProduct.productReturnDetail', $data);
    }
}
