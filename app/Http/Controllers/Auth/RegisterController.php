<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Driver;
use App\Models\Manager;
use App\Models\Student;
use App\Models\Region;
use Illuminate\Http\Request;


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

    // use RegistersUsers;

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
    public function showRegistrationForm()
    {
        //return view('auth.register');
        $regions = Region::all();
        return view('auth.register', compact('regions'));
    }
    public function register(\Illuminate\Http\Request $request)
    {
        // 1. Validate Data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
               'confirmed',
            \Illuminate\Validation\Rules\Password::min(8)
                  ->mixedCase()
                  ->numbers()
                 ->symbols()],
            'region_id' => 'required|exists:regions,id',
            'phone_number' => ['required', 'regex:/^(079|078|077)[0-9]{7}$/'],
            'student_number' => 'required|string|max:9',
        ]);

        // 2. Create User
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'phone_number' => $validated['phone_number'],
            'region_id' => $validated['region_id'],
        ]);

        // 3. Create Student Profile
        Student::create([
            'user_id' => $user->id,
            'student_number' => $validated['student_number'],
        ]);

        // 4. Assign Role
        $user->addRole('student');

        // 5. Login
      //\Illuminate\Support\Facades\Auth::login($user);
        return redirect()->route('login');

       // return redirect()->route('student.dashboard');
    }
}
