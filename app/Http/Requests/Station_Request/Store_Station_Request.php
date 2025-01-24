<?php

namespace App\Http\Requests\Station_Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class Store_Station_Request extends FormRequest
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
            'name' => 'required|string|min:4|max:50',
            'path_id' => 'required|integer|exists:paths,id',
            'location' => [
                'required',
                'regex:/^([0-8]?\d(\.\d+)?|90(\.0+)?)°([0-5]?\d)\'([0-5]?\d(\.\d+)?)"(N|S)\s(1[0-7]\d(\.\d+)?|0?\d{1,2}(\.0+)?|180(\.0+)?)°([0-5]?\d)\'([0-5]?\d(\.\d+)?)"(E|W)$/',
            ]
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
            'name' => 'اسم المحطة',
            'path_id' => 'اسم المسار',
        ];
    }

    //===========================================================================================================================

    public function messages(): array
    {
        return [
            'required' => ' :attribute مطلوب',
            'max' => 'الحد الأقصى لطول  :attribute هو 50 حرف',
            'min' => 'الحد الأدنى لطول :attribute على الأقل هو 4 حرف',
            'integer' => 'يجب أن يكون الحقل :attribute من نمط int',
            'exists' => 'يجب أن يكون :attribute موجودا مسبقا',
        ];
    }
}
