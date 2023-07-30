<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductReturnToSupplier;
use App\Models\ProductReturnToSupplierDetails;
use App\Models\SupplierLedger;
use Validator;
use Response;
use Session;
use Auth;
use DB;

use App\Exports\SupplierReturnExport;
use App\Exports\WastageReportExport;
use Maatwebsite\Excel\Facades\Excel;

class SupplierReturnFormSubmitController extends Controller
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
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required',
            'return_date' => 'required',
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
            $ttlQnty = 0;
            
            // Inserting into supplier_ledger table
            $insert= SupplierLedger::create([
                'date'=>$request->return_date,
                'supplier_id'=>$request->supplier_id,
                'amount'=>$request->total_return_amount,
                'reason'=>'payment(return)',
                'note'=>$request->details,
                'tok'=>Session::get('sellSession'),
                'created_by'=>Auth::id()
            ]);

            foreach ($request->purchase_details as $value) {
                $input['supplier_id'] = $request->supplier_id;
                $input['product_id'] = $value['product_id'];
                $input['return_qnty'] = $value['return_qnty'];
                $input['unit_price'] = $value['unit_price'];
                $input['tok'] = Session::get('sellSession');
                $input['created_by'] = Auth::id();
                $insert= ProductReturnToSupplierDetails::create($input);

                // update stock product
                if (($request->usability) == 1) {
                    $update=DB::table('stock_product')->where('product_id', $value['product_id'])->decrement('quantity', $value['return_qnty']);
                }
                
                $ttlQnty += $value['return_qnty'];
            }
            
            $insert= ProductReturnToSupplier::create([
                'total_qnty'=>$ttlQnty,
                'supplier_id'=>$request->supplier_id,
                'net_return_amount'=>$request->total_return_amount,
                'reason'=>$request->details,
                'return_date'=>$request->return_date,
                'tok'=>Session::get('sellSession'),
                'created_by'=>Auth::id(),
            ]);
            
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            //return $e->getMessage();
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Prouct Return Successfully Done !');
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

    public function export()
    {
        return Excel::download(new SupplierReturnExport, 'supplier-return-report.xlsx');
    }

    public function wastageReportExport()
    {
        return Excel::download(new WastageReportExport, 'wastage-report.xlsx');
    }
}
