<?php

namespace App\Http\Requests\User_Rqeuests;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class Store_User_Request extends FormRequest
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
            'name' => 'required|regex:/^[\p{L}\s]+$/u|min:2|max:50',
            'email' => 'required|min:6|max:50|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required',
            'first_phone' => 'required|min:10|max:10|regex:/^([0-9\s\-\+\(\)]*)$/|unique:users,first_phone',
            'secound_phone' => 'nullable|min:10|max:10|regex:/^([0-9\s\-\+\(\)]*)$/|unique:users,secound_phone',
            'location' => 'required|string|min:5',
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
            'name' => 'اسم المستخدم',
            'email' => 'ايميل المستخدم',
            'password' => 'كلمة المرور',
            'role' => 'دور المستخدم',
            'first_phone' => 'الرقم الأول',
            'secound_phone' => 'الرقم الثاني',
            'location' => 'الموقع',
        ];
    }
    //===========================================================================================================================

    public function messages(): array
    {
        return [
            'required' => ' :attribute مطلوب',
            'regex' => 'يجب أن يحوي  :attribute على أحرف فقط',
            'name.min' => 'الحد الأدنى لطول :attribute على الأقل هو 2 حرف',
            'max' => 'الحد الأقصى لطول  :attribute هو 50 حرف',
            'email.min' => 'الحد الأدنى لطول :attribute على الأقل هو 2 حرف',
            'email' => 'يجب أن يكون :attribute عبارة عن  إيميل يحوي علامة @',
            'unique' => ':attribute  موجود سابقاً , يجب أن يكون :attribute غير مكرر',
            'string' => 'يجب أن يكون :attribute عبارة عن سلسة نصية',
            'password.min' => 'الحد الأدنى لطول :attribute على الأقل هو 8 محرف',
            'first_phone.max' => 'الحد الأقصى لطول  :attribute هو 10 حرف',
            'first_phone.min' => 'الحد الأدنى لطول :attribute على الأقل هو 10 حرف',
            'secound_phone.max' => 'الحد الأقصى لطول  :attribute هو 10 حرف',
            'secound_phone.min' => 'الحد الأدنى لطول :attribute على الأقل هو 10 حرف',
            'location.min' => 'الحد الأدنى لطول :attribute على الأقل هو 5 حرف',
            'first_phone.regex' => 'يجب أن يحوي  :attribute على أرقام فقط',
            'secound_phone.regex' => 'يجب أن يحوي  :attribute على أرقام فقط',
        ];
    }
}
