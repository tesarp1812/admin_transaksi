<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi';
    // protected $primaryKey = ['no_transaksi', 'tgl_transaksi','kode_barang', 'urut']; 
    public $incrementing = false; 
    protected $keyType = 'string';

    protected $fillable = [
        'no_transaksi',
        'tgl_transaksi',
        'kode_barang',
        'urut',
        'qty',
        'harga',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'no_transaksi', 'no_transaksi');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'kode_barang', 'kode_barang');
    }
}
