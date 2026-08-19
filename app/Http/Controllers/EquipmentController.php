<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Equipment;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::where('user_id', auth()->id())->get();

        return view('equipments.index', compact('equipments'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('equipments.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $photo = null;

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('equipments', 'public');
        }

        Equipment::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price_per_hour' => $request->price_per_hour,
            'photo' => $photo,
            'stock_status' => 'available',
        ]);

        return redirect()->route('equipments.index');
    }

    public function edit(Equipment $equipment)
{
    if ($equipment->user_id != auth()->id()) {
        abort(403);
    }

    $categories = Category::all();

    return view('equipments.edit', compact('equipment', 'categories'));
}

public function update(Request $request, Equipment $equipment)
{
    if ($equipment->user_id != auth()->id()) {
        abort(403);
    }

    $photo = $equipment->photo;

    if ($request->hasFile('photo')) {
        $photo = $request->file('photo')->store('equipments', 'public');
    }

    $equipment->update([
        'category_id' => $request->category_id,
        'name' => $request->name,
        'description' => $request->description,
        'price_per_hour' => $request->price_per_hour,
        'stock_status' => $request->stock_status,
        'photo' => $photo,
    ]);

    return redirect()
        ->route('equipments.index')
        ->with('success', 'Data alat berhasil diperbarui.');
}

    public function showPublic(Equipment $equipment)
{
    $equipment->load('user.verification', 'category');

    return view('catalog-detail', compact('equipment'));
}
}