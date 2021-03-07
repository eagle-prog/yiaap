<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccountResource;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{

    /**
     * Display the resource.
     *
     * @return AccountResource|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = Auth::user();

        if ($user) {
            return AccountResource::make($user);
        }

        return response()->json([
            'message' => 'Resource not found.',
            'status' => 404
        ], 404);
    }
}
