<?php

namespace App\Http\Requests\API;

use App\Http\Requests\CreateWebsiteRequest as BaseCreateWebsiteRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CreateWebsiteRequest extends BaseCreateWebsiteRequest
{
    /**
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => $validator->errors(),
                'status' => 422
            ], 422));
    }
}

