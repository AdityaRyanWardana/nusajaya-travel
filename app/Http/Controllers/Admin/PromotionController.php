<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::with('tour')->latest()->get();
        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        $tours = Tour::orderBy('title')->get();
        return view('admin.promotions.create', compact('tours'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'badge' => 'nullable|string|max:50',
            'type' => 'required|in:tour,transport,general',
            'link' => 'nullable|string|max:255',
            'link_text' => 'nullable|string|max:50',
            'expires_at' => 'nullable|date',
            'is_active' => 'boolean',
            'tour_id' => 'nullable|exists:tours,id',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('promotions', 'public');
        }

        Promotion::create($data);

        return redirect()->route('admin.promotions.index')->with('success', 'Promosi berhasil ditambahkan!');
    }

    public function edit(Promotion $promotion)
    {
        $tours = Tour::orderBy('title')->get();
        return view('admin.promotions.edit', compact('promotion', 'tours'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'badge' => 'nullable|string|max:50',
            'type' => 'required|in:tour,transport,general',
            'link' => 'nullable|string|max:255',
            'link_text' => 'nullable|string|max:50',
            'expires_at' => 'nullable|date',
            'is_active' => 'boolean',
            'tour_id' => 'nullable|exists:tours,id',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($promotion->image) {
                Storage::disk('public')->delete($promotion->image);
            }
            $data['image'] = $request->file('image')->store('promotions', 'public');
        }

        $promotion->update($data);

        return redirect()->route('admin.promotions.index')->with('success', 'Promosi berhasil diperbarui!');
    }

    public function destroy(Promotion $promotion)
    {
        if ($promotion->image) {
            Storage::disk('public')->delete($promotion->image);
        }
        $promotion->delete();

        return redirect()->route('admin.promotions.index')->with('success', 'Promosi berhasil dihapus!');
    }
}
