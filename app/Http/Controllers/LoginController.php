<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\PenggunaAdmin;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'regex:/^[A-Za-z0-9_.-]+$/'],
            'password' => 'required|string'
        ], [
            'username.required' => 'Username is required.',
            'username.regex' => 'Invalid username format.',
            'password.required' => 'Password is required.'
        ]);

        $user = Pengguna::where('username', $request->username)->first();

        if (!$user) {
            Log::info('Login failed: username not found', ['username' => $request->username]);
            return back()->withErrors(['username' => 'Invalid username or password'])->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            Log::info('Login failed: incorrect password', ['username' => $request->username]);
            return back()->withErrors(['username' => 'Invalid username or password'])->withInput();
        }

        Log::info('Login successful', ['username' => $user->username, 'peran' => $user->peran]);
        Auth::login($user); 
        $user = Pengguna::with('adminDetail')->find($user->id_pengguna); 
        
        if ($user->peran === 'cust') {
            return redirect('/');
        } elseif ($user->peran === 'admin') {
            $idCabang = $user->adminDetail?->id_cabang;
            Log::info('Login successful', ['id_cabang' => $idCabang]);
            Log::info('Admin detail:', [$user->adminDetail]);
            return redirect('/admin/dashboard');
        } else {
            Auth::logout();
            Log::info('Login failed: unrecognized role', ['username' => $user->username, 'peran' => $user->peran]);
            return back()->withErrors(['username' => 'Unrecognized user role'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // Log the logout
        Log::info('User logged out', [
            'user_id' => $user?->id_pengguna,
            'username' => $user?->username
        ]);
    
        // Return appropriate response
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Logout successful']);
        }
    
        return redirect('/login')->with('success', 'Logout successful');
    }

    public function showLoginForm()
    {
        return view('login');
    }
}