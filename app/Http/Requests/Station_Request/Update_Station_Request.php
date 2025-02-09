<?php

namespace App\Http\Requests\Station_Request;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class Update_Station_Request extends FormRequest
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
            'name' => 'sometimes|nullable|string|min:4|max:50',
            'path_id' => 'sometimes|nullable|integer|exists:paths,id',
            'status' => 'sometimes|nullable|string|in:0,1',
            'time_go' => 'sometimes|nullable|regex:/^\d{2}:\d{2}(:\d{2})?$/',
            'time_back' => 'sometimes|nullable|regex:/^\d{2}:\d{2}(:\d{2})?$/',
            'latitude' => ['sometimes','nullable','numeric'],
            'longitude' => ['sometimes','nullable','numeric'],
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
            'name' => 'اسم الشعبة',
            'path_id' => 'اسم الصف',
            'status' => 'حالة المحطة',
            'time_go' =>'زمن الذهاب للمحطة',
            'time_back' =>'زمن العودة للمحطة',
            'longitude' => 'خط الطول',
            'latitude' => 'خط العرض'
        ];
    }
    //===========================================================================================================================

    public function messages(): array
    {
        return [
            'max' => 'الحد الأقصى لطول  :attribute هو 50 حرف',
            'min' => 'الحد الأدنى لطول :attribute على الأقل هو 4 حرف',
            'integer' => 'يجب أن يكون الحقل :attribute من نمط int',
            'exists' => 'يجب أن يكون :attribute موجودا مسبقا',
            'in' => 'يجب أن تكون قيمة الحقل :attribute إحدى القيم التالية: 0,1',
        ];
    }
}
