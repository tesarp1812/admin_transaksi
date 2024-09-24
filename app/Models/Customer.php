<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers'; 
    protected $primaryKey = 'kode_customer'; 
    public $incrementing = false; 
    protected $keyType = 'string'; 

    protected $fillable = [
        'kode_customer',
        'nama_customer',
        'alamat',
    ];
}
