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
            'first_name' => 'required|regex:/^[\p{L}\s]+$/u|min:2|max:50',
            'last_name' => 'required|regex:/^[\p{L}\s]+$/u|min:2|max:50',
            'email' => 'required|min:6|max:50|unique:users,username',
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
            'name' => 'اسم الأب',
            'username' => 'اسم المستخدم',
            'password' => 'كلمة المرور',
        ];
    }
    //===========================================================================================================================

    public function messages(): array
    {
        return [
            'required' => ' :attribute مطلوب',
            'unique' => ':attribute  موجود سابقاً , يجب أن يكون :attribute غير مكرر',
            'regex' => 'يجب أن يحوي  :attribute على أحرف فقط',
            'max' => 'الحد الأقصى لطول  :attribute هو 50 حرف',
            'string' => 'يجب أن يكون :attribute عبارة عن سلسة نصية',
            'name.min' => 'الحد الأدنى لطول :attribute على الأقل هو 2 حرف',
            'username.min' => 'الحد الأدنى لطول :attribute على الأقل هو 2 حرف',
            'password.min' => 'الحد الأدنى لطول :attribute على الأقل هو 8 محرف',
        ];
    }
}
