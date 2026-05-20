<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('kode_pesanan')->unique();
            $table->string('nama_pembeli');
            $table->string('email');
            $table->string('no_hp');
            $table->text('alamat');
            $table->decimal('total_pembayaran', 15, 2);
            $table->enum('status_pesanan', ['pending', 'dibayar', 'selesai', 'dibatalkan'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
