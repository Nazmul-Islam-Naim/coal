<?php

namespace App\Exports;

use App\Models\ProductReturn;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerReturnExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ProductReturn::join('customer', 'product_return.customer_id', '=', 'customer.id')
        	->select('product_return.id', 'product_return.return_date', 'product_return.tok', 'customer.name', 'product_return.total_deduction_amount', 'product_return.total_vat', 'product_return.net_return_amount')
        	->get();
    }

    public function headings(): array
    {
        return [
            'SL',
            'Date',
            'Invoice',
            'Customer',
            'Deduction Amount',
            'Total Vat',
            'Return Amount'
        ];
    }
}
