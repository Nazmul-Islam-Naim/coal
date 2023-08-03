<?php

namespace App\Http\Controllers;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\CustomerLedger;
use App\Models\Importer;
use App\Models\lcInfo;
use App\Models\LocalPurchase;
use App\Models\LocalSupplier;
use App\Models\ProductSell;
use App\Models\StockProduct;
use App\Models\Supplier;

class DashboardController extends Controller
{	
	public function index() {
		$data['ttlBranch'] = Branch::count();
		$data['ttlCustomer'] = Customer::count();
		$data['ttlExporters'] = Supplier::count();
		$data['ttlImporters'] = Importer::count();
		$data['ttlLcPurchase'] = lcInfo::sum('sub_total');
		$data['ttlLocalPurchase'] = LocalPurchase::sum('amount');
		$data['customerDue'] = $this->customerDue();
		$data['ttlLocalSupplirs'] = LocalSupplier::count();
		$data['ttlSell'] = ProductSell::sum('sub_total');
		$data['ttlMainStock'] = StockProduct::where('branch_id', '0')->sum('quantity');
		$data['ttlBranchStock'] = StockProduct::where('branch_id', '!=', '0')->sum('quantity');
		return view('dashboard',$data);
	}

	public function customerDue(){
		$ttlBill = CustomerLedger::where('reason', 'like', '%pre due%')->orWhere('reason', 'like', '%sell%')->sum('amount');
		$ttlpaid = CustomerLedger::where('reason', 'like', '%receive%')->sum('amount');
		 return $ttlBill-$ttlpaid;
	}
}
