<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $primaryKey = "code_prodi";
    public $keyType = 'string';
    public $incrementing = false;
}