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
    public function merek()
    {
        return $this->belongsTo(Merk::class, 'merk_id', 'id');
    }
    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class, 'supplier_id', 'id');
    }
}