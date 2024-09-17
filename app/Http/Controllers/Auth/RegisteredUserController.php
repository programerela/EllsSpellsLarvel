<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'username' => 'required',
            'dob' => 'required',
            'country' => 'required',
            'avatar' => 'required|image|mimes:jpg,png',
            'JMBG' => 'required',
            'gender' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed',
        ]);

        $response = cloudinary()->upload($request->file('avatar')->getRealPath(), [
            'verify' => false
        ])->getSecurePath();

        $user = User::create($request->only(
            'name',
            'phone',
            'username',
            'dob',
            'country',
            'JMBG',
            'email',
            'gender'
        ) + [
            'password' => bcrypt($request->password),
            'avatar' => $response
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    public function register_form()
    {
        return view('auth.register');
    }

    public function register_moderator_form()
    {
        return view('auth.register-moderator');
    }

    public function register_moderator(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'username' => 'required',
            'dob' => 'required',
            'country' => 'required',
            'avatar' => 'required|image|mimes:jpg,png',
            'JMBG' => 'required',
            'gender' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed',
        ]);

        $response = cloudinary()->upload($request->file('avatar')->getRealPath(), [
            'verify' => false
        ])->getSecurePath();

        $user = User::create($request->only(
            'name',
            'phone',
            'username',
            'dob',
            'country',
            'JMBG',
            'email',
            'gender'
        ) + [
            'password' => bcrypt($request->password),
            'role' => 'MODERATOR', 
            'avatar' => $response,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
