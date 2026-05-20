<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'nama_tiket',
        'maskapai',
        'asal',
        'tujuan',
        'tanggal_keberangkatan',
        'harga',
        'stok_kursi',
        'deskripsi',
        'gambar',
    ];

    protected $casts = [
        'tanggal_keberangkatan' => 'datetime',
        'harga' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
