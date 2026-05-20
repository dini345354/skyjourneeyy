<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang Anda kosong. Silakan pilih tiket terlebih dahulu.');
        }

        $total = $carts->sum(fn($c) => $c->jumlah * $c->product->harga);
        $user  = Auth::user();

        return view('user.checkout', compact('carts', 'total', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pembeli' => 'required|string|max:255',
            'email'        => 'required|email',
            'no_hp'        => 'required|string|max:20',
            'alamat'       => 'required|string',
        ], [
            'nama_pembeli.required' => 'Nama pembeli wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'no_hp.required'        => 'Nomor HP wajib diisi.',
            'alamat.required'       => 'Alamat wajib diisi.',
        ]);

        $carts = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang kosong.');
        }

        // Validasi stok
        foreach ($carts as $cart) {
            if ($cart->jumlah > $cart->product->stok_kursi) {
                return back()->with('error', "Stok tiket '{$cart->product->nama_tiket}' tidak mencukupi.");
            }
        }

        $total = $carts->sum(fn($c) => $c->jumlah * $c->product->harga);

        DB::transaction(function() use ($request, $carts, $total) {
            $order = Order::create([
                'user_id'          => Auth::id(),
                'kode_pesanan'     => 'SKY-' . strtoupper(uniqid()),
                'nama_pembeli'     => $request->nama_pembeli,
                'email'            => $request->email,
                'no_hp'            => $request->no_hp,
                'alamat'           => $request->alamat,
                'total_pembayaran' => $total,
                'status_pesanan'   => 'pending',
            ]);

            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id'    => $order->id,
                    'product_id'  => $cart->product_id,
                    'jumlah'      => $cart->jumlah,
                    'harga_satuan'=> $cart->product->harga,
                    'subtotal'    => $cart->jumlah * $cart->product->harga,
                ]);

                // Kurangi stok
                $cart->product->decrement('stok_kursi', $cart->jumlah);
            }

            // Hapus cart
            Cart::where('user_id', Auth::id())->delete();

            session(['last_order_id' => $order->id]);
        });

        $orderId = session('last_order_id');
        return redirect()->route('orders.success', $orderId)
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    public function success($orderId)
    {
        $order = Order::with('orderItems.product')
            ->where('user_id', Auth::id())
            ->findOrFail($orderId);

        return view('user.order-success', compact('order'));
    }
}
