<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        "code_barang",
        "nama_barang",
        "quantity",
        "id_kategory",
        "posisi",
        "photo"
    ];

    protected $table = "barang";
    protected $primaryKey = "id_barang";
}