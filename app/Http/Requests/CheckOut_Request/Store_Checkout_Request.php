<?php

namespace App\Http\Requests\Checkout_Request;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;

class Store_Checkout_Request extends FormRequest
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
            'trip_id' => 'required|exists:trips,id',
            'student_id' => 'required|exists:students,id',
            'checkout' => 'required|in:1,0',
            'note' => 'sometimes|nullable|string|min:5|max:50',
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
            'trip_id' => 'اسم الرحلة',
            'student_id' => 'اسم الطالب',
            'checkout' => 'التفقد',
            'note' => 'الملاحظات',
        ];
    }
    //===========================================================================================================================

    public function messages(): array
    {
        return [
            'required' => ' :attribute مطلوب',
            'integer' => 'يجب أن يكون الحقل :attribute من نمط int',
            'trip_id.exists' => ':attribute غير موجود , يجب أن يكون :attribute موجود ضمن الرحلات المخزنة سابقا',
            'student_id.exists' => ':attribute غير موجود , يجب أن يكون :attribute موجود ضمن الطلاب المخزنة سابقا',
            'boolean' => ' يجب أن تكون :attribute  قيمتها إما 1 أو 0',
            'min' => 'الحد الأدنى لطول :attribute على الأقل هو 5 حرف',
            'max' => 'الحد الأقصى لطول  :attribute هو 50 حرف',
        ];
    }
}
