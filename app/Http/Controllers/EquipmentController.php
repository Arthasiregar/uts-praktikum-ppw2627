<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Equipment::with('category');

        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('asset_code', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        $equipments = $query->orderBy('id')->paginate(6)->appends(request()->query());
        $categories = Category::orderBy('name')->get();

        return view('equipments.index', compact('equipments', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('equipments.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_code' => 'required|max:20|unique:equipments,asset_code',
            'name' => 'required|min:5|max:150',
            'category_id' => 'required|exists:categories,id',
            'specification' => 'nullable|string',
            'condition' => 'nullable|in:baik,rusak_ringan,rusak_berat',
            'daily_rental_fee' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,webp|max:2048',
        ]);

        $file = $request->file('image');
        $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('equipments', $filename, 'public');

        Equipment::create([
            'category_id' => $validated['category_id'],
            'asset_code' => $validated['asset_code'],
            'name' => $validated['name'],
            'specification' => $validated['specification'] ?? null,
            'condition' => $validated['condition'] ?? 'baik',
            'status' => 'tersedia',
            'daily_rental_fee' => $validated['daily_rental_fee'],
            'image_path' => $path,
        ]);

        return redirect()->route('equipments.index')
            ->with('success', 'Aset baru berhasil ditambahkan.');
    }

    public function show($id)
    {
        $equipment = Equipment::with('category')->findOrFail($id);

        return view('equipments.show', compact('equipment'));
    }
}