<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksis';
    protected $primaryKey = 'id_detail_transaksi';
    protected $fillable = [
        'id_transaksi',
        'id_menu',
        'jumlah',
        'harga',
    ];

    /**
     * Get the transaksi that owns the detail.
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    /**
     * Get the menu associated with the detail.
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu');
    }
}
