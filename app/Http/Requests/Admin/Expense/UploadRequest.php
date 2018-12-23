<?php

namespace App\Http\Requests\Admin\Expense;

use App\Http\Requests\BaseRequest as FormRequest;

class UploadRequest extends FormRequest
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
            'files' => 'required',
            'files.*' => 'mimes:png,gif,jpeg,jpg,pdf,doc,docx,xls,xlsx|max:10240'
        ];
    }
}
