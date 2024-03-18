<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user', // Tambahkan kolom 'id_user' ke dalam fillable
        'name',
        'email',
        'role',
        'password',
        'created_at',
        'updated_at',
    ];
    protected $table = 'users';
    protected $primaryKey = 'id_user';
}