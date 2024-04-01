<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable
{
    use HasFactory, Notifiable;

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

    public function setPasswordAtrribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

}