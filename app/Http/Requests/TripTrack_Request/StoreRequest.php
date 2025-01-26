<?php

namespace App\Http\Requests\TripTrack_Request;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class StoreRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'trip_id' => ['required', 'integer', 'exists:trips,id'],
            'latitude' => ['required','numeric'],
            'longitude' => ['required','numeric'],
        ];
    }

    /**
     * Attribute name in case of exception
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'trip_id' => 'الرحلة',
            'longitude' => 'خط الطول',
            'latitude' => 'خط العرض'
        ];
    }

    /**
     * error message
     * @return string[]
     */
    public function messages()
    {
        return [
            'required' => ' :attribute مطلوب',
            'integer' => 'يجب أن يكون الحقل :attribute من نمط integer',
            'trip_id.exists' => ':attribute موجودة ضمن الرحلات المخزنة سابقا يجب أن تكون',
        ];
    }

    /**
     * Handle validation errors and throw an exception.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator The validation instance.
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();
        throw new HttpResponseException(
            response()->json([
                'message' => $errors
            ], 422)
        );
    }
}
