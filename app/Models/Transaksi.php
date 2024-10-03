<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';
    protected $primaryKey = 'id_transaksi';
    protected $fillable = [
        'id_user',
        'id_meja',
        'nama_pelanggan',
        'status',
    ];
    // In app/Models/Transaksi.php
    protected $casts = [
        'tgl_transaksi' => 'datetime',
    ];


    /**
     * Get the user that owns the transaksi.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Get the meja associated with the transaksi.
     */
    public function meja()
    {
        return $this->belongsTo(Meja::class, 'id_meja');
    }

    /**
     * Get the detailTransaksis for the transaksi.
     */
    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
}
