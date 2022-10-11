<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordChangeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "current_password" => "required",
            "new_password" => "required|same:current_password"
        ];
    }

    public function messages() {
        return [
            "current_password.required" => "შეიყვანეთ მიმდინარე პაროლი",
            "new_password.required" => "შეიყვანეთ ახალი პაროლი",
            "new_password.same" => "პაროლები არ ემთხვევა ერთმანეთს"
        ];
    }
}
