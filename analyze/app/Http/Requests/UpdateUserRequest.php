<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (request()->route('id') && Auth::user()->role == 0) {
            return false;
        }

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.(request()->route('id') ?? Auth::user()->id)],
            'role'  => ['sometimes', 'integer', 'between:0,1'],
            'email_verified_at' => ['nullable', 'integer', 'between:0,1'],
            'email_account_limit' => ['nullable', 'integer'],
            'password'  => ['nullable', 'string', 'min:6'],
            'timezone' => ['required']
        ];
    }
}
