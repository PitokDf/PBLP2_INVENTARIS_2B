<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    // protected $fillable = [
    //     'id_user', // Tambahkan kolom 'id_user' ke dalam fillable
    //     'name',
    //     'email',
    //     'role',
    //     'password',
    //     'created_at',
    //     'updated_at',
    // ];
    protected $guarded = ['id_user'];
    protected $table = 'users';
    protected $primaryKey = 'id_user';

    public function setPasswordAtrribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
    public function idAdmin()
    {
        return $this->role == "1";
    }
}