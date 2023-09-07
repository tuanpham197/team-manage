<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\HttpCodeEnum;
use App\Helpers\Helper;
use App\Helpers\ResponseApi;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class BaseFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    abstract public function rules(): array;

    /**
     * Determine if the user is authorized to make this request.
     */
    abstract public function authorize(): bool;

    /**
     * Handle a failed validation attempt.
     *
     *
     * @return void
     */
    public function failedValidation(Validator $validator)
    {
        $arrError = $validator->errors()->toArray();

        $errors = array_map(function ($field) {
            $error = [];
            foreach ($field as $strErr) {
                [$rule, $strCodeParam] = explode('|', $strErr);
                $arrCodeParam = explode(':', $strCodeParam);
                $arrCodeParam[] = '';
                [$code, $params] = $arrCodeParam;

                $error[$rule] = [
                    'code' => $code,
                    'params' => strlen($params) ? explode(',', $params) : [],
                ];
            }

            return $error;
        }, $arrError);

        throw new HttpResponseException(ResponseApi::responseFail($errors, HttpCodeEnum::HTTP_VALIDATION_FORM_REQUEST, 'Validation errors'), );
    }

    public function messages()
    {
        $arrMessages = [];
        $rules = $this->rules();

        $arrCodeMessages = Helper::getCustomMessageErr();

        foreach ($rules as $attribute => $strRules) {
            $arr = explode('|', $strRules);
            foreach ($arr as $rule) {
                [$r] = explode(':', $rule);
                $key = "{$attribute}.{$r}";

                $arrMessages[$key] = "{$r}|{$arrCodeMessages[$r]}";
            }
        }

        return $arrMessages;
    }
}
