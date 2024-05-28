<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Berita extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = "berita";
    protected $primaryKey = "id_berita";

    public function kategori()
    {
        return $this->belongsTo(KategoriBerita::class, "kategori_id");
    }
}