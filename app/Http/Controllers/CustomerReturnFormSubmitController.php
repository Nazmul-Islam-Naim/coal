<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductReturn;
use App\Models\ProductReturnDetails;
use App\Models\ProductWastageDetails;
use Validator;
use Response;
use Session;
use Auth;
use DB;

class CustomerReturnFormSubmitController extends Controller
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
        DB::beginTransaction();
        try{
            $bug=0;
            $ttlQnty = 0;

            foreach ($request->multidata as $value) {
                if ($value['return_qnty'] != 0) {
                    $input['customer_id'] = $request->customer_id;
                    $input['product_id'] = $value['product_id'];
                    $input['return_qnty'] = $value['return_qnty'];
                    $input['total_amount'] = $value['total_amount'];
                    $input['tok'] = $request->tok;
                    $input['invoice_no'] = $request->invoice_no;
                    $input['created_by'] = Auth::id();
                    $insert= ProductReturnDetails::create($input);

                    // update stock product
                    $check = DB::table('product_sell_details')->where([['product_id', $value['product_id']], ['invoice_no', $request->invoice_no]])->count();
                    if($check > 0){
                        /*$sql = DB::table('product_sell_details')->where([['product_id', $value['product_id']], ['invoice_no', $request->invoice_no]])->first();
                        if($sql->quantity > $value['return_qnty']){
                            $qnty = $sql->quantity - $value['return_qnty'];
                            $update=DB::table('stock_product')->where('product_id', $value['product_id'])->increment('quantity', $qnty); 
                        }elseif($value['return_qnty'] > $sql->quantity){
                            $qnty = $value['return_qnty'] - $sql->quantity;
                            $update=DB::table('stock_product')->where('product_id', $value['product_id'])->decrement('quantity', $qnty); 
                        }*/
                        
                        $update=DB::table('stock_product')->where('product_id', $value['product_id'])->increment('quantity', $value['return_qnty']);
                    }
                }
                
                $ttlQnty += $value['return_qnty'];
            }
            
            $insert= ProductReturn::create([
                'customer_id'=>$request->customer_id,
                'total_qnty'=>$ttlQnty,
                'net_return_amount'=>$request->total_return_amount,
                'reason'=>$request->details,
                'return_date'=>date('Y-m-d'),
                'tok'=>$request->tok,
                'invoice_no'=>$request->invoice_no,
                'created_by'=>Auth::id(),
            ]);
            
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Prouct Return Successfully Done !');
            //return redirect()->back()->with('status_color','success');
            return redirect('return/return-list-from-customer')->with('status_color','success');
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
    
    public function showDetails($tok)
    {
        $data['single_data']= ProductReturn::where('tok', $tok)->first();
        $data['alldata']= ProductReturnDetails::where('tok', $tok)->get();
        return view('returnProduct.customer-return-details', $data);
    }
}
