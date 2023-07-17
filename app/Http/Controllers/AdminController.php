<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules;
use App\Http\Requests\AdminProfileUpdateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    
    public function index(){
        return view('admin.auth.login');
    }

    public function store(Request $request){
        // dd($request->all());
        $check = $request->all();
        if(Auth::guard('admin')->attempt([
            'email' => $check['email'],
            'password' => $check['password']])){
            return redirect()->route('programs.index')->with('status', 'Admin Login Successfully');
        }else{
            return back()->with('status', 'Invalid Email or Password');
        }
    }


    public function AdminLogout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('status', 'Admin Logout Successfully');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('admin.profiles.edit', [
            'admin' => $request->user('admin'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(AdminProfileUpdateRequest $request): RedirectResponse
    {
        $admin = $request->user('admin');
        $admin->fill($request->validated());

        if ($admin->isDirty('email')) {
            $admin->email_verified_at = null;
        }

        $admin->save();

        return redirect()->route('admin.profile.edit')->with('status', 'Profile updated successfully');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
        ]);

        $user = $request->user('admin');

        // Verify the current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'Profile updated successfully');
}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('adminDeletion', [
            'password' => ['required', 'current_password:admin'],
        ]);

        $admin = $request->user('admin');

        Auth::guard('admin')->logout();

        $admin->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->to('/');
    }

    public function newAdmin(){
        $admin = Admin::all();
        return view('admin.newAdmin.index', compact('admin'));
    }

    public function substitute(Request $request, Admin $admin)
    {
        // Check if the current admin is authorized to perform the substitute action
        if (Auth::guard('admin')->user()->id === $admin->id) {
            return back()->with('status', 'You cannot substitute your own account.');
        }

        // Add your substitute logic here
        // For example, you can log in as the selected admin
        Auth::guard('admin')->login($admin);

        return redirect()->back()->with('status', 'Substituted as ' . $admin->name);
    }

    public function storeAdmin(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.Admin::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($admin));

        return redirect()->back()->with('status', 'Admin Successfully Created');
    }

}