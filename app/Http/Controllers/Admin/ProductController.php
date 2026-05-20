<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tiket'            => 'required|string|max:255',
            'category_id'           => 'required|exists:categories,id',
            'maskapai'              => 'required|string|max:255',
            'asal'                  => 'required|string|max:255',
            'tujuan'                => 'required|string|max:255',
            'tanggal_keberangkatan' => 'required|date|after:today',
            'harga'                 => 'required|numeric|min:0',
            'stok_kursi'            => 'required|integer|min:0',
            'deskripsi'             => 'nullable|string',
            'gambar'                => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'nama_tiket.required'            => 'Nama tiket wajib diisi.',
            'category_id.required'           => 'Kategori wajib dipilih.',
            'maskapai.required'              => 'Maskapai wajib diisi.',
            'asal.required'                  => 'Kota asal wajib diisi.',
            'tujuan.required'                => 'Kota tujuan wajib diisi.',
            'tanggal_keberangkatan.required' => 'Tanggal keberangkatan wajib diisi.',
            'tanggal_keberangkatan.after'    => 'Tanggal harus lebih dari hari ini.',
            'harga.required'                 => 'Harga wajib diisi.',
            'stok_kursi.required'            => 'Stok kursi wajib diisi.',
            'gambar.image'                   => 'File harus berupa gambar.',
            'gambar.max'                     => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Tiket berhasil ditambahkan!');
    }

    public function show(Product $product)
    {
        $product->load('category', 'orderItems.order');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nama_tiket'            => 'required|string|max:255',
            'category_id'           => 'required|exists:categories,id',
            'maskapai'              => 'required|string|max:255',
            'asal'                  => 'required|string|max:255',
            'tujuan'                => 'required|string|max:255',
            'tanggal_keberangkatan' => 'required|date',
            'harga'                 => 'required|numeric|min:0',
            'stok_kursi'            => 'required|integer|min:0',
            'deskripsi'             => 'nullable|string',
            'gambar'                => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Tiket berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Tiket berhasil dihapus!');
    }
}
