<?php

namespace App\Http\Controllers;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\CustomerLedger;
use App\Models\StockProduct;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use Session;
use Auth;
use DB;

class DashboardController extends Controller
{	
	public function index() {
		$data['ttlBranch'] = Branch::count();
		$data['ttlCustomer'] = Customer::count();
		$data['ttlMainStock'] = StockProduct::where('branch_id', '0')->sum('quantity');
		$data['ttlBranchStock'] = StockProduct::where('branch_id', '!=', '0')->sum('quantity');
		$data['customerDue'] = $this->customerDue();
		return view('dashboard',$data);
	}

	public function customerDue(){
		$ttlBill = CustomerLedger::where('reason', 'like', '%pre due%')->orWhere('reason', 'like', '%sell%')->sum('amount');
		$ttlpaid = CustomerLedger::where('reason', 'like', '%receive%')->sum('amount');
		 return $ttlBill-$ttlpaid;
	}
}
