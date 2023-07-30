<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductSell;
use App\Models\SupplierLedger;
use App\Models\OtherPaymentVoucher;
use App\Models\OtherReceiveVoucher;
use App\Models\TransactionReport;
use App\Models\EmployeeLedger;
use App\Models\CustomerLedger;
use Validator;
use Session;
use DB;

class DailyTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata']= TransactionReport::paginate(250);
        return view('accounts.dailyTransaction', $data);
    }

    public function filter(Request $request)
    {
        if ($request->start_date !="" && $request->end_date !="") {
            $data['alldata'] = TransactionReport::whereBetween('transaction_date', [$request->start_date, $request->end_date])->paginate(250);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            
            return view('accounts.dailyTransaction', $data);
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
    
    public function finalReport()
    {
        $data['supplier_payment']= SupplierLedger::where('reason', 'like', '%' . 'payment(supplier)' . '%')->sum('amount');
        $data['supplier_purchase']= SupplierLedger::where('reason', 'like', '%' . 'purchase' . '%')->sum('amount');
        //$data['total_sell']= ProductSell::sum('grand_total');
        $data['total_sell']= CustomerLedger::where('reason', 'like', '%' . 'receive -' . '%')->orWhere('reason', 'like', '%' . 'bill collection' . '%')->sum('amount');
        $data['adjustment']= CustomerLedger::where('reason', 'like', '%' . 'adjustment' . '%')->sum('amount');
        //$data['total_sell']= CustomerLedger::where('reason', '=', 'receive')->sum('amount');
        
        $data['other_payment']= OtherPaymentVoucher::sum('amount');
        $data['other_receive']= OtherReceiveVoucher::sum('amount');
        $data['employee_salary']= EmployeeLedger::where('reason', 'like', '%' . 'salary' . '%')->sum('amount');
        $data['bank_opening_balance']= TransactionReport::where('reason', 'like', '%' . 'Opening Balance' . '%')->sum('amount');
        $data['bank_deposit']= TransactionReport::where('reason', 'like', '%' . 'deposit' . '%')->sum('amount');
        $data['bank_withdraw']= TransactionReport::where('reason', 'like', '%' . 'withdraw' . '%')->sum('amount');
        $data['bank_transfer']= TransactionReport::where('reason', 'like', '%' . 'transfer' . '%')->sum('amount');
        
        $data['supplier_bill_adjustment']= TransactionReport::where('reason', 'like', '%' . 'supplier bill adjustment' . '%')->sum('amount');
        return view('accounts.finalReport', $data);
    }

    public function finalReportFiltering(Request $request)
    {
        if ($request->start_date !="" && $request->end_date !="") {
            /*$data['supplier_payment']= SupplierLedger::whereBetween('date', [$request->start_date, $request->end_date])->where('reason', 'like', '%' . 'payment(supplier)' . '%')->sum('amount');
            $data['total_sell']= ProductSell::whereBetween('sell_date', [$request->start_date, $request->end_date])->sum('sub_total');
            $data['other_payment']= OtherPaymentVoucher::whereBetween('payment_date', [$request->start_date, $request->end_date])->sum('amount');
            $data['other_receive']= OtherReceiveVoucher::whereBetween('receive_date', [$request->start_date, $request->end_date])->sum('amount');
            $data['employee_salary']= EmployeeLedger::whereBetween('date', [$request->start_date, $request->end_date])->where('reason', 'like', '%' . 'salary' . '%')->sum('amount');
            $data['bank_opening_balance']= TransactionReport::whereBetween('transaction_date', [$request->start_date, $request->end_date])->where('reason', 'like', '%' . 'Opening Balance' . '%')->sum('amount');
            return view('accounts.finalReport', $data);*/
            
            
            $data['supplier_payment']= SupplierLedger::where('reason', 'like', '%' . 'payment(supplier)' . '%')->whereBetween('date', [$request->start_date, $request->end_date])->sum('amount');
            $data['supplier_purchase']= SupplierLedger::where('reason', 'like', '%' . 'purchase' . '%')->whereBetween('date', [$request->start_date, $request->end_date])->sum('amount');
            //$data['total_sell']= ProductSell::sum('grand_total');
            //$data['total_sell']= CustomerLedger::where('reason', 'like', '%' . 'receive' . '%')->sum('amount');
            //$data['total_sell']= CustomerLedger::where('reason', 'like', '%' . 'receive' . '%')->whereBetween('date', [$request->start_date, $request->end_date])->sum('amount');
            $data['total_sell']= CustomerLedger::where('reason', 'like', '%' . 'receive -' . '%')->orWhere('reason', 'like', '%' . 'bill collection' . '%')->whereBetween('date', [$request->start_date, $request->end_date])->sum('amount');
            $data['adjustment']= CustomerLedger::where('reason', 'like', '%' . 'adjustment' . '%')->whereBetween('date', [$request->start_date, $request->end_date])->sum('amount');
            
            $data['other_payment']= OtherPaymentVoucher::whereBetween('payment_date', [$request->start_date, $request->end_date])->sum('amount');
            $data['other_receive']= OtherReceiveVoucher::whereBetween('receive_date', [$request->start_date, $request->end_date])->sum('amount');
            $data['employee_salary']= EmployeeLedger::where('reason', 'like', '%' . 'salary' . '%')->whereBetween('date', [$request->start_date, $request->end_date])->sum('amount');
            $data['bank_opening_balance']= TransactionReport::where('reason', 'like', '%' . 'Opening Balance' . '%')->whereBetween('transaction_date', [$request->start_date, $request->end_date])->sum('amount');
            $data['bank_deposit']= TransactionReport::where('reason', 'like', '%' . 'deposit' . '%')->whereBetween('transaction_date', [$request->start_date, $request->end_date])->sum('amount');
            $data['bank_withdraw']= TransactionReport::where('reason', 'like', '%' . 'withdraw' . '%')->whereBetween('transaction_date', [$request->start_date, $request->end_date])->sum('amount');
            $data['bank_transfer']= TransactionReport::where('reason', 'like', '%' . 'transfer' . '%')->whereBetween('transaction_date', [$request->start_date, $request->end_date])->sum('amount');
            
            $data['supplier_bill_adjustment']= TransactionReport::where('reason', 'like', '%' . 'supplier bill adjustment' . '%')->whereBetween('transaction_date', [$request->start_date, $request->end_date])->sum('amount');
            return view('accounts.finalReport', $data);
        }
    }
}
