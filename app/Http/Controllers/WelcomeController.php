<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Guest;
use App\Models\State;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class WelcomeController extends Controller
{
    /**
     * Display the login view.
     */
    public function index()
    {
        return view('welcome');
    }

    public function daftar()
    {
        $states = State::all(); // Assuming you have a State model

        return view('auth.register', compact('states'));
    }

    public function guest()
    {
        $programs = Program::where('status', 1)->get();
        $states = State::all();
        return view('guest', compact('programs','states'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', Rules\Password::defaults()],
            'ic' => ['required', 'numeric', 'digits_between:1,12', 'unique:' . User::class],
            'gender' => ['required', 'string', 'in:male,female'],
            'state' => ['required'], // Add the state validation rule
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->ic = $request->ic;
        $user->gender = $request->gender;
        $user->state = $request->state; // Assign the state ID
        $user->password = Hash::make($request->password);
        // Assign values for other user fields
        $user->save();

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME)->with('status', 'Account Registered!');
    }


    public function guestRegister(Request $request): RedirectResponse
    {
        $request->validate([
            'program_id' => ['required', 'exists:' . Program::class . ',id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:15'],
        ]);

        // Check if a guest with the same email already registered for the specified program
        $existingGuest = Guest::where('email', $request->email)
                            ->where('program_id', $request->program_id)
                            ->first();

        if ($existingGuest) {
            return redirect()->back()->with('status', 'Pengguna dengan E-mel ini sudah berdaftar');
        }

        // Create a new guest entry
        $guest = new Guest;
        $guest->program_id = $request->program_id;
        $guest->name = $request->name;
        $guest->email = $request->input('email');
        $guest->phone = $request->phone;
        $guest->gender = $request->gender;
        $guest->state = $request->state; // Assign the state ID
        $guest->joined = now(); // Assign the current date and time to the joined field
        // Assign values for other guest fields
        $guest->save();

        return redirect()->back()->with('status', 'Program Berjaya Didaftarkan');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}