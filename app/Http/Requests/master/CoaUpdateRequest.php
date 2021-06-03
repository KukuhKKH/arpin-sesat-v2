<?php

namespace App\Http\Requests\master;

use App\Models\Master\Coa;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CoaUpdateRequest extends FormRequest
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
        $code = Coa::find(request()->segment(4));
        return [
            'code' => ['required', Rule::unique(Coa::class)->ignore($code->id, 'id')],
            'name' => 'required'
        ];
    }
}
