<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function register(Request $request) {
        // Enhanced validation with custom messages
        $request->validate([
            'name' => 'required|min:3|max:50|regex:/^[a-zA-Z\s]+$/',
            'phone' => 'required|regex:/^[0-9+\-\s()]+$/|min:10|max:15',
            'username' => [
                'required', 
                'min:3', 
                'max:20',
                'regex:/^[A-Za-z0-9_.-]+$/',
                Rule::unique('pengguna', 'username')
            ],
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/',
        ], [
            'name.required' => 'Name is required.',
            'name.min' => 'Name must be at least 3 characters.',
            'name.max' => 'Name cannot exceed 50 characters.',
            'name.regex' => 'Name can only contain letters and spaces.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Invalid phone number format.',
            'phone.min' => 'Phone number must be at least 10 digits.',
            'phone.max' => 'Phone number cannot exceed 15 digits.',
            'username.required' => 'Username is required.',
            'username.min' => 'Username must be at least 3 characters.',
            'username.max' => 'Username cannot exceed 20 characters.',
            'username.regex' => 'Username can only contain letters, numbers, dots, underscores, and hyphens.',
            'username.unique' => 'Username is already taken.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must contain uppercase, lowercase, and numbers.',
        ]);

        try {
            // Check if phone number already exists
            $existingPhone = Pengguna::where('no_hp', $request->phone)->first();
            if ($existingPhone) {
                return back()->withErrors(['phone' => 'Phone number is already registered.'])->withInput();
            }

            // Create user
            $pengguna = Pengguna::create([
                'nama' => $request->name,
                'username' => $request->username,
                'no_hp' => $request->phone,
                'password' => Hash::make($request->password),
                'peran' => 'cust',
            ]);

            // Redirect to login page with success message
            return redirect('/login')->with('success', 'Account created successfully! Please login with your credentials.');

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Registration error: ' . $e->getMessage());
            
            return back()->withErrors(['general' => 'An error occurred while creating your account. Please try again.'])->withInput();
        }
    }
}