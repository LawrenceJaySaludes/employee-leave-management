<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
 public function rules(): array
{
    $employeeId = $this->route('employee');

    return [
        'name' => ['required', 'string', 'max:255'],
        'email' => [
            'required',
            'email',
            Rule::unique('users', 'email')->ignore($employeeId),
        ],
        'department' => ['required', 'string', 'max:255'],
    ];
}
}
