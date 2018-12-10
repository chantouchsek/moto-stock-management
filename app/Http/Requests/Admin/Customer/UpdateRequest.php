<?php

namespace App\Http\Requests\Admin\Customer;

use App\Http\Requests\BaseRequest as FormRequest;

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
            'first_name' => 'required|string|min:2',
            'last_name' => 'required|string|min:2',
            'phone_number' => 'required|min:9|unique:customers,phone_number,' . $this->id
        ];
    }
}
