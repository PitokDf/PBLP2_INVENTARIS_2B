<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public static function getKodePeminjaman()
    {
        $lastPeminjaman = self::whereNotNull('kode_peminjaman')->where('status', '!=', false)->latest('updated_at')->first();
        $nextNumber = 1;
        if ($lastPeminjaman) {
            $lastKode = $lastPeminjaman->kode_peminjaman;
            $lastNumber = (int) substr($lastKode, 3);
            $nextNumber = $lastNumber + 1;
        }

        return 'PBL' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }
}