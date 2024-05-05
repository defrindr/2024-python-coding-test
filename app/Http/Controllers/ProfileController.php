<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('pages.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        if ($request->user()->role == 'guru') {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $request->user()->id,
                'nip' => 'required|unique:guru,nip,' . $request->user()->guru->id,
                'alamat' => 'required',
            ]);

            if ($validator->fails()) {
                Alert::toast($validator->errors()->first(), 'error');
                return redirect()->back()->withInput();
            }

            $request->user()->guru->update([
                'nip' => $request->nip,
                'alamat' => $request->alamat,
            ]);
        } elseif ($request->user()->role == 'siswa') {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $request->user()->id,
                'nis' => 'required|unique:siswa,nis,' . $request->user()->siswa->id,
                'kelas' => 'required',
                'alamat' => 'required',
            ]);

            if ($validator->fails()) {
                Alert::toast($validator->errors()->first(), 'error');
                return redirect()->back()->withInput();
            }

            $request->user()->siswa->update([
                'nis' => $request->nis,
                'kelas' => $request->kelas,
                'alamat' => $request->alamat,
            ]);
        }
        $request->user()->save();
        Alert::toast('Profile updated!', 'success');
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updateSekolah(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_sekolah' => 'required|unique:sekolah,nama,' . $request->user()->admin->sekolah->id,
            'alamat' => 'required',
            'npsn' => 'required|unique:sekolah,npsn,' . $request->user()->admin->sekolah->id,
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return redirect()->back()->withInput();
        }

        $request->user()->admin->sekolah->update([
            'nama' => $request->nama_sekolah,
            'alamat' => $request->alamat,
            'npsn' => $request->npsn,
        ]);

        Alert::toast('Data Sekolah updated!', 'success');
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}