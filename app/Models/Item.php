<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'harga', 
    ];

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class, 'kode_barang', 'kode_barang');
    }
}
