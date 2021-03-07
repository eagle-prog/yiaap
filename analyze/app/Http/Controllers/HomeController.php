<?php

namespace App\Http\Controllers;

use App\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // If the user is logged-in, redirect to dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        // If there's a custom site index
        if (config('settings.index')) {
            return redirect()->to(config('settings.index'), 301);
        }

        if (config('settings.stripe')) {
            $plans = Plan::where('visibility', 1)->get();
        } else {
            $plans = null;
        }

        return view('home.content', ['plans' => $plans]);
    }
}
