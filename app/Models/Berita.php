<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Berita extends Model
{
    use HasFactory;
    protected $fillable = [
        "title",
        "content",
        "tgl_publikasi",
        "id_kategori"
    ];
    protected $table = "berita";
    protected $primaryKey = "id_berita";
}