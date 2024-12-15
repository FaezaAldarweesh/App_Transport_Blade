<?php

namespace App\Http\Requests\Driver_Request;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class Update_Driver_Request extends FormRequest
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
        $driver_id = $this->route(param: 'driver');

        return [
            'name' => ['sometimes','nullable','string','min:4','max:50',Rule::unique('drivers', 'name')->ignore($driver_id)],
            'phone' => ['sometimes','nullable','min:10','max:10','regex:/^([0-9\s\-\+\(\)]*)$/',Rule::unique('drivers', 'phone')->ignore($driver_id)],
            'location' => 'sometimes|nullable|string|min:5',
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
            'name' => 'اسم السائق',
            'phone' => 'رقم الهاتف',
            'location' => 'الموقع',
        ];
    }
    //===========================================================================================================================

    public function messages(): array
    {
        return [
            'name.max' => 'الحد الأقصى لطول  :attribute هو 50 حرف',
            'name.min' => 'الحد الأدنى لطول :attribute على الأقل هو 4 حرف',
            'phone.max' => 'الحد الأقصى لطول  :attribute هو 10 حرف',
            'phone.min' => 'الحد الأدنى لطول :attribute على الأقل هو 10 حرف',
            'regex' => 'يجب أن يحوي  :attribute على أرقام فقط',
            'unique' => ':attribute  موجود سابقاً , يجب أن يكون :attribute غير مكرر',
            'location.min' => 'الحد الأدنى لطول :attribute على الأقل هو 5 حرف',
        ];
    }
}
