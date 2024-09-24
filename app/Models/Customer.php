<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer'; 
    // protected $primaryKey = 'kode_customer'; 

    protected $fillable = [
        'kode_customer',
        'nama_customer',
        'alamat',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'kode_customer', 'kode_customer');
    }
}
