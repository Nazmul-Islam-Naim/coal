<?php

namespace App\Exports;

use App\Models\OtherReceiveVoucher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReceiveVoucherExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //return OtherReceiveVoucher::all();

        return OtherReceiveVoucher::join('bank_account', 'other_receive_voucher.bank_id', '=', 'bank_account.id')
        	->join('other_receive_type', 'other_receive_voucher.receive_type_id', '=', 'other_receive_type.id')
        	->join('other_receive_sub_type', 'other_receive_voucher.receive_sub_type_id', '=', 'other_receive_sub_type.id')
        	->join('users', 'other_receive_voucher.created_by', '=', 'users.id')
        	->select('other_receive_voucher.id', 'other_receive_voucher.receive_date', 'bank_account.bank_name', 'other_receive_type.name', 'other_receive_sub_type.name as subName', 'other_receive_voucher.issue_by', 'users.name as createdBy', 'other_receive_voucher.amount')
        	->get();
    }

    public function headings(): array
    {
        return [
            'SL',
            'Date',
            'Receive Method',
            'Type',
            'Sub Type',
            'Issue By',
            'Created By',
            'Amount',
        ];
    }
}
