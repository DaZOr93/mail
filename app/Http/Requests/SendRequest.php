<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendRequest extends FormRequest
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
            'subject' => 'required|string',
            'to' => 'required|string',
            'editorData' => 'required|min:20',
            'attach' => 'array',
            'letterId' => 'integer',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'subject.required' => 'Тема обязательно к заполнению',
            'subject.string' => 'Неверный формат данных',
            'to.required' => 'Укажите Email получателя',
            'editorData.required' => 'Письмо не может быть пустым',
            'editorData.min' => 'Миниум 20 символов',
        ];
    }


}
