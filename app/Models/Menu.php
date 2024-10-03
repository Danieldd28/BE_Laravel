<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';
    protected $primaryKey = 'id_menu';
    protected $fillable = [
        'nama_menu',
        'jenis',
        'deskripsi',
        'gambar',
        'harga',
    ];

    /**
     * Get the detailTransaksis associated with the menu.
     */
    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_menu');
    }
}
