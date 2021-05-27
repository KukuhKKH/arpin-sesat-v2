<?php

namespace App\Http\Requests\master;

use Illuminate\Foundation\Http\FormRequest;

class CoaCreateRequest extends FormRequest
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
            'code' => 'required|unique:m_coa',
            'name' => 'required'
        ];
    }
}
