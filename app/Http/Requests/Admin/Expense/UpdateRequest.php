<?php

namespace App\Http\Requests\Admin\Expense;

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
            'amount' => ['required', 'min:3', 'int'],
            'date' => 'required|date',
            'expense_on' => 'max:255'
        ];
    }
}
