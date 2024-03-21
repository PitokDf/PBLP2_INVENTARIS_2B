<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        "id_mahasiswa",
        "nama",
        "nim",
        "program_studi",
        "angkatan",
        "ipk"
    ];

    protected $table = "mahasiswa";
    protected $primaryKey = "id_mahasiswa";
}