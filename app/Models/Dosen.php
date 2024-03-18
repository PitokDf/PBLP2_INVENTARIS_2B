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
        "academic_position",
        "phone_number",
        "email",
        "photo_dir"
    ];
    protected $table = "dosen";
    public $primaryKey = "id_dosen";
}