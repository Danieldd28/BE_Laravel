<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Meja extends Model
{
    use HasFactory,Notifiable;
    protected $primaryKey = 'id_meja'; // Use 'id_meja' as the primary key
    protected $fillable = ['nomor_meja', 'status'];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_meja');
    }
}
