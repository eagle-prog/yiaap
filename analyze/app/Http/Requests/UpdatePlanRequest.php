<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanRequest extends FormRequest
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
            'name' => ['unique:plans,name,'.request()->route('id')],
            'description' => ['required'],
            'trial_days' => ['sometimes', 'integer'],
            'visibility' => ['sometimes', 'integer', 'between:0,1'],
            'option_pageviews' => ['required', 'integer']
        ];
    }
}
