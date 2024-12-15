<?php

namespace App\Http\Requests\Auth_Requests;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class loginRequest extends FormRequest
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
            'email' => 'required|string',
            'password' => 'required|string|min:8',
        ];
    }
    //===========================================================================================================================
    protected function passedValidation()
    {
        //تسجيل وقت إضافي
        Log::info('تمت عملية التحقق بنجاح في ' . now());

    }
    //===========================================================================================================================
    public function attributes(): array
    {
        return [
            'email' => 'البريد الإلكتروني',
            'password' => 'كلمة المرور',
        ];
    }
    //===========================================================================================================================

    public function messages(): array
    {
        return [
            'required' => 'حقل :attribute مطلوب',
            'string' => 'يجب أن يكون الحقل :attribute سلسلة محارف',
            'email' => 'يجب أن يكون الحقل :attribute من نمط إيميل يحوي على @',
            'min' => 'الحد الأدنى لطول :attribute هو 8',
        ];
    }
}
