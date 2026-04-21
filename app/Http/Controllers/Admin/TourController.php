<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Tour;

class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::latest()->get();
        return view('admin.tours.index', compact('tours'));
    }

    public function create()
    {
        return view('admin.tours.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'destination' => 'required|string',
            'price' => 'required|numeric',
            'duration' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['slug'] = \Illuminate\Support\Str::slug($request->title) . '-' . rand(100, 999);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('tours', 'public');
        }

        if ($request->hasFile('gallery')) {
            $gallery = [];
            foreach ($request->file('gallery') as $file) {
                $gallery[] = $file->store('tours/gallery', 'public');
            }
            $data['images'] = $gallery;
        }

        Tour::create($data);

        return redirect()->route('admin.tours.index')->with('success', 'Paket Tour berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $tour = Tour::findOrFail($id);
        return view('admin.tours.edit', compact('tour'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'destination' => 'required|string',
            'price' => 'required|numeric',
            'duration' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
        ]);

        $tour = Tour::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($tour->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($tour->image);
            }
            $data['image'] = $request->file('image')->store('tours', 'public');
        }

        // Gallery Images (Multiple) - APPEND to existing
        if ($request->hasFile('gallery')) {
            $galleryPaths = $tour->images ?? [];
            foreach ($request->file('gallery') as $file) {
                $galleryPaths[] = $file->store('tours/gallery', 'public');
            }
            $data['images'] = $galleryPaths;
        }

        $tour->update($data);

        return redirect()->route('admin.tours.index')->with('success', 'Paket Tour berhasil diperbarui!');
    }

    public function destroy(Tour $tour)
    {
        // Delete main image
        if ($tour->image) {
            Storage::disk('public')->delete($tour->image);
        }

        // Delete gallery images
        if ($tour->images) {
            foreach ($tour->images as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        $tour->delete();

        return redirect()->route('admin.tours.index')->with('success', 'Paket tour berhasil dihapus');
    }

    public function deleteImage(Request $request, Tour $tour)
    {
        $imagePath = $request->image_path;
        
        // Remove from storage
        Storage::disk('public')->delete($imagePath);

        // Update database array
        $images = $tour->images;
        if (($key = array_search($imagePath, $images)) !== false) {
            unset($images[$key]);
        }
        
        $tour->update([
            'images' => array_values($images) // Re-index array
        ]);

        return back()->with('success', 'Foto galeri berhasil dihapus');
    }

    public function deleteMainImage(Tour $tour)
    {
        // Remove from storage
        if ($tour->image) {
            Storage::disk('public')->delete($tour->image);
        }

        // Update database
        $tour->update([
            'image' => null
        ]);

        return back()->with('success', 'Foto utama berhasil dihapus');
    }
}
