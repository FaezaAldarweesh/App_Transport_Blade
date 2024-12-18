<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class Employee_Request extends FormRequest
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
            //
            'name' => 'required|regex:/^[\p{L}\s]+$/u|min:3|max:50',
            'em_job' => 'required|regex:/^[\p{L}\s]+$/u|min:2|max:50',   
            'phone' => 'required|string|regex:/^09\d{8}$/',

        ];
    }
    public function attributes(): array
    {
        return [
            'name' => 'اسم الطالب',
            'em_job' => 'مهنة الموظف',
            'phone' => 'رقم الهاتف',
        ];
    }

//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

    public function messages(): array
    {
        return [
            'required' => ' :attribute مطلوب',
            'unique' => ':attribute  موجود سابقاً , يجب أن يكون :attribute غير مكرر',
            'name.regex' => 'يجب أن يحوي  :attribute على أحرف فقط',
            'name.min' => 'يجب أن يكون :attribute يحوي ثلاث أحرف على الأقل',
            'name.max' => 'يجب أن يكون :attribute يحوي 50 حرف على الأكثر',
            'em_job.regex' => 'يجب أن يحوي :atttibutr على أحرف فقط',
            'em_job.required' =>':attribute مطلوبة',
            'em_job.min' => 'يجب أن يكون :attribute يحوي حرفين على الأقل',
            'em_job.max' => 'يجب أن يكون :attribute يحوي 50 حرف على الأكثر',
            'phone.regex' => 'يجب أن :attribute صحيح',
            'string' => 'يجب أن يكون :attribute سلسلة نصية',
        ];
    }
}
