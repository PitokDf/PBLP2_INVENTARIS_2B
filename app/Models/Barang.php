<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $guarded = ['id_barang'];

    protected $table = "barang";
    protected $primaryKey = "id_barang";

    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'id_kategory');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_barang');
    }
}