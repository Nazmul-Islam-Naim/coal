<?php

namespace App\Exports;

use App\Models\StockProduct;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockProductExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return StockProduct::join('product', 'stock_product.product_id', '=', 'product.id')
        	->select('stock_product.id', 'product.name', 'stock_product.quantity', 'stock_product.unit_price')
        	->get();
    }

    public function headings(): array
    {
        return [
            'SL',
            'Product Name',
            'Quantity',
            'Unit Price'
        ];
    }
}
