<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'agreement' => ['required'],
            'g-recaptcha-response' => [(config('settings.captcha_registration') ? 'required' : 'sometimes'), 'captcha']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // If registration is enabled
        if (config('settings.registration_registration')) {
            $user = new User;

            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->locale = App::getLocale();
            $user->timezone = config('settings.timezone');
            $user->email_account_limit = 1;
            $user->api_token = Str::random(60);

            $user->save();

            if (!config('settings.registration_verification')) {
                $user->markEmailAsVerified();
            }

            return $user;
        }
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(Request $request)
    {
        // If the request comes from the Home or Pricing page, and the user has selected a plan
        if (($request->server('HTTP_REFERER') == route('pricing') || $request->server('HTTP_REFERER') == route('home').'/') && $request->input('plan') > 1 && in_array($request->input('period'), ['monthly', 'yearly'])) {
            session(['selected_plan' => ['id' => $request->input('plan'), 'period' => $request->input('period')]]);
        }

        // If registration is enabled
        if (config('settings.registration_registration')) {
            return view('auth.register');
        }

        abort(404);
    }
}
