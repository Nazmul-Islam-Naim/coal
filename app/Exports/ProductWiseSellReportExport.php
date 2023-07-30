<?php

namespace App\Exports;

use App\Models\ProductSellDetails;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ProductWiseSellReportExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //return ProductSellDetails::all();
        return ProductSellDetails::join('customer', 'product_sell_details.customer_id', '=', 'customer.id')
        	->join('product', 'product_sell_details.product_id', '=', 'product.id')
        	->select('product_sell_details.id', 'product_sell_details.sell_date', 'customer.name', 'product.name as proName', 'product_sell_details.quantity', 'product_sell_details.unit_price', 'product_sell_details.vat_amount', 'product_sell_details.quantity', DB::raw('product_sell_details.quantity*product_sell_details.unit_price'))
        	->get();
    }

    public function headings(): array
    {
        return [
            'SL',
            'Date',
            'Customer',
            'Product',
            'Quantity',
            'Unit Price',
            'Vat',
            'Total Price',
        ];
    }
}
