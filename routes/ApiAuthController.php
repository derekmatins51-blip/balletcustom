<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Controller;
use App\Mail\WelcomeEmail;
use App\Models\CryptoAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ApiAuthController extends Controller
{
    use PasswordValidationRules;

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'middlename' => ['nullable', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:255'],
            'curr' => ['required', 'string', 'max:10'],
            's_curr' => ['nullable', 'string', 'max:10'],
            'accounttype' => ['required', 'string', 'max:255'],
            'pin' => ['required', 'string', 'size:4', 'regex:/^[0-9]+$/'],
            'password' => $this->passwordRules(),
            'terms' => ['accepted'],
            'phrase' => ['required', 'string', 'size:20', 'regex:/^[A-Za-z0-9]+$/'],
        ]);

        
        $user = User::create([
            'name' => $request['name'],
            'lastname' => $request['lastname'],
            'middlename' => $request['middlename'],
            'username' => $request['username'],
            'usernumber' => $this->RandomStringGenerator(11),
            'email' => $request['email'],
            'phone' => $request['phone'],
            'country' => $request['country'],
            'curr' => $request['curr'],
            's_curr' => $request['s_curr'],
            'accounttype' => $request['accounttype'],
            'pin' => $request['pin'],
            'password' => Hash::make($request['password']),
            'phrase' => $request['phrase'],
            // 'status' => 'active',
        ]);

        $cryptoaccnt = new CryptoAccount();
        $cryptoaccnt->user_id = $user->id;
        $cryptoaccnt->save();

        Mail::to($user->email)->send(new WelcomeEmail($user));

        return response()->json([
            'message' => 'Registration is successful.',
            'status_code' => 200,
        ]);
    }
}