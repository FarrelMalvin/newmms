<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\PenggunaAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminResetPasswordController extends Controller
{
    public function showResetForm()
    {
        return view('admin-reset-password');
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin_username' => 'required|string|max:50',
            'new_password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/',
            'confirm_password' => 'required|same:new_password',
        ], [
            'admin_username.required' => 'Admin username is required.',
            'admin_username.string' => 'Admin username must be a string.',
            'admin_username.max' => 'Admin username cannot exceed 50 characters.',
            'new_password.required' => 'New password is required.',
            'new_password.min' => 'New password must be at least 8 characters.',
            'new_password.regex' => 'New password must contain uppercase, lowercase, and numbers.',
            'confirm_password.required' => 'Password confirmation is required.',
            'confirm_password.same' => 'Password confirmation does not match.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Find admin user
            $admin = Pengguna::where('username', $request->admin_username)
                           ->where('peran', 'admin')
                           ->first();

            if (!$admin) {
                return back()->withErrors(['admin_username' => 'Admin username not found.'])->withInput();
            }

            // Check if admin has admin details
            $adminDetail = PenggunaAdmin::where('id_pengguna', $admin->id_pengguna)->first();
            if (!$adminDetail) {
                return back()->withErrors(['admin_username' => 'Admin details not found.'])->withInput();
            }

            // Update password
            $admin->password = Hash::make($request->new_password);
            $admin->save();

            return redirect('/login')->with('success', 'Admin password has been reset successfully! Please login with the new password.');

        } catch (\Exception $e) {
            \Log::error('Admin password reset error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'An error occurred while resetting the password. Please try again.'])->withInput();
        }
    }

    public function getAdminList()
    {
        try {
            $admins = Pengguna::where('peran', 'admin')
                             ->with('adminDetail.cabang')
                             ->get()
                             ->map(function ($admin) {
                                 return [
                                     'id' => $admin->id_pengguna,
                                     'username' => $admin->username,
                                     'nama' => $admin->nama,
                                     'cabang' => $admin->adminDetail->cabang->nama_cabang ?? 'No Branch Assigned',
                                     'no_hp' => $admin->no_hp
                                 ];
                             });

            return response()->json([
                'success' => true,
                'admins' => $admins
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching admin list: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching admin list.'
            ], 500);
        }
    }
} 