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
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'middle_name' => 'nullable|max:255',
            'avatar' => 'nullable|max:255',
            'position_id' => 'required|exists:positions,id|integer',
            'employment_date' => 'date',
            'wage' => 'required|integer',
            'director_id' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => \Lang::get('validation.firstNameIsRequiredField'),
            'last_name.required' => \Lang::get('validation.lastNameIsRequiredField'),
            'first_name.max' => \Lang::get('validation.firstNameMaxLengthField'),
            'last_name.max' => \Lang::get('validation.lastNameMaxLengthField'),
            'avatar.max' => \Lang::get('validation.avatarMaxLengthField'),
            'employment_date.date' => \Lang::get('validation.employmentDateMustBeDate'),
            'position_id.exists' => \Lang::get('validation.positionNotFoundInPositions'),
            'position_id.required' => \Lang::get('validation.positionIsRequiredField'),
            'wage.required' => \Lang::get('validation.wageIsRequiredField'),
            'wage.integer' => \Lang::get('validation.wageMustBeInteger')
        ];
    }

}
