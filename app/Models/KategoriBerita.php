<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBerita extends Model
{
    use HasFactory;

    protected $fillable = [
        "nama_kategori"
    ];

    protected $table = 'kategori_berita';
    protected $primaryKey = "id_kategori";
}