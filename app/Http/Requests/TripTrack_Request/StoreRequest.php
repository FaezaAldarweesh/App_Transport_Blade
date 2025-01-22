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
            'location' => [
                'required',
                'regex:/^([0-8]?\d(\.\d+)?|90(\.0+)?)°([0-5]?\d)\'([0-5]?\d(\.\d+)?)"(N|S)\s(1[0-7]\d(\.\d+)?|0?\d{1,2}(\.0+)?|180(\.0+)?)°([0-5]?\d)\'([0-5]?\d(\.\d+)?)"(E|W)$/',
            ],
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
            'location' => 'الموقع الجغرافي'
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
            'location.regex' => 'صيغة :attribute غير صحيحة.',
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
