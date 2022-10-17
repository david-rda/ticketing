<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "title" => "required",
            "description" => "required",
            "priority" => "required",
            "end_date" => "required"
        ];
    }

    public function messages() {
        return [
            "title.required" => "შეიყვანეთ სათაური",
            "description.required" => "შეიყვანეთ აღწერა",
            "priority.required" => "მიუთითეთ პრიორიტეტი",
            "required.required" => "მოითითეთ დასრულების ვადა"
        ];
    }
}
