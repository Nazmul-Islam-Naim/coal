<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();
Route::group(['middleware'=>['auth']],function(){
    Route::get('dashboard', 'DashboardController@index');

    //****** Accounts ***********//
    Route::prefix(config('app.account'))->group(function () {
        Route::resource('account-type', 'AccountTypeController');
        Route::resource('bank-account', 'BankAccountController');
        Route::get('bank-deposit/{id}', 'BankDepositController@bankDeposit');
        Route::resource('bank-deposit', 'BankDepositController');
        Route::get('amount-transfer/{id}', 'AmountTransferController@amountTransfer');
        Route::resource('amount-transfer', 'AmountTransferController');
        Route::get('amount-withdraw/{id}', 'AmountWithdrawController@amountWithdraw');
        Route::resource('amount-withdraw', 'AmountWithdrawController');
        Route::get('bank-report/{id}', 'BankAccountController@showBankReport');
        Route::post('bank-report/{id}', 'BankAccountController@showBankReportFilter')->name('bank-report.filter');
        Route::post('find-chequeno-with-chequebook-id', 'AmountWithdrawController@findChequeNoWithChequeBookId');
        Route::resource('cheque-book', 'ChequeBookController');
        Route::resource('cheque-no', 'ChequeNoController');
        Route::resource('daily-transaction', 'DailyTransactionController');
        Route::post('daily-transaction', 'DailyTransactionController@filter')->name('transaction.filter');
        
        Route::get('final-report', 'DailyTransactionController@finalReport');
        Route::post('final-report', 'DailyTransactionController@finalReportFiltering')->name('final-report.filter');
    });

    //******** Other Receive *******//
    Route::prefix(config('app.or'))->group(function () {
        Route::resource('receive-type', 'ReceiveTypeController');
        Route::resource('receive-sub-type', 'ReceiveSubTypeController');
        Route::resource('receive-voucher', 'ReceiveVoucherController');
        Route::get('receive-voucher-report', 'ReceiveVoucherController@report');
        Route::post('receive-voucher-report', 'ReceiveVoucherController@filter')->name('receive.filter');
        Route::post('find-receive-subtype-with-type-id', 'ReceiveVoucherController@findReceiveSubTypeWithType');
        
        Route::get('recevie-voucher-detail/{id}', 'ReceiveVoucherController@receiveDetail');
    });

    //******** Other Payment *******//
    Route::prefix(config('app.op'))->group(function () {
        Route::resource('payment-type', 'PaymentTypeController');
        Route::resource('payment-sub-type', 'PaymentSubTypeController');
        Route::resource('payment-voucher', 'PaymentVoucherController');
        Route::get('payment-voucher-report', 'PaymentVoucherController@report');
        Route::post('payment-voucher-report', 'PaymentVoucherController@filter')->name('payment.filter');
        Route::post('find-payment-subtype-with-type-id', 'PaymentVoucherController@findPaymentSubTypeWithType');
        
        Route::get('payment-voucher-detail/{id}', 'PaymentVoucherController@paymentDetail');
    });
    //******** Branch Management by naim*******//
    Route::prefix(config('app.bm'))->group(function () {
        Route::resource('branches', 'BranchController');
        Route::resource('report-by-mother-vasel', 'MotherVaselController');
    });
    //******** Stock Management by naim*******//
    Route::prefix(config('app.sm'))->group(function () {
        Route::resource('branch-stock', 'BranchStockController');
        Route::get('branch-stock-detail/{id}', 'BranchStockController@stockDetail');
        
        Route::post('add-pre-branch-stock', 'BranchStockController@addPreBranchStock')->name('add-pre-branch-stock');
        Route::post('add-pre-main-stock', 'BranchStockController@addPreMainStock')->name('add-pre-main-stock');
        // main stock
        Route::resource('stock-product', 'StockProductController');
        Route::resource('distribute-to-branch', 'ProductDistributionToBranchController');
        Route::resource('distribution-report', 'DistributionReportController');
        
        // add to stock
        Route::resource('add-to-stock', 'AddToStockController');
        Route::post('find-product-details-with-type-id', 'AddToStockController@getTypeWiseProduct');
        Route::get('product-wise-purchase-report', 'AddToStockController@showProductWiseReport');
        Route::post('product-wise-purchase-report', 'AddToStockController@showProductWiseReportFilter')->name('product-wise-purchase-report.filter');
        
        Route::get('purchase-report', 'AddToStockController@showReport');
        Route::post('purchase-report', 'AddToStockController@filter')->name('purchase.filter');
        Route::get('purchase-report/{id}', 'AddToStockController@showDetailsReport')->name('purchase-report');
        
        Route::get('discount-on-purchase', 'AddToStockController@discountOnPurchase');
        Route::post('save-discount-on-purchase', 'AddToStockController@saveDiscountOnPurchase')->name('save-discount-on-purchase');
    });

    //****** Customers ******//
    Route::prefix(config('app.customer'))->group(function () {
        Route::resource('customer', 'CustomerController');
        Route::put('add-customer-predue/{id}', 'CustomerController@addCustomerPredue')->name('add-customer-predue');
        Route::get('customer-ledger/{id}', 'CustomerController@customerLedger')->name('customer-ledger');
        Route::post('customer-ledger/{id}', 'CustomerController@filter')->name('customer-ledger.filter');
        Route::resource('achieve-gift-point', 'AchieveGiftPointController');
        Route::resource('customer-bill-collection', 'CustomerBillCollectionController');
        Route::get('customer-bill-collections', 'CustomerBillCollectionController@index');
        Route::post('customer-bill-collections', 'CustomerBillCollectionController@billCollectionFilter')->name('customer-bill-collections.filter');
        Route::get('customer-bill-collection-report', 'CustomerBillCollectionController@report');
        Route::post('customer-bill-collection-report', 'CustomerBillCollectionController@filter')->name('bill-collection.filter');
        Route::post('add-customer-via-pos-page', 'CustomerController@addCustomerViaPosPage');
        
        Route::get('daily-bill-collection-report', 'CustomerBillCollectionController@dailyReport');
        Route::post('daily-bill-collection-report', 'CustomerBillCollectionController@dailyReportFilter')->name('daily-bill-collection-report.filter');
    });
    
    //****** Employee ***********//
    Route::prefix(config('app.employee'))->group(function () {
        Route::resource('employees', 'EmployeeController');
        Route::post('create-salary-bill', 'EmployeeController@createBill')->name('create-salary-bill');
        Route::put('update-bill-amount/{id}', 'EmployeeController@updateBill')->name('update-bill-amount');
        Route::post('store-employee-salary', 'EmployeeController@storeSalary')->name('store-employee-salary');
        Route::get('employee-ledger/{id}', 'EmployeeController@employeeLedger')->name('employee-ledger');
        Route::get('created-bill-list/{id}', 'EmployeeController@createdBillList')->name('created-bill-list');
        Route::post('employee-ledger/{id}', 'EmployeeController@filter')->name('employee-ledger.filter');
        Route::get('employee-salary', 'EmployeeController@report');
        Route::post('employee-salary', 'EmployeeController@reportFilter')->name('employee-salary.filter');
        
        Route::get('all-bill-list', 'EmployeeController@allBillList');
        Route::post('all-bill-list', 'EmployeeController@allBillListFilter')->name('all-bill-list.filter');
    });

    //****** Products ******//
    Route::prefix(config('app.product'))->group(function () {
        Route::resource('product-type', 'ProductTypeController');
        Route::resource('product-sub-type', 'ProductSubTypeController');
        Route::resource('product-unit', 'ProductUnitController');
        Route::resource('product-brand', 'ProductBrandController');
        Route::resource('product', 'ProductController');
        Route::post('find-product-subtype-with-type-id', 'ProductController@findProductSubTypeWithType');
        Route::get('barcode/{id}', 'BarcodeGeneratorController@index');
        
        Route::get('stock-product-export', 'StockProductController@export');
        Route::resource('update-stock-product', 'UpdateStockProductController');
        Route::resource('buy-product-by-lc', 'BuyProductByLCController');
        Route::get('add-lc-product/{id}', 'BuyProductByLCController@addLCProduct');
        Route::post('save-lc-product', 'BuyProductByLCController@saveLCProduct')->name('save-lc-product');
        Route::get('lc-single-detail/{id}', 'BuyProductByLCController@singleLcDetail');
        Route::post('complete-single-lc', 'BuyProductByLCController@completeSingleLC')->name('complete-single-lc');
        //Route::resource('single-lc-wise-report', 'SingleLCWiseReportController');
        
        Route::get('date-wise-stock-product', 'StockProductController@dateWiseStockProduct');
    });
    
    // ********* Importer ****** //
    Route::prefix(config('app.importer'))->group(function () {
        Route::resource('product-importer', 'ProductImporterController');
        Route::get('product-importer-payment', 'ProductImporterController@supplierList');
        Route::get('product-importer-payment-report', 'ProductImporterController@supplierPaymentReport');
        Route::post('product-importer-payment-report', 'ProductImporterController@filter')->name('suplier-pay-report.filter');
        Route::resource('importer-area', 'ProductSupplierAreaController');
        Route::get('importer-ledger/{id}', 'ProductImporterController@supplierLedger');
        
        Route::post('importer-bill-adjustment', 'ProductImporterController@supplierBillAdjustment')->name('importer-bill-adjustment');
    });

    // ********* Supplier ****** //
    Route::prefix(config('app.supplier'))->group(function () {
        Route::resource('product-supplier', 'ProductSupplierController');
        Route::get('product-supplier-payment', 'ProductSupplierController@supplierList');
        Route::get('product-supplier-payment-report', 'ProductSupplierController@supplierPaymentReport');
        Route::post('product-supplier-payment-report', 'ProductSupplierController@filter')->name('suplier-pay-report.filter');
        Route::resource('supplier-area', 'ProductSupplierAreaController');
        Route::get('supplier-ledger/{id}', 'ProductSupplierController@supplierLedger');
        
        Route::post('supplier-bill-adjustment', 'ProductSupplierController@supplierBillAdjustment')->name('supplier-bill-adjustment');
        
        // RS users
        Route::resource('rs-users', 'RsUsersController');
        Route::get('rs-user-ledger/{id}', 'RsUsersController@rsUserLedger');
        Route::get('rs-rupee-ledger/{id}', 'RsUsersController@rsRupeeLedger');
        Route::get('exporter-ledger/{id}', 'ProductSupplierController@exporterLedger');
        Route::post('exporter-ledger-document-upload/{id}', 'ProductSupplierController@uploadExporterDocument')->name('exporter-ledger-document-upload');
        Route::post('customer-ledger-document-upload/{id}', 'ProductSupplierController@uploadCustomerDocument')->name('customer-ledger-document-upload');
        Route::post('lc-detail-document-upload/{id}', 'ProductSupplierController@uploadLCDocument')->name('lc-detail-document-upload');

        Route::resource('local-suppliers', 'LocalSupplierController');
        Route::get('payable-suppliers', 'LocalSupplierController@payableSuppliers')->name('payable-suppliers');
        Route::get('payment-form/{id}', 'LocalSupplierController@paymentForm')->name('payment-form');
        
        // truck
        //Route::resource('truck', 'TruckController');
    });
    // ********* Exporter and Importer ****** //
    Route::prefix(config('app.ei'))->group(function () {
        Route::resource('exporter-info', 'ExporterController');
        Route::resource('importer-info', 'ImporterController');
    });
    
    // ********* delivery chalan ****** //
    Route::prefix(config('app.delivery'))->group(function () {
        Route::resource('chalan', 'ChalanController');
        Route::get('chalan-detail/{id}', 'ChalanController@invoice');
    });

    // *********** Product Purchase ********* //
    Route::prefix(config('app.purchase'))->group(function () {
        Route::resource('lc', 'CreatLCController');
        Route::get('lc-complete/{id}', 'CreatLCController@completeLC')->name('lc-complete');
        Route::get('lc-detail/{id}', 'CreatLCController@lcDetail');
        Route::get('lc-report', 'CreatLCController@getLcReport');
        Route::resource('lc-payment', 'LCPaymentController');
        //Route::get('view-lc', 'CreatLCController@lcList');
        //Route::resource('lc-payment-report', 'LCPaymentReportController');
        Route::resource('fee-type', 'FeeTypeController');
        Route::resource('lc-fees', 'LCFeesController');
        Route::resource('lc-fees-update-report', 'LCFeesUpdateReportController');
        //Route::resource('lc-payment', 'LCPaymentController');
        //Route::resource('lc-report', 'LCReportController');
        Route::resource('lc-expire', 'LCExpireController');
        Route::resource('lc-amendment', 'LCAmendmentController');
        Route::resource('manage-mother-vasle', 'ManageMotherVasleController');
        Route::resource('mother-vasle', 'MotherVasleController');
        
        Route::post('find-product-details-with-type-id', 'AddToStockController@getTypeWiseProduct');
    });

    // ********* Truck Management ****** //
    Route::prefix(config('app.truck'))->group(function () {
        Route::resource('truck-info', 'TruckController');
        Route::get('truck-rent-report', 'TruckController@rentReport');
        Route::post('truck-rent-report', 'TruckController@rentReportFilter')->name('truck-rent-report.filter');
    });
    // ********* Lighter Agency Management by Naim ****** //
    Route::prefix(config('app.lighter'))->group(function () {
        Route::resource('manage-agency', 'ManageAgencyController');
        Route::put('add-predue-to-agency/{id}', 'ManageAgencyController@addPreDueToAgency')->name('add-predue-to-agency');
        Route::resource('view-report', 'ViewReportController');
        Route::resource('payment', 'PaymentController');
        
        Route::get('agency-ledger/{id}', 'ManageAgencyController@agencyLedger')->name('agency-ledger');
    });

    // ********* Sale Product ***** //
    Route::prefix(config('app.sell'))->group(function () {
        Route::resource('product-sell', 'ProductSellController');
        

        Route::post('find-product-details-with-branch-id', 'ProductSellController@findProductDetailWithBranchId');

        Route::post('find-unitprice-with-package-id', 'ProductSellController@findUnitPriceWithPackageId');
        Route::post('find-product-details-with-id', 'ProductSellController@findproductDetailWithId');
        Route::get('sell-report', 'ProductSellController@showReport');
        Route::post('sell-report', 'ProductSellController@showReportFilter')->name('sell-report.filter');
        
        Route::get('product-wise-sell-report', 'ProductSellController@productWiseSellReport');
        Route::post('product-wise-sell-report', 'ProductSellController@productWiseSellReportFilter')->name('product-wise-sell-report.filter');
        Route::get('sell-invoice/{id}', 'ProductSellController@sellInvoice');
        
        Route::get('sell-product-delete/{id}/{tok}', 'SellProductEditController@sellProductDelete')->name('sell-product-delete');
    });

    // ******* Vat *********//
    Route::prefix(config('app.vat'))->group(function () {
        Route::get('vat-report', 'VatReportController@index');
        Route::post('vat-report', 'VatReportController@filter')->name('vat.filter');
    });

    // ******* User *********//
    Route::prefix(config('app.user'))->group(function () {
        Route::resource('user', 'UserController');
    });

    // ****** Return Product ***********//
    Route::prefix(config('app.return'))->group(function () {
        Route::get('return-form', 'ReturnFormController@index');
        //Route::post('customer-return', 'CustomerReturnFormController@customerReturnForm');
        Route::get('/customer-return/', 'ReturnFormController@customerReturnForm')->name('customer-return');
        Route::get('/supplier-return/', 'ReturnFormController@supplierReturnForm')->name('supplier-return');
        Route::resource('customer-return-from-submit', 'CustomerReturnFormSubmitController');
        Route::resource('supplier-return-from-submit', 'SupplierReturnFormSubmitController');
        Route::get('return-list-from-customer', 'ReturnFormController@showCustomerReturnReport');
        Route::post('return-list-from-customer', 'ReturnFormController@showCustomerReturnReportFilter')->name('return-list-from-customer.filter');
        Route::get('return-list-to-supplier', 'ReturnFormController@showSupplierReturnReport');
        Route::post('return-list-to-supplier', 'ReturnFormController@showSupplierReturnReportFilter')->name('return-list-to-supplier.filter');
        Route::get('supplier-return-detail/{id}', 'ReturnFormController@showSupplierReturnDetail');
        Route::get('wastage-list', 'ReturnFormController@showWastageListReport');
        Route::post('wastage-list', 'ReturnFormController@showWastageListReportFilter')->name('wastage-list.filter');
        
        Route::get('cus-return-details/{tok}', 'CustomerReturnFormSubmitController@showDetails');
    });

    // ********************* Amenment Part **************** //
    Route::prefix(config('app.amendment'))->group(function () {
        Route::resource('purchase-product-edit', 'PurchaseProductEditController');
        Route::post('purchase-product-edit', 'PurchaseProductEditController@filter')->name('product-edit.filter');
        Route::get('delete-purchase-product/{id}/{tok}', 'PurchaseProductEditController@deletePurchaseItem');
        Route::resource('sell-product-edit', 'SellProductEditController');
        Route::post('sell-product-edit', 'SellProductEditController@filter')->name('sell-product-edit.filter');
        Route::resource('other-receive-amenment', 'OtherReceiveAmenmentController');
        Route::post('other-receive-amenment', 'OtherReceiveAmenmentController@filter')->name('other-receive.filter');
        Route::resource('other-payment-amenment', 'OtherPaymentAmenmentController');
        Route::post('other-payment-amenment', 'OtherPaymentAmenmentController@filter')->name('other-payment.filter');
        Route::resource('bank-deposit-amendment', 'BankDepositAmenmentController');
        Route::post('bank-deposit-amendment', 'BankDepositAmenmentController@filter')->name('bank-deposit.filter');
        Route::resource('bank-withdraw-amendment', 'BankWithdrawAmenmentController');
        Route::post('bank-withdraw-amendment', 'BankWithdrawAmenmentController@filter')->name('bank-withdraw.filter');
        Route::resource('bank-transfer-amendment', 'BankTransferAmenmentController');
        Route::post('bank-transfer-amendment', 'BankTransferAmenmentController@filter')->name('bank-transfer.filter');
        Route::resource('supplier-payment-amendment', 'SupplierPaymentAmenmentController');
        Route::post('supplier-payment-amendment', 'SupplierPaymentAmenmentController@filter')->name('supplier-payment-amendment.filter');
        Route::resource('customer-bill-amendment', 'CustomerBillCollectionAmenmentController');
        Route::post('customer-bill-amendment', 'CustomerBillCollectionAmenmentController@filter')->name('customer-bill-amendment.filter');
        //edit part
        Route::put('edit-receive-voucher/{id}', 'OtherReceiveAmenmentController@update')->name('edit-receive-voucher');
        Route::put('edit-payment-voucher/{id}', 'OtherPaymentAmenmentController@update')->name('edit-payment-voucher');
        Route::put('edit-bank-deposit/{id}', 'BankDepositAmenmentController@update')->name('edit-bank-deposit');
        Route::put('edit-bank-withdraw/{id}', 'BankWithdrawAmenmentController@update')->name('edit-bank-withdraw');
        Route::put('edit-suplier-payment/{id}', 'SupplierPaymentAmenmentController@update')->name('edit-suplier-payment');
        Route::put('edit-bill-collection/{id}', 'CustomerBillCollectionAmenmentController@update')->name('edit-bill-collection');
        
        Route::get('employee-salary-amendment', 'EmployeeController@getSalaryForAmendment');
        Route::delete('delete-employee-salary/{id}', 'EmployeeController@deleteSalaryForAmendment')->name('delete-employee-salary');
        Route::post('employee-salary-amendment', 'EmployeeController@searchEmpSalaryAmendmentFilter')->name('employee-salary-amendment.filter');
        
        // distribution amendment
        Route::get('branch-distribution-amendment', 'DistributionReportController@branchDistribution');
        Route::post('branch-distribution-amendment', 'DistributionReportController@branchDistributionFilter')->name('branch-distribution-amendment.filter');
        Route::delete('delete-branch-distribution/{id}', 'DistributionReportController@destroy')->name('delete-branch-distribution');
    });

    // ********** Site Setting ***** //
    Route::prefix(config('app.site-setting'))->group(function () {
        Route::resource('site-setting', 'SiteSettingController');
    });

    // *********** Language ************ //
    Route::get('lang/home', 'LangController@index');
    Route::get('lang/change', 'LangController@change')->name('changeLang');
});

//Clear Cache facade value:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});
//Reoptimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});
//Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});
//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});
//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});
//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});