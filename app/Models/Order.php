<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'kode_pesanan',
        'nama_pembeli',
        'email',
        'no_hp',
        'alamat',
        'total_pembayaran',
        'status_pesanan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status_pesanan) {
            'pending'    => '<span class="badge bg-warning">Pending</span>',
            'dibayar'    => '<span class="badge bg-info">Dibayar</span>',
            'selesai'    => '<span class="badge bg-success">Selesai</span>',
            'dibatalkan' => '<span class="badge bg-danger">Dibatalkan</span>',
            default      => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
}
