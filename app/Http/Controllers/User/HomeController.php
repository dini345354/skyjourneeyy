<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('stok_kursi', '>', 0);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('nama_tiket', 'like', "%$s%")
                  ->orWhere('asal', 'like', "%$s%")
                  ->orWhere('tujuan', 'like', "%$s%")
                  ->orWhere('maskapai', 'like', "%$s%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('sort')) {
            match($request->sort) {
                'harga_asc'  => $query->orderBy('harga', 'asc'),
                'harga_desc' => $query->orderBy('harga', 'desc'),
                'terbaru'    => $query->latest(),
                default      => $query->latest(),
            };
        } else {
    $query->latest();
}
$products = $query->paginate(9);

        $products   = $query->paginate(9)->appends($request->query());
        $categories = Category::all();

        return view('user.home', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load('category');
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('stok_kursi', '>', 0)
            ->take(4)->get();

        return view('user.show', compact('product', 'relatedProducts'));
    }
}
