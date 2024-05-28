<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $fillable = [
        "id_dosen",
        "name",
        "nip",
        "jabatan_id",
        "phone_number",
        "email",
        "photo_dir"
    ];
    protected $table = "dosen";
    public $primaryKey = "id_dosen";

    public function user()
    {
        return $this->hasOne(User::class, 'dosen_id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}