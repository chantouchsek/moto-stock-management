<?php

namespace App\Http\Requests\Admin\Sale;

use App\Http\Requests\BaseRequest as FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            'customer_name' => [
                'required', 'min:2', 'string'
            ],
            'product_id' => [
                'required',
                Rule::exists('products', 'id')->whereNull('sole_on')
            ],
            'engine_number' => [
                'required', 'string',
                Rule::exists('products', 'engine_number')->whereNull('sole_on')
            ],
            'price' => 'required',
            'date' => 'required|date',
            'in_lack_amount' => 'required_if:is_in_lack,1'
        ];
    }
}
