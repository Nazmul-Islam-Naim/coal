<?php

namespace App\Exports;

use App\Models\ProductPurchase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchaseReportExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //return ProductPurchase::all();

        return ProductPurchase::join('supplier', 'product_purchase.supplier_id', '=', 'supplier.id')
        	->join('bank_account', 'product_purchase.payment_method', '=', 'bank_account.id')
        	->join('users', 'product_purchase.created_by', '=', 'users.id')
        	->select('product_purchase.id', 'product_purchase.purchase_date', 'product_purchase.tok', 'supplier.name as supplierName', 'bank_account.bank_name', 'users.name', 'product_purchase.sub_total')
        	->get();
    }

    public function headings(): array
    {
        return [
            'SL',
            'Date',
            'Invoice',
            'Supplier',
            'Payment Method	',
            'Created By',
            'Sub Total',
        ];
    }
}
