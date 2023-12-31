<?php

declare(strict_types=1);

namespace App\Http\Requests;

class LoginRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'min:6|string',
        ];
    }

//    public function messages()
//    {
//        return [
//            'password.numeric' => "numeric|Numeric",
//            'password.min' => "min|Min",
//            'email.required' => "required|email Required",
//            'email.email' => "email|Emil",
//        ];
//    }
}
