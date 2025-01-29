<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;

class Transport_Request extends FormRequest
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
            'students' => 'required|array',
            'students.*' => 'required|integer|exists:students,id',
            'trip_id' => 'required|exists:trips,id',
            'station_id' => 'required|exists:stations,id',
        ];
    }
    // //===========================================================================================================================
    protected function passedValidation()
    {
        //تسجيل وقت إضافي
        Log::info('تمت عملية التحقق بنجاح في ' . now());

    }
    //===========================================================================================================================
    public function attributes(): array
    {
        return [
            'student' => 'اسم الطالب',
            'trip_id' => 'الرحلة',
            'station_id' => 'المحطة',
        ];
    }
    //===========================================================================================================================

    public function messages(): array
    {
        return [
            'required' => ' :attribute مطلوب',
            'integer' => 'يجب أن يكون الحقل :attribute من نمط int',
            'trip_id.exists' => ':attribute غير موجودة , يجب أن تكون :attribute موجودة ضمن الرحل المخزنة سابقا',
            'station_id.exists' => ':attribute غير موجودة , يجب أن تكون :attribute موجودة ضمن المحطات المخزنة سابقا',
            'students.*.id.exists' => 'يجب أن يكون :attribute موجودا مسبقا',
        ];
    }
}
