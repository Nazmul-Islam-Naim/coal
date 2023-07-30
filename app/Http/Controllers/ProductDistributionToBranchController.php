<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OtherPaymentType;
use App\Models\OtherPaymentSubType;
use App\Models\BankAccount;
use App\Models\OtherPaymentVoucher;
use App\Models\Transaction;
use App\Models\TransactionReport;
use App\Models\StockProduct;
use App\Models\StockProductDetail;
use App\Models\Branch;
use App\Models\Agency;
use App\Models\AgencyLedger;
use App\Models\ProductDistributeToBranch;
use Validator;
use Response;
use Session;
use Auth;
use DB;

use App\Exports\PaymentVoucherExport;
use Maatwebsite\Excel\Facades\Excel;

class ProductDistributionToBranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['allproduct']= StockProduct::join('product', 'product.id', 'stock_product.product_id')->select('product.id','product.name','stock_product.quantity')->where('stock_product.branch_id', '0')->get();
        $data['allbranch']= Branch::where('status', '1')->get();
        $data['allagency']= Agency::all();
        return view('stockManagement.distributionToBranch', $data);
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
            'branch_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required|numeric|gt:0',
            'lighter_agency_id' => 'required',
            'total_rent' => 'required|numeric|gt:0',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
        
        $input = $request->all();

        $input['created_by'] = Auth::id();
        $input['tok'] = date('Ymdhis');
        $input['date'] = date('Y-m-d');
        $input['status'] = 1;

        DB::beginTransaction();
        try{
            $bug=0;
            $insert= ProductDistributeToBranch::create($input);
            
            // check duplicate
            $productInfo = StockProduct::where([['product_id',$request->product_id],['branch_id','0']])->first();
            $checkProduct = StockProduct::where([['product_id',$request->product_id],['branch_id',$request->branch_id]])->first();
            $check = StockProduct::where([['product_id',$request->product_id],['branch_id',$request->branch_id]])->count();
            if($check == 1){
                $update = StockProduct::where([['product_id',$request->product_id],['branch_id',$request->branch_id]])->increment('quantity',$request->quantity);
                
                // updating unit price
                $updatedUnitPrice = (($checkProduct->quantity*$checkProduct->unit_price)+($request->quantity*$productInfo->unit_price))/($checkProduct->quantity+$request->quantity);
                $update=StockProduct::where([['product_id',$request->product_id],['branch_id',$request->branch_id]])->update(array('unit_price' => $updatedUnitPrice));
                
                StockProductDetail::create([
                    'date'=>date('Y-m-d'),
                    'branch_id'=>$request->branch_id,
                    'product_id'=>$request->product_id,
                    'quantity'=>$request->quantity,
                    'unit_price'=>'',
                    'reason'=>'Add to Branch Stock',
                    'tok'=>date('Ymdhis'),
                    'status'=>'1'
                ]);
            }else{
                $insert = StockProduct::create([
                    'branch_id'=>$request->branch_id,
                    'product_id'=>$request->product_id,
                    'quantity'=>$request->quantity,
                    'unit_price'=> $productInfo->unit_price,
                    'status'=> '1',
                    'created_by'=> Auth::id(),
                ]);
                
                StockProductDetail::create([
                    'date'=>date('Y-m-d'),
                    'branch_id'=>$request->branch_id,
                    'product_id'=>$request->product_id,
                    'quantity'=>$request->quantity,
                    'unit_price'=>$productInfo->unit_price,
                    'reason'=>'Add to Branch Stock',
                    'tok'=>date('Ymdhis'),
                    'status'=>'1'
                ]);
            }
            
            // update main stock
            $update = StockProduct::where([['product_id',$request->product_id],['branch_id','0']])->decrement('quantity',$request->quantity);
            
            // Inserting into AgencyLedger table
            $insert= AgencyLedger::create([
                'date'=>date('Y-m-d'),
                'agency_id'=>$request->lighter_agency_id,
                'amount'=>$request->total_rent,
                'reason'=>'bill',
                'tok'=>date('Ymdhis'),
                'created_by'=>Auth::id()
            ]);
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
            //return $e->getMessage();
        }

        if($bug==0){
            Session::flash('flash_message','Product Successfully Added !');
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

    public function findPaymentSubTypeWithType(Request $request)
    {
        $subType = OtherPaymentSubType::where('payment_type_id',$request->id)->get();
        return Response::json($subType);
        die;
    }

    public function report(Request $request)
    {
        $data['alldata']= OtherPaymentVoucher::where('status', '1')->paginate(250);
        $data['alltype']= OtherPaymentType::where('status', '1')->get();
        $data['allbank']= BankAccount::all();
        return view('otherPayment.voucherReport', $data);
    }

    public function filter(Request $request)
    {
        if ($request->start_date !="" && $request->end_date !="") {
            $data['alldata']= OtherPaymentVoucher::whereBetween('payment_date', [$request->start_date, $request->end_date])->paginate(250);
            $data['alltype']= OtherPaymentType::where('status', '1')->get();
            $data['allbank']= BankAccount::all();
            $data['start_date']= $request->start_date;
            $data['end_date']= $request->end_date;
            return view('otherPayment.voucherReport', $data);
        }
    }
    
    public function paymentDetail($id)
    {
        $data['single_data']= OtherPaymentVoucher::where('id', $id)->first();
        return view('otherPayment.paymentDetail', $data);
    }
}
