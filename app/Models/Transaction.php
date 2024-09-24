<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    // protected $primaryKey = ['no_transaksi', 'tgl_transaksi']; 
    public $incrementing = false; 
    protected $keyType = 'string'; 
    protected $casts = [
        'tgl_transaksi' => 'datetime',
    ];
    
    protected $fillable = [
        'no_transaksi',
        'tgl_transaksi',
        'kode_customer',
        'total',
        'keterangan',
    ];

    // Define relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'kode_customer', 'kode_customer');
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'no_transaksi', 'no_transaksi');
    }
}
