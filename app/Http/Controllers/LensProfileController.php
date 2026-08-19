<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Verification;

class LensProfileController extends Controller
{
    public function index()
    {
        return view('profile.my-profile');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $profilePhoto = $user->profile_photo;

        if ($request->hasFile('profile_photo')) {
            $profilePhoto = $request->file('profile_photo')
                ->store('profiles', 'public');
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'portfolio_link' => $request->portfolio_link,
            'profile_photo' => $profilePhoto,
            'bank_name' => $request->bank_name,
            'bank_account_number' => $request->bank_account_number,
            'bank_account_name' => $request->bank_account_name,
        ]);

        $verification = Verification::where('user_id', $user->id)->first();

        $simPhoto = $verification->sim_photo ?? null;
        $selfiePhoto = $verification->selfie_photo ?? null;

        if ($request->hasFile('sim_photo')) {
            $simPhoto = $request->file('sim_photo')
                ->store('verifications', 'public');
        }

        if ($request->hasFile('selfie_photo')) {
            $selfiePhoto = $request->file('selfie_photo')
                ->store('verifications', 'public');
        }

        if ($request->hasFile('sim_photo') || $request->hasFile('selfie_photo') || $request->portfolio_link) {
            Verification::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'sim_photo' => $simPhoto,
                    'selfie_photo' => $selfiePhoto,
                    'portfolio_link' => $request->portfolio_link,
                    'status' => 'pending',
                ]
            );

            $user->update([
                'verification_status' => 'unverified',
            ]);
        }

        return redirect()
            ->route('my.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}