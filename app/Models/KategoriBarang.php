<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBarang extends Model
{
    use HasFactory;

    protected $fillable = [
        "nama_kategori_barang",
    ];
    protected $table = "kategori_barang";
    protected $primarykey = "id";
}