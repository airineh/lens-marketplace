<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlatformSetting;


class PlatformSettingController extends Controller
{
    public function index()
    {
        $setting = PlatformSetting::first();

        return view('admin.platform-settings', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'commission_percentage' => 'required|numeric|min:0|max:100',
            'bank_name' => 'required',
            'bank_account_number' => 'required',
            'bank_account_name' => 'required',
        ]);

        $setting = PlatformSetting::first();

        $setting->update([
            'commission_percentage' => $request->commission_percentage,
            'bank_name' => $request->bank_name,
            'bank_account_number' => $request->bank_account_number,
            'bank_account_name' => $request->bank_account_name,
        ]);

        return back()->with('success', 'Pengaturan platform berhasil diperbarui.');
    }
}