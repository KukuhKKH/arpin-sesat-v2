<?php

namespace App\Http\Requests\master;

use Illuminate\Foundation\Http\FormRequest;

class SellingCreateRequest extends FormRequest
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
            'customer_id' => 'required',
            'product_id' => 'required',
            'amount' => 'required',
            'date' => 'required'
        ];
    }
}
