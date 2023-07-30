<?php

namespace App\Exports;

use App\Models\ProductReturnToSupplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SupplierReturnExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ProductReturnToSupplier::join('supplier', 'product_return_to_supplier.supplier_id', '=', 'supplier.id')
        	->select('product_return_to_supplier.id', 'product_return_to_supplier.return_date', 'product_return_to_supplier.tok', 'supplier.name', 'product_return_to_supplier.total_deduction_amount', 'product_return_to_supplier.net_return_amount')
        	->get();
    }

    public function headings(): array
    {
        return [
            'SL',
            'Date',
            'Invoice',
            'Supplier',
            'Deduction Amount',
            'Return Amount'
        ];
    }
}
