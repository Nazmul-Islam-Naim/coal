<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockProduct;
use App\Models\StockProductDetail;
use Validator;
use Response;
use Session;
use Auth;
use DB;

use App\Exports\PaymentVoucherExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Branch;

class BranchStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$data['alldata']= StockProduct::where('branch_id','!=', '0')->paginate(20);
        $data['alldata']= StockProduct::join('branchs', 'branchs.id', '=', 'stock_product.branch_id')->where('stock_product.branch_id','!=', '0')->select(DB::raw('stock_product.branch_id,branchs.phone,branchs.address,sum(stock_product.quantity) as ttlQnty'))->groupBy('stock_product.branch_id')->paginate(20);
        return view('stockManagement.branchStock', $data);
    }
    
    public function stockDetail($id){
        $data['alldata']= StockProduct::where('branch_id',$id)->paginate(20);
        return view('stockManagement.branchStockDetail', $data);
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
            'payment_type_id' => 'required',
            'payment_sub_type_id' => 'required',
            'amount' => 'required|numeric|gt:0',
            'payment_for' => 'required',
            'payment_date' => 'required',
            'bank_id' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
        
        $input = $request->all();

        $input['created_by'] = Auth::id();
        $input['tok'] = date('Ymdhis');
        $input['status'] = 1;

        DB::beginTransaction();
        try{
            $bug=0;
            $insert= OtherPaymentVoucher::create($input);

            $update=DB::table('bank_account')->where('id', $request->bank_id)->decrement('balance', $request->amount);

            // get payment type name
            $paymentTypeName=DB::table('other_payment_type')->where('id', $request->payment_type_id)->first();

            $insertIntoTransaction = Transaction::create([
                'date'=>$request->payment_date,
                'reason'=>'Payment(others-'.$paymentTypeName->name.')',
                'amount'=>$request->amount,
                'tok'=> date('Ymdhis'),
                'status'=> '1',
                'created_by'=> Auth::id(),
            ]);

            $insertIntoReportForReceive = TransactionReport::create([
                'bank_id'=>$request->bank_id,
                'transaction_date'=>$request->payment_date,
                'reason'=>'payment(others-'.$paymentTypeName->name.')',
                'amount'=>$request->amount,
                'note'=>$request->note,
                'tok'=>date('Ymdhis'),
                'status'=>'1',
                'created_by'=>Auth::id()
            ]);

            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Payment Voucher Successfully Added !');
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
    
    public function addPreBranchStock(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'branch_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required',
            'unit_price' => 'required',
            'date' => 'required',
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

            // Creating product Stock
            $checkProduct = StockProduct::where([['product_id', $request->product_id],['branch_id', $request->branch_id]])->first();
            $count = StockProduct::where([['product_id', $request->product_id],['branch_id', $request->branch_id]])->count();
            if ($count == 1) {
                $update=StockProduct::where([['product_id', $request->product_id],['branch_id', $request->branch_id]])->increment('quantity', $request->quantity);
                
                // updating unit price
                $updatedUnitPrice = (($checkProduct->quantity*$checkProduct->unit_price)+($request->quantity*$request->unit_price))/($checkProduct->quantity+$request->quantity);

                $update=StockProduct::where([['product_id', $request->product_id],['branch_id', $request->branch_id]])->update(array('unit_price' => $updatedUnitPrice));
            }else{
                $insert= StockProduct::create([
                    'branch_id'=>$request->branch_id,
                    'product_id'=>$request->product_id,
                    'quantity'=>$request->quantity,
                    'unit_price'=>$request->unit_price,
                    'status'=>'1'
                ]);
            }
            
            StockProductDetail::create([
                'date'=>$request->date,
                'branch_id'=>$request->branch_id,
                'product_id'=>$request->product_id,
                'quantity'=>$request->quantity,
                'unit_price'=>$request->unit_price,
                'reason'=>'Add to Stock as Previous Stock',
                'tok'=>Session::get('sellSession'),
                'status'=>'1'
            ]);

            DB::commit();
        }catch(\Exception $e){
            /*$bug=$e->errorInfo[1];
            DB::rollback();*/
            return $e->getMessage();
        }

        if($bug==0){
            Session::forget('sellSession');
            Session::flash('flash_message','Previous Stock Successfully Added !');
            return redirect()->back()->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        } 
    }
    
    public function addPreMainStock(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'quantity' => 'required',
            'unit_price' => 'required',
            'date' => 'required',
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

            // Creating product Stock
            $checkProduct = StockProduct::where([['product_id', $request->product_id],['branch_id', '0']])->first();
            $count = StockProduct::where([['product_id', $request->product_id],['branch_id', '0']])->count();
            if ($count == 1) {
                $update=StockProduct::where([['product_id', $request->product_id],['branch_id', '0']])->increment('quantity', $request->quantity);
                
                // updating unit price
                $updatedUnitPrice = (($checkProduct->quantity*$checkProduct->unit_price)+($request->quantity*$request->unit_price))/($checkProduct->quantity+$request->quantity);

                $update=StockProduct::where([['product_id', $request->product_id],['branch_id', '0']])->update(array('unit_price' => $updatedUnitPrice));
            }else{
                $insert= StockProduct::create([
                    'branch_id'=>'0',
                    'product_id'=>$request->product_id,
                    'quantity'=>$request->quantity,
                    'unit_price'=>$request->unit_price,
                    'status'=>'1'
                ]);
            }
            
            StockProductDetail::create([
                'date'=>$request->date,
                'branch_id'=>'0',
                'product_id'=>$request->product_id,
                'quantity'=>$request->quantity,
                'unit_price'=>$request->unit_price,
                'reason'=>'Add to Stock as Previous Stock',
                'tok'=>Session::get('sellSession'),
                'status'=>'1'
            ]);

            DB::commit();
        }catch(\Exception $e){
            /*$bug=$e->errorInfo[1];
            DB::rollback();*/
            return $e->getMessage();
        }

        if($bug==0){
            Session::forget('sellSession');
            Session::flash('flash_message','Previous Stock Successfully Added !');
            return redirect()->back()->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        } 
    }
}
