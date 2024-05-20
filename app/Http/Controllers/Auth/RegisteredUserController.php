<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $dataSekolah = Sekolah::all();
        $dataKelas = Kelas::all();
        return view('pages.auth.register', compact('dataSekolah', 'dataKelas'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->password != $request->password_confirmation) {
            Alert::error('Error', 'Password confirmation does not match!');
            return redirect()->back()->withInput();
        }
        if ($request->role == 'admin') {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'sekolah' => ['required'],
            ]);
        } elseif ($request->role == 'guru') {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'sekolah_id' => ['required'],
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'sekolah_id' => ['required'],
                'kelas_id' => ['required'],
                'nis' => ['required'],
            ]);
        }

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->first());
            return redirect()->back()->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        if ($request->role == 'guru') {
            $user->assignRole('guru');
            $user->guru()->create([
                'sekolah_id' => $request->sekolah_id,
            ]);
        } elseif ($request->role == 'admin') {
            $user->assignRole('admin');
            Sekolah::create([
                'nama' => $request->sekolah,
            ]);
            $user->admin()->create([
                'sekolah_id' => Sekolah::latest()->first()->id,
            ]);
        } else {
            $user->assignRole('siswa');
            $user->siswa()->create([
                'sekolah_id' => $request->sekolah_id,
                'kelas_id' => $request->kelas_id,
                'nis' => $request->nis,
            ]);
        }

        event(new Registered($user));
        Alert::success('Success', 'Registrasi berhasil! Silahkan login untuk melanjutkan.');
        auth()->logout(); // Logout the user
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silahkan login untuk melanjutkan.');
    }
}