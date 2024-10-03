<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->timestamp('tgl_transaksi')->useCurrent();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_meja');
            $table->string('nama_pelanggan', 100);
            $table->enum('status', ['belum_bayar', 'lunas']);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_meja')->references('id_meja')->on('mejas')->onDelete('cascade');
        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
