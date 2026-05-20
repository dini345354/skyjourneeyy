<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('product.category')
            ->where('user_id', Auth::id())
            ->get();

        $total = $carts->sum(function($cart) {
            return $cart->jumlah * $cart->product->harga;
        });

        return view('user.cart', compact('carts', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1|max:' . $product->stok_kursi,
        ], [
            'jumlah.required' => 'Jumlah tiket wajib diisi.',
            'jumlah.min'      => 'Minimal 1 tiket.',
            'jumlah.max'      => 'Melebihi stok tersedia (' . $product->stok_kursi . ').',
        ]);

        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            $newJumlah = $cart->jumlah + $request->jumlah;
            if ($newJumlah > $product->stok_kursi) {
                return back()->with('error', 'Total melebihi stok tersedia.');
            }
            $cart->update(['jumlah' => $newJumlah]);
        } else {
            Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => $product->id,
                'jumlah'     => $request->jumlah,
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Tiket berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'jumlah' => 'required|integer|min:1|max:' . $cart->product->stok_kursi,
        ]);

        $cart->update(['jumlah' => $request->jumlah]);

        return back()->with('success', 'Keranjang berhasil diperbarui!');
    }

    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->delete();
        return back()->with('success', 'Tiket berhasil dihapus dari keranjang!');
    }
}
