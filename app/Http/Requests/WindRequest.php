<?php

namespace App\Http\Requests;

use App\Http\Controllers\StatusCode;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class WindRequest extends FormRequest
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
            'zipcode' => 'required|regex:/\b\d{5}\b/',
        ];
    }

    /**
     * Get all parameters
     *
     * @param string $keys
     *
     * @return array
     */
    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['zipcode'] = $this->route('zipcode');
        return $data;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(),StatusCode::HTTP_BAD_REQUEST, ['Content-Type' => 'application/json']));
    }
}
