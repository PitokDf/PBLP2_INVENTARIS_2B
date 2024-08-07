<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, CanResetPassword;
    protected $guarded = ['id_user'];
    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $hidden = [
        'password'
    ];
    public function setPasswordAtrribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id_user = (string) Str::uuid();
        });
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    protected $keyType = 'string';
    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswas::class, 'id_mahasiswa', "mahasiswa_id");
    }
    public function DosenTest()
    {
        return $this->hasOne(Dosen::class, 'id_dosen', "id_user");
    }
    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'id_dosen', "dosen_id");
    }


    public static function createSlug(string $text)
    {
        $slug = Str::slug($text, "-");
        return $slug;
    }
}