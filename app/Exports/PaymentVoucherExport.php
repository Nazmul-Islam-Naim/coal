<?php

namespace App\Exports;

use App\Models\OtherPaymentVoucher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentVoucherExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return OtherPaymentVoucher::join('bank_account', 'other_payment_voucher.bank_id', '=', 'bank_account.id')
        	->join('other_payment_type', 'other_payment_voucher.payment_type_id', '=', 'other_payment_type.id')
        	->join('other_payment_sub_type', 'other_payment_voucher.payment_sub_type_id', '=', 'other_payment_sub_type.id')
        	->join('users', 'other_payment_voucher.created_by', '=', 'users.id')
        	->select('other_payment_voucher.id', 'other_payment_voucher.payment_date', 'bank_account.bank_name', 'other_payment_type.name', 'other_payment_sub_type.name as subName', 'other_payment_voucher.issue_by', 'users.name as createdBy', 'other_payment_voucher.amount')
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
