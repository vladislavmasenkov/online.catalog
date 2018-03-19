<?php

namespace App\Http\Requests\OnlineCatalog\Employees;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeValidator extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'reqired|max:255',
            'last_name' => 'required|max:255',
            'middle_name' => 'max:255',
            'avatar' => 'nullable|max:255',
            'position' => 'required|exists:positions,id',
            'employment_date' => 'date',
            'director' => 'nullable|exists:employees,id'
        ];
    }
}
