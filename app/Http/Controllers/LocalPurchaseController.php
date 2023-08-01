<?php

namespace App\Http\Controllers;

use App\Http\Requests\Filter\SupplierFilter;
use App\Http\Requests\LocalPurchase\CreateRequest;
use App\Models\LocalPurchase;
use App\Models\LocalSupplier;
use App\Models\LocalSupplierLedger;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\StockProduct;
use App\Models\StockProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LocalPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SupplierFilter $request)
    {
        if ($request->start_date != '' && $request->end_date != '' && $request->supplier_id != '') {
            $data['localPurchases'] = LocalPurchase::where('local_supplier_id', $request->supplier_id)
                                    ->whereBetween('date',[$request->start_date, $request->end_date])
                                    ->paginate(250);
            $data['localSuppliers'] = LocalSupplier::all();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('localPurchase.index', $data);
        } elseif ($request->start_date != '' && $request->end_date != '' && $request->supplier_id == ''){
            $data['localPurchases'] = LocalPurchase::whereBetween('date',[$request->start_date, $request->end_date])
                                    ->paginate(250);
            $data['localSuppliers'] = LocalSupplier::all();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('localPurchase.index', $data);
        } elseif ($request->start_date == '' && $request->end_date == '' && $request->supplier_id != ''){
            $data['localPurchases'] = LocalPurchase::where('local_supplier_id', $request->supplier_id)
                                    ->paginate(250);
            $data['localSuppliers'] = LocalSupplier::all();
            return view('localPurchase.index', $data);
        } else {
            $data['localSuppliers'] = LocalSupplier::all();
            $data['localPurchases'] = LocalPurchase::paginate(250);
            return view('localPurchase.index', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['localSuppliers'] = LocalSupplier::all();
        $data['products'] = Product::all();
        $data['allproduct']= Product::where('status', '1')->get();
        $data['allproducttype']= ProductType::where('status', '1')->get();
        return view('localPurchase.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $productAvgPrice = 0;
        try {
            DB::beginTransaction();
            
            $localPurchase = LocalPurchase::create([
                'local_supplier_id' => $request->local_supplier_id,
                'amount' => $request->sub_total,
                'date' => $request->date,
                'note' => $request->note,
                'created_by' => Auth::user()->id,
            ]);

            foreach ($request->purchase_details as $key => $value) {

                $localPurchase->purchaseDetails()->create([
                    'product_id' => $value['product_id'],
                    'unit_price' => $value['unit_price'],
                    'quantity' => $value['quantity']
                ]);

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
                        'branch_id' => 0, 
                        'date' => $request->date, 
                        'product_type_id' => $value['product_type_id'], 
                        'product_id' => $value['product_id'], 
                        'quantity' => $value['quantity'], 
                        'unit_price' => $value['unit_price'], 
                        'reason' => 'Purchase', 
                        'tok' => $localPurchase->id, 
                        'note' => $request->note, 
                        'status' => 1
                ]);
            }

            LocalSupplier::where('id', $request->local_supplier_id)->increment('bill', $request->sub_total);
            LocalSupplier::where('id', $request->local_supplier_id)->increment('due', $request->sub_total);

            LocalSupplierLedger::create([
                'local_supplier_id' => $request->local_supplier_id,
                'date' => $request->date,
                'reason' => 'Purchase',
                'amount' => $request->sub_total,
                'note' => $request->note,
            ]);
            DB::commit();
            Session::flash('flash_message','Local Purchase Successfully Created !');
            return redirect()->route('local-purchases.index')->with('status_color','success');
        } catch (\Exception $e) {
            DB::rollBack();
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
        $data['localPurchase'] = LocalPurchase::findOrFail($id);
        return view('localPurchase.invoice', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['products'] = Product::all();
        $data['allproduct']= Product::where('status', '1')->get();
        $data['allproducttype']= ProductType::where('status', '1')->get();
        $data['localPurchase'] = LocalPurchase::findOrFail($id);
        return view('localPurchase.edit', $data);
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
        try {
            DB::beginTransaction();

            $this->destroyAndUpdate($id);
            
            $localPurchase = LocalPurchase::create([
                'local_supplier_id' => $request->local_supplier_id,
                'amount' => $request->sub_total,
                'date' => $request->date,
                'note' => $request->note,
                'created_by' => Auth::user()->id,
            ]);

            foreach ($request->purchase_details as $key => $value) {

                $localPurchase->purchaseDetails()->create([
                    'product_id' => $value['product_id'],
                    'unit_price' => $value['unit_price'],
                    'quantity' => $value['quantity']
                ]);

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
                        'branch_id' => 0, 
                        'date' => $request->date, 
                        'product_type_id' => $value['product_type_id'], 
                        'product_id' => $value['product_id'], 
                        'quantity' => $value['quantity'], 
                        'unit_price' => $value['unit_price'], 
                        'reason' => 'Purchase', 
                        'tok' => $localPurchase->id, 
                        'note' => $request->note, 
                        'status' => 1
                ]);
            }

            LocalSupplier::where('id', $request->local_supplier_id)->increment('bill', $request->sub_total);
            LocalSupplier::where('id', $request->local_supplier_id)->increment('due', $request->sub_total);

            LocalSupplierLedger::create([
                'local_supplier_id' => $request->local_supplier_id,
                'date' => $request->date,
                'reason' => 'Purchase',
                'amount' => $request->sub_total,
                'note' => $request->note,
            ]);
            DB::commit();
            Session::flash('flash_message','Local Purchase Successfully Updated !');
            return redirect()->route('local-purchases.index')->with('status_color','success');
        } catch (\Exception $e) {
            DB::rollBack();
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
        try {
            DB::beginTransaction();
            $this->destroyAndUpdate($id);
            DB::commit();
            Session::flash('flash_message','Local Purchase Successfully Deleted !');
            return redirect()->route('local-purchases.index')->with('status_color','success');
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(SupplierFilter $request)
    {
        if ($request->start_date != '' && $request->end_date != '' && $request->supplier_id != '') {
            $data['localPurchases'] = LocalPurchase::where('local_supplier_id', $request->supplier_id)
                                    ->whereBetween('date',[$request->start_date, $request->end_date])
                                    ->paginate(250);
            $data['localSuppliers'] = LocalSupplier::all();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('localPurchase.list', $data);
        } elseif ($request->start_date != '' && $request->end_date != '' && $request->supplier_id == ''){
            $data['localPurchases'] = LocalPurchase::whereBetween('date',[$request->start_date, $request->end_date])
                                    ->paginate(250);
            $data['localSuppliers'] = LocalSupplier::all();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('localPurchase.list', $data);
        } elseif ($request->start_date == '' && $request->end_date == '' && $request->supplier_id != ''){
            $data['localPurchases'] = LocalPurchase::where('local_supplier_id', $request->supplier_id)
                                    ->paginate(250);
            $data['localSuppliers'] = LocalSupplier::all();
            return view('localPurchase.list', $data);
        } else {
            $data['localSuppliers'] = LocalSupplier::all();
            $data['localPurchases'] = LocalPurchase::paginate(250);
            return view('localPurchase.list', $data);
        }
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAndUpdate($id):void{
        $productAvgPrice = 0;
        $localPurchase = LocalPurchase::findOrFail($id);
        foreach ($localPurchase->purchaseDetails as $key => $value) {
            $stockProduct = StockProduct::where([['product_id', $value['product_id']],['branch_id', '0']])->first();

            $stockProductPrice = $stockProduct->quantity * $stockProduct->unit_price; 
            $purchaseProductPrice = $value['quantity'] * $value['unit_price'];
            $amendmentProductPrice = $stockProductPrice - $purchaseProductPrice;

            $stockProductQuantity = $stockProduct->quantity - $value['quantity'];

            if ($stockProductQuantity == 0) {
                $productAvgPrice = 0;
            } else {
                $productAvgPrice = $amendmentProductPrice / $stockProductQuantity;
            }

            $stockProduct->update([
                'quantity' => $stockProductQuantity,
                'unit_price' => $productAvgPrice,
            ]);
        }
        $localPurchase->stockProductDetails()->delete();

        LocalSupplier::where('id', $localPurchase->local_supplier_id)->decrement('bill', $localPurchase->amount);
        LocalSupplier::where('id', $localPurchase->local_supplier_id)->decrement('due', $localPurchase->amount);

        LocalSupplierLedger::where('local_supplier_id', $localPurchase->local_supplier_id)->delete();

        $localPurchase->purchaseDetails()->delete();
        $localPurchase->delete();
    }
}
