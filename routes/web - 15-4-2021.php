<?php

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();
Route::group(['middleware'=>['auth']],function(){
    Route::get('dashboard', 'DashboardController@index');

    //****** Accounts ***********//
    Route::resource('bank-account', 'BankAccountController');
    Route::resource('account-type', 'AccountTypeController');
    Route::get('bank-deposit/{id}', 'BankDepositController@bankDeposit');
    Route::resource('bank-deposit', 'BankDepositController');
    Route::get('amount-transfer/{id}', 'AmountTransferController@amountTransfer');
    Route::resource('amount-transfer', 'AmountTransferController');
    Route::get('amount-withdraw/{id}', 'AmountWithdrawController@amountWithdraw');
    Route::resource('amount-withdraw', 'AmountWithdrawController');
    Route::get('bank-report/{id}', 'BankAccountController@showBankReport');
    Route::post('find-chequeno-with-chequebook-id', 'AmountWithdrawController@findChequeNoWithChequeBookId');
    Route::resource('cheque-book', 'ChequeBookController');
    Route::resource('cheque-no', 'ChequeNoController');
    Route::resource('daily-transaction', 'DailyTransactionController');
    // transaction filtering
    Route::post('daily-transaction', 'DailyTransactionController@filter')->name('transaction.filter');

    //******** Other Receive *******//
    Route::resource('receive-type', 'ReceiveTypeController');
    Route::resource('receive-sub-type', 'ReceiveSubTypeController');
    Route::resource('receive-voucher', 'ReceiveVoucherController');
    Route::get('receive-voucher-report', 'ReceiveVoucherController@report');
    // Receive filtering
    Route::post('receive-voucher-report', 'ReceiveVoucherController@filter')->name('receive.filter');
    Route::post('find-receive-subtype-with-type-id', 'ReceiveVoucherController@findReceiveSubTypeWithType');

    //******** Other Payment *******//
    Route::resource('payment-type', 'PaymentTypeController');
    Route::resource('payment-sub-type', 'PaymentSubTypeController');
    Route::resource('payment-voucher', 'PaymentVoucherController');
    Route::get('payment-voucher-report', 'PaymentVoucherController@report');
    // Receive filtering
    Route::post('payment-voucher-report', 'PaymentVoucherController@filter')->name('payment.filter');
    Route::post('find-payment-subtype-with-type-id', 'PaymentVoucherController@findPaymentSubTypeWithType');

    //****** Customers ******//
    Route::resource('customer', 'CustomerController');
    Route::get('customer-ledger/{id}', 'CustomerController@customerLedger')->name('customer-ledger');
    // Customer Ledger filtering
    Route::post('customer-ledger', 'CustomerController@filter')->name('customer-ledger.filter');
    Route::resource('achieve-gift-point', 'AchieveGiftPointController');
    Route::resource('customer-bill-collection', 'CustomerBillCollectionController');
    Route::get('customer-bill-collection-report', 'CustomerBillCollectionController@report');
    Route::post('customer-bill-collection-report', 'CustomerBillCollectionController@filter')->name('bill-collection.filter');

    Route::post('add-customer-via-pos-page', 'CustomerController@addCustomerViaPosPage');
    Route::resource('product-type', 'ProductTypeController');
    Route::resource('product-sub-type', 'ProductSubTypeController');
    Route::resource('product-unit', 'ProductUnitController');
    Route::resource('product-brand', 'ProductBrandController');
    Route::resource('product', 'ProductController');
    Route::post('find-product-subtype-with-type-id', 'ProductController@findProductSubTypeWithType');
    Route::get('barcode/{id}', 'BarcodeGeneratorController@index');
    Route::resource('stock-product', 'StockProductController');
    Route::get('stock-product-export', 'StockProductController@export');
    Route::resource('update-stock-product', 'UpdateStockProductController');

    // ********* Supplier ****** //
    Route::resource('product-supplier', 'ProductSupplierController');
    Route::get('product-supplier-payment', 'ProductSupplierController@supplierList');
    Route::get('product-supplier-payment-report', 'ProductSupplierController@supplierPaymentReport');
    Route::post('product-supplier-payment-report', 'ProductSupplierController@filter')->name('suplier-pay-report.filter');

    Route::resource('supplier-area', 'ProductSupplierAreaController');
    Route::get('supplier-ledger/{id}', 'ProductSupplierController@supplierLedger');

    // *********** Product Purchase ********* //
    Route::resource('product-purchase', 'ProductPurchaseController');
    Route::get('purchase-report', 'ProductPurchaseController@showReport');
    Route::post('purchase-report', 'ProductPurchaseController@filter')->name('purchase.filter');
    Route::get('purchase-report/{id}', 'ProductPurchaseController@showDetailsReport')->name('purchase-report');

    // ********* Sale Product ***** //
    Route::resource('product-sell', 'ProductSellController');
    Route::resource('pos-sell', 'PosSellController');
    Route::post('save-sell-via-pos-page', 'PosSellController@store');
    Route::post('print-invoice', 'PosSellController@printInvoice');
    Route::post('find-product-details-with-barcode', 'PosSellController@findProductDetailWithBarcode');

    Route::post('find-product-details-with-id', 'ProductSellController@findProductDetailWithId');
    Route::post('find-product-list-with-keyword', 'PosSellController@findProductListWithKeyword');

    Route::post('find-unitprice-with-package-id', 'ProductSellController@findUnitPriceWithPackageId');
    Route::get('sell-report', 'ProductSellController@showReport');
    Route::post('sell-report', 'ProductSellController@showReportFilter')->name('sell-report.filter');
    Route::get('product-wise-sell-report', 'ProductSellController@productWiseSellReport');
    Route::post('product-wise-sell-report', 'ProductSellController@productWiseSellReportFilter')->name('product-wise-sell-report.filter');
    Route::get('sell-invoice/{id}', 'ProductSellController@sellInvoice');

    // ******* Vat *********//
    Route::get('vat-report', 'VatReportController@index');
    Route::post('vat-report', 'VatReportController@filter')->name('vat.filter');

    // ******* User *********//
    Route::resource('user', 'UserController');

    // ****** Return Product ***********//
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

    Route::get('wastage-list', 'ReturnFormController@showWastageListReport');
    Route::post('wastage-list', 'ReturnFormController@showWastageListReportFilter')->name('wastage-list.filter');

    // ********************* edit Part **************** //
    Route::resource('purchase-product-edit', 'PurchaseProductEditController');
    Route::post('purchase-product-edit', 'PurchaseProductEditController@filter')->name('product-edit.filter');

    Route::resource('sell-product-edit', 'SellProductEditController');
    Route::post('sell-product-edit', 'SellProductEditController@filter')->name('sell-product-edit.filter');

    // ************** Amenment part ************* //
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

    // ********** Site Setting ***** //
    Route::resource('site-setting', 'SiteSettingController');

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