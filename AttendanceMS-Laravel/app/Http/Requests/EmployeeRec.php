<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRec extends FormRequest
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
     * @return array
     */
    public function rules()
{
    return [
        'name' => 'required|string|min:3|max:64|alpha_dash',  // Validates name: no spaces, can contain hyphens/underscores
        'position' => 'required|string|min:3|max:64|alpha_dash',  // Validates position: no spaces, can contain hyphens/underscores
        'email' => 'nullable|email|unique:employees,email',  // Email validation (optional, unique if provided)
        'pin_code' => 'nullable|string|min:6|max:8',  // Pin code validation (optional, 6-8 characters)
        'schedule' => 'required|exists:schedules,slug',  // Validates that schedule exists in the schedules table
    ];
}

}
