<?php

namespace App\Http\Requests\LocalPurchase;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'local_supplier_id' => ['required'],
            'date' => ['required'],
            'note' => ['nullable'],
            'purchase_details'            =>  ['required', 'array'],
            'purchase_details.*.product_id' => ['required'],
            'purchase_details.*.unit_price' => ['required'],
            'purchase_details.*.quantity' => ['required']
        ];
    }
}
