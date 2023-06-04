<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['sometimes', 'required', 'string'],
            'email' => ['sometimes', 'required', 'string', 'email'],
            'password' => ['sometimes', 'required',  'string', 'min:6']
        ];
    }
}
