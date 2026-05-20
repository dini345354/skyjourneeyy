<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@skyjourney.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
            'phone'    => '081234567890',
            'address'  => 'Jakarta, Indonesia',
        ]);

        // Sample Users
        $user1 = User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'budi@example.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
            'phone'    => '082345678901',
            'address'  => 'Bandung, Jawa Barat',
        ]);

        $user2 = User::create([
            'name'     => 'Siti Rahayu',
            'email'    => 'siti@example.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
            'phone'    => '083456789012',
            'address'  => 'Surabaya, Jawa Timur',
        ]);

        // Categories
        $domestik = Category::create(['nama_kategori' => 'Domestik', 'deskripsi' => 'Penerbangan dalam negeri Indonesia']);
        $internasional = Category::create(['nama_kategori' => 'Internasional', 'deskripsi' => 'Penerbangan ke luar negeri']);
        $promo = Category::create(['nama_kategori' => 'Promo', 'deskripsi' => 'Tiket dengan harga promo spesial']);
        $bisnis = Category::create(['nama_kategori' => 'Bisnis', 'deskripsi' => 'Kelas bisnis premium']);

        // Products
        $p1 = Product::create([
            'category_id'          => $domestik->id,
            'nama_tiket'           => 'Jakarta - Bali Economy',
            'maskapai'             => 'Garuda Indonesia',
            'asal'                 => 'Jakarta (CGK)',
            'tujuan'               => 'Bali (DPS)',
            'tanggal_keberangkatan'=> '2025-07-15 08:00:00',
            'harga'                => 850000,
            'stok_kursi'           => 50,
            'deskripsi'            => 'Penerbangan langsung Jakarta ke Bali dengan Garuda Indonesia. Termasuk bagasi 20kg.',
            'gambar'               => null,
        ]);

        $p2 = Product::create([
            'category_id'          => $domestik->id,
            'nama_tiket'           => 'Jakarta - Surabaya Economy',
            'maskapai'             => 'Lion Air',
            'asal'                 => 'Jakarta (CGK)',
            'tujuan'               => 'Surabaya (SUB)',
            'tanggal_keberangkatan'=> '2025-07-20 10:30:00',
            'harga'                => 450000,
            'stok_kursi'           => 80,
            'deskripsi'            => 'Penerbangan Jakarta - Surabaya dengan harga terjangkau. Bagasi kabin 7kg.',
            'gambar'               => null,
        ]);

        $p3 = Product::create([
            'category_id'          => $internasional->id,
            'nama_tiket'           => 'Jakarta - Singapura Economy',
            'maskapai'             => 'Singapore Airlines',
            'asal'                 => 'Jakarta (CGK)',
            'tujuan'               => 'Singapura (SIN)',
            'tanggal_keberangkatan'=> '2025-08-01 14:00:00',
            'harga'                => 2500000,
            'stok_kursi'           => 30,
            'deskripsi'            => 'Penerbangan internasional ke Singapura. Termasuk makan dan bagasi 25kg.',
            'gambar'               => null,
        ]);

        $p4 = Product::create([
            'category_id'          => $promo->id,
            'nama_tiket'           => 'Bali - Lombok PROMO',
            'maskapai'             => 'Citilink',
            'asal'                 => 'Bali (DPS)',
            'tujuan'               => 'Lombok (LOP)',
            'tanggal_keberangkatan'=> '2025-07-25 07:00:00',
            'harga'                => 199000,
            'stok_kursi'           => 100,
            'deskripsi'            => 'Promo spesial Bali - Lombok! Harga terbaik terbatas.',
            'gambar'               => null,
        ]);

        $p5 = Product::create([
            'category_id'          => $bisnis->id,
            'nama_tiket'           => 'Jakarta - Tokyo Business Class',
            'maskapai'             => 'Garuda Indonesia',
            'asal'                 => 'Jakarta (CGK)',
            'tujuan'               => 'Tokyo (NRT)',
            'tanggal_keberangkatan'=> '2025-08-10 22:00:00',
            'harga'                => 15000000,
            'stok_kursi'           => 10,
            'deskripsi'            => 'Kelas bisnis premium Jakarta - Tokyo. Termasuk lounge, makan premium, bagasi 35kg.',
            'gambar'               => null,
        ]);

        $p6 = Product::create([
            'category_id'          => $domestik->id,
            'nama_tiket'           => 'Medan - Jakarta Economy',
            'maskapai'             => 'Batik Air',
            'asal'                 => 'Medan (KNO)',
            'tujuan'               => 'Jakarta (CGK)',
            'tanggal_keberangkatan'=> '2025-07-18 06:00:00',
            'harga'                => 650000,
            'stok_kursi'           => 60,
            'deskripsi'            => 'Penerbangan Medan - Jakarta pagi hari. Bagasi 20kg.',
            'gambar'               => null,
        ]);

        // Sample Order
        $order1 = Order::create([
            'user_id'          => $user1->id,
            'kode_pesanan'     => 'SKY-' . strtoupper(uniqid()),
            'nama_pembeli'     => 'Budi Santoso',
            'email'            => 'budi@example.com',
            'no_hp'            => '082345678901',
            'alamat'           => 'Jl. Merdeka No. 10, Bandung',
            'total_pembayaran' => 850000,
            'status_pesanan'   => 'dibayar',
        ]);

        OrderItem::create([
            'order_id'    => $order1->id,
            'product_id'  => $p1->id,
            'jumlah'      => 1,
            'harga_satuan'=> 850000,
            'subtotal'    => 850000,
        ]);

        $order2 = Order::create([
            'user_id'          => $user2->id,
            'kode_pesanan'     => 'SKY-' . strtoupper(uniqid()),
            'nama_pembeli'     => 'Siti Rahayu',
            'email'            => 'siti@example.com',
            'no_hp'            => '083456789012',
            'alamat'           => 'Jl. Diponegoro No. 5, Surabaya',
            'total_pembayaran' => 5000000,
            'status_pesanan'   => 'pending',
        ]);

        OrderItem::create([
            'order_id'    => $order2->id,
            'product_id'  => $p3->id,
            'jumlah'      => 2,
            'harga_satuan'=> 2500000,
            'subtotal'    => 5000000,
        ]);
    }
}
