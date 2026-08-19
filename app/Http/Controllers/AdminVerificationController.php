<?php

namespace App\Http\Controllers;

use App\Models\Verification;

class AdminVerificationController extends Controller
{
    public function index()
    {
        $verifications = Verification::with('user')->latest()->get();

        return view('admin.verifications.index', compact('verifications'));
    }

    public function approve($id)
    {
        $verification = Verification::findOrFail($id);

        $verification->update([
            'status' => 'approved'
        ]);

        $verification->user->update([
            'verification_status' => 'verified'
        ]);

        return redirect()
            ->route('admin.verifications')
            ->with('success', 'Verifikasi user berhasil disetujui.');
    }

    public function reject($id)
    {
        $verification = Verification::findOrFail($id);

        $verification->update([
            'status' => 'rejected'
        ]);

        $verification->user->update([
            'verification_status' => 'unverified'
        ]);

        return redirect()
            ->route('admin.verifications')
            ->with('success', 'Verifikasi user berhasil ditolak.');
    }
}