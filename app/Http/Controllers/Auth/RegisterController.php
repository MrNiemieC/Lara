<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/home';

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
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
            'name.required' => 'Nazwa jest wymagana do utworzenia użytkownika',
            'name.string' => 'Nazwa powinna być tekstem',
            'name.max' => 'Nazwa przekracza limit znaków',
            'email.required' => 'Email jest wymagany do utworzenia użytkownika',
            'email.string' => 'Email powinien być tekstem',
            'email.email' => 'Email nie posiada poprawnego formatu mailowego',
            'email.unique' => 'Email jest już w użyciu',
            'email.max' => 'Email przekracza limit znaków',
            'password.required' => 'Hasło jest wymagane do utworzenia użytkownika',
            'password.string' => 'Hasło powinno być tekstem',
            'password.min' => 'Hasło jest zbyt krótkie wymagane 8 znaków',
            'password.confirmed' => 'Oba hasła powinny być takie same',
        ];
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
