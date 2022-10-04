<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddTaskRequest extends FormRequest
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
            "title" => "required|string",
            "description" => "required",
            "priority" => "required|numeric",
            "end_date" => "required"
        ];
    }

    public function messages() {
        return [
            "title.required" => "შეიყვანეთ დასახელება",
            "description.required" => "შეიყვანეთ აღწერა",
            "priority.required" => "მოიუთითეთ პრიორიტეტი",
            "end_date.required" => "მოითითეთ დასრულების თარიღი"
        ];
    }
}
