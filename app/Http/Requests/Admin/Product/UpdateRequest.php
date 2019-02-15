<?php

namespace App\Http\Requests\Admin\Product;

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
            'name' => 'required|string|min:2',
            'price' => 'required',
            'cost' => 'required',
            'make_id' => [
                'required',
                Rule::exists('makes', 'id')
            ],
            'model_id' => [
                'required',
                Rule::exists('models', 'id')
            ],
            'color_id' => [
                'required',
                Rule::exists('colors', 'id')
            ],
            'date_import' => 'required|date_format:Y-m-d',
            'engine_number' => 'required|unique:products,engine_number,' . $this->id,
            'frame_number' => 'required|unique:products,frame_number,' . $this->id,
            'plate_number' => 'required_if:status,second_hand'
        ];
    }
}
