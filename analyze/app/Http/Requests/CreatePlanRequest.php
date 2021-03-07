<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePlanRequest extends FormRequest
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
            'name' => ['required', 'max:64', 'unique:plans,name'],
            'description' => ['required'],
            'trial_days' => ['required', 'integer'],
            'currency' => ['required'],
            'amount_month' => ['required', 'integer', 'min:1'],
            'amount_year' => ['required', 'integer', 'min:1'],
            'visibility' => ['integer', 'between:0,1'],
            'option_pageviews' => ['required', 'integer']
        ];
    }
}
