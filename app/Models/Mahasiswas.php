<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswas extends Model
{
    use HasFactory;

    protected $fillable = [
        "id_mahasiswa",
        "nama",
        "nim",
        "code_prodi",
        "angkatan",
        "ipk",
    ];

    protected $table = "mahasiswa";
    protected $primaryKey = "id_mahasiswa";

    public function user()
    {
        return $this->hasOne(User::class, "mahasiswa_id");
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, "code_prodi", 'code_prodi');
    }
}