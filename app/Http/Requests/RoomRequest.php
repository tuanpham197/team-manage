<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'custom_name' => [
                'string',
                'nullable',
            ],
            'custom_avatar' => [
                'string',
                'nullable',
            ],
            'owner_id' => [
                'required',
                'numeric',
            ],
            'guest_id' => [
                'required',
                'numeric',
            ],
        ];
    }
}
