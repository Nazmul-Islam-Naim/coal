<?php

namespace App\Exports;

use App\Models\ProductWastageDetails;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WastageReportExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ProductWastageDetails::join('customer', 'product_wastage_details.customer_id', '=', 'customer.id')
        	->join('product', 'product_wastage_details.product_id', '=', 'product.id')
        	->select('product_wastage_details.id', 'product_wastage_details.tok', 'customer.name', 'product.name as proName', 'product_wastage_details.return_qnty', 'product_wastage_details.deduction_percent', 'product_wastage_details.total_amount')
        	->get();
    }

    public function headings(): array
    {
        return [
            'SL',
            'Invoice',
            'Customer',
            'Product',
            'Return Quantity',
            'Deduction(%)',
            'Total Amount'
        ];
    }
}
