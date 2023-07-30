<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockProduct;
use App\Models\StockProductDetail;
use Validator;
use Session;
use DB;

use App\Exports\StockProductExport;
use Maatwebsite\Excel\Facades\Excel;

class StockProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata']= StockProduct::where('branch_id',0)->paginate(20);
        return view('products.stockProduct', $data);
    }
    
    public function dateWiseStockProduct()
    {
        //$data['alldata']= StockProductDetail::where('reason', 'LIKE', '%'.'Add to Stock'.'%')->groupBy('product_id')->select('stock_product_details.*', DB::raw('SUM(quantity) AS sumQuantity'))->get();
        $data['alldata']= StockProductDetail::groupBy('product_id')->select('stock_product_details.*')->paginate(20);
        return view('products.dateWiseStockProduct', $data);
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

    public function export()
    {
        return Excel::download(new StockProductExport, 'stock-product.xlsx');
    }
}
