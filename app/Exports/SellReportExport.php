<?php

namespace App\Exports;

use App\Models\ProductSell;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SellReportExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //return ProductSell::all();
        return ProductSell::join('customer', 'product_sell.customer_id', '=', 'customer.id')
        	->select('product_sell.id', 'product_sell.sell_date', 'product_sell.tok', 'customer.name', 'product_sell.discount', 'product_sell.total_vat', 'product_sell.sub_total')
        	->get();
    }

    public function headings(): array
    {
        return [
            'SL',
            'Date',
            'Invoice',
            'Customer',
            'Discount',
            'Vat',
            'Total Price'
        ];
    }
}
