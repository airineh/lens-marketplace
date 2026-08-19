<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Verification;

class VerificationController extends Controller
{
    public function index()
    {
         $verification = Verification::where('user_id', auth()->id())->first();

    return view('verification.index', compact('verification'));
    }

   public function store(Request $request)
{
    $request->validate([
        'sim_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'selfie_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'portfolio_link' => 'required|string',
    ]);

    $simPhoto = $request->file('sim_photo')->store('verifications', 'public');

    $selfiePhoto = null;
    if ($request->hasFile('selfie_photo')) {
        $selfiePhoto = $request->file('selfie_photo')->store('verifications', 'public');
    }

    Verification::updateOrCreate(
        ['user_id' => auth()->id()],
        [
            'sim_photo' => $simPhoto,
            'selfie_photo' => $selfiePhoto,
            'portfolio_link' => $request->portfolio_link,
            'status' => 'pending',
        ]
    );

    return redirect()
        ->route('verification')
        ->with('success', 'Verifikasi berhasil dikirim');
}
}