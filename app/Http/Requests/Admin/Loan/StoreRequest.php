<?php

namespace App\Http\Requests\Admin\Loan;

use App\Http\Requests\BaseRequest as FormRequest;

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
            'amount' => [
                'required', 'min:2'
            ],
            'reason' => [
                'required', 'min:5', 'max:255'
            ],
            'needed_date' => [
                'required', 'date', 'after:today'
            ]
        ];
    }
}
