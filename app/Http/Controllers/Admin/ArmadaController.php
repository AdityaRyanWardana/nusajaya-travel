<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Armada;

class ArmadaController extends Controller
{
    public function index()
    {
        $armadas = Armada::latest()->get();
        return view('admin.armadas.index', compact('armadas'));
    }

    public function create()
    {
        return view('admin.armadas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'capacity' => 'required|integer',
            'price_per_day' => 'nullable|numeric',
            'price_city_tour' => 'nullable|numeric',
            'price_city_one_way' => 'required|numeric',
            'price_city_half_day' => 'required|numeric',
            'price_city_one_day' => 'required|numeric',
            'price_city_full_day' => 'required|numeric',
            'price_barelang' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
            'total_units' => 'required|integer|min:1',
        ]);

        $data = $request->all();
        $data['slug'] = \Illuminate\Support\Str::slug($request->name) . '-' . rand(100, 999);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('armadas', 'public');
        }

        if ($request->hasFile('gallery')) {
            $gallery = [];
            foreach ($request->file('gallery') as $file) {
                $gallery[] = $file->store('armadas/gallery', 'public');
            }
            $data['images'] = $gallery;
        }

        // Default values for old columns to avoid DB errors
        $data['price_per_day'] = 0;

        Armada::create($data);

        return redirect()->route('admin.armadas.index')->with('success', 'Armada berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $armada = Armada::findOrFail($id);
        return view('admin.armadas.edit', compact('armada'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'capacity' => 'required|integer',
            'price_per_day' => 'nullable|numeric',
            'price_city_tour' => 'nullable|numeric',
            'price_city_one_way' => 'required|numeric',
            'price_city_half_day' => 'required|numeric',
            'price_city_one_day' => 'required|numeric',
            'price_city_full_day' => 'required|numeric',
            'price_barelang' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
            'total_units' => 'required|integer|min:1',
        ]);

        $armada = Armada::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($armada->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($armada->image);
            }
            $data['image'] = $request->file('image')->store('armadas', 'public');
        }

        // Default values for old columns to avoid DB errors
        $data['price_per_day'] = 0;

        // Gallery Images (Multiple) - APPEND to existing
        if ($request->hasFile('gallery')) {
            $galleryPaths = $armada->images ?? [];
            foreach ($request->file('gallery') as $file) {
                $galleryPaths[] = $file->store('armadas/gallery', 'public');
            }
            $data['images'] = $galleryPaths;
        }

        $armada->update($data);

        return redirect()->route('admin.armadas.index')->with('success', 'Armada berhasil diperbarui!');
    }

    public function destroy(Armada $armada)
    {
        // Delete main image
        if ($armada->image) {
            Storage::disk('public')->delete($armada->image);
        }

        // Delete gallery images
        if ($armada->images) {
            foreach ($armada->images as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        $armada->delete();

        return redirect()->route('admin.armadas.index')->with('success', 'Armada berhasil dihapus');
    }

    public function deleteImage(Request $request, Armada $armada)
    {
        $imagePath = $request->image_path;
        
        // Remove from storage
        Storage::disk('public')->delete($imagePath);

        // Update database array
        $images = $armada->images;
        if (($key = array_search($imagePath, $images)) !== false) {
            unset($images[$key]);
        }
        
        $armada->update([
            'images' => array_values($images) // Re-index array
        ]);

        return back()->with('success', 'Foto galeri berhasil dihapus');
    }

    public function deleteMainImage(Armada $armada)
    {
        // Remove from storage
        if ($armada->image) {
            Storage::disk('public')->delete($armada->image);
        }

        // Update database
        $armada->update([
            'image' => null
        ]);

        return back()->with('success', 'Foto utama berhasil dihapus');
    }
}
