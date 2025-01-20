<?php

namespace App\Http\Requests\Student_Request;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class Update_Student_Request extends FormRequest
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
            'name' => 'sometimes|nullable|unique:students,name,' . $this->route('student') . '|regex:/^[\p{L}\s]+$/u|min:2|max:50',
            'user_id' => 'sometimes|nullable|integer|exists:users,id',
            'gender' => 'sometimes|nullable|string|in:male,female',
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
            'name' => 'اسم الطالب',
            'user_id' => 'اسم الأب',
            'gender' => 'الجنس',
        ];
    }
    //===========================================================================================================================

    public function messages(): array
    {
        return [
            'unique' => ':attribute  موجود سابقاً , يجب أن يكون :attribute غير مكرر',
            'name.regex' => 'يجب أن يحوي  :attribute على أحرف فقط',
            'name.max' => 'الحد الأقصى لطول  :attribute هو 50 حرف',
            'name.min' => 'الحد الأدنى لطول :attribute على الأقل هو 2 حرف',
            'integer' => 'يجب أن يكون الحقل :attribute من نمط int',
            'in' => 'يأخذ الحقل :attribute فقط القيم إما ( male أو female )',
        ];
    }
}
