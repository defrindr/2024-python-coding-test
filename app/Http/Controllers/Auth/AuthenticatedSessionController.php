<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('pages.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->first());
            return redirect()->back()->withInput();
        }

        $request->authenticate();

        $request->session()->regenerate();

        if ($request->user()->role == 'super_admin') {
            $url = '/super-admin/dashboard';
        } else if ($request->user()->role == 'admin') {
            if ($request->user()->admin->approved == 1) {
                $url = '/admin/dashboard';
            } else {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                Alert::toast('Admin belum disetujui!', 'error');
                return redirect()->route('login');
            }
        } else if ($request->user()->role == 'guru') {
            $url = '/guru/dashboard';
        } else {
            $url = '/siswa/dashboard';
        }
        Alert::toast('Selamat datang, ' . $request->user()->name . '!', 'success');
        return redirect()->intended($url);
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