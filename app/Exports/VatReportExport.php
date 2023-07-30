<?php

namespace App\Exports;

use App\Models\ProductSell;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VatReportExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ProductSell::join('users', 'product_sell.created_by', '=', 'users.id')
        	->select('product_sell.id', 'product_sell.sell_date', 'product_sell.tok', 'product_sell.sub_total', 'product_sell.total_vat', 'product_sell.discount', 'users.name')
        	->get();
    }

    public function headings(): array
    {
        return [
            'SL',
            'Date',
            'Invoice',
            'Sub Total',
            'Vat Amount',
            'Discount Amount',
            'User Name'
        ];
    }
}
