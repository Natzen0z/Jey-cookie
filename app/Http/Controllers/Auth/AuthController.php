<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Check if admin login was requested
            if ($request->boolean('admin_login') && !Auth::user()->isAdmin()) {
                Auth::logout();
                return back()
                    ->withInput($request->only('email'))
                    ->with('error', 'Anda tidak memiliki akses admin.');
            }

            // Redirect admin to dashboard
            if (Auth::user()->isAdmin() && $request->boolean('admin_login')) {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang, Admin!');
            }

            return redirect()->intended(route('home'))
                ->with('success', 'Selamat datang, ' . Auth::user()->name . '!');
        }

        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Email atau password salah.');
    }

    /**
     * Show the registration form.
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        
        return view('auth.register');
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'is_admin' => false,
        ]);

        Auth::login($user);

        return redirect()->route('home')
            ->with('success', 'Selamat datang di Jeycookie, ' . $user->name . '!');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Anda telah berhasil logout.');
    }

    /**
     * Handle password-confirmed logout (for admin).
     */
    public function confirmLogout(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ], [
            'password.required' => 'Password wajib diisi.',
        ]);

        // Verify password matches current user
        if (!Hash::check($request->password, Auth::user()->password)) {
            return back()->with('error', 'Password yang Anda masukkan salah.');
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Anda telah berhasil logout.');
    }
}

