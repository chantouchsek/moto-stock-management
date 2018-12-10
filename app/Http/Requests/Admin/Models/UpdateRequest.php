<?php

namespace App\Http\Requests\Admin\Models;

use App\Http\Requests\BaseRequest as FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'name' => ['required', 'min:3', 'string'],
            'make_id' => [
                'required', Rule::exists('makes', 'id')
            ]
        ];
    }
}
