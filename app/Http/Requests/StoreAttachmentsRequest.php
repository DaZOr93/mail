<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttachmentsRequest extends FormRequest
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
            'file' => 'file|mimes:pdf,docx,doc,zip,rar,txt,xlsx,xls,ppt,jpeg,bmp,png'
        ];
    }

    public function messages()
    {
        return [
            'file.mimes' => 'Недопустимый формат файла'
        ];
    }
}
