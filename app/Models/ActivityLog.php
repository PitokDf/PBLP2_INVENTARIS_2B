<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;
    public $fillable = [
        "activity",
        "deskripsi",
        "time",
        "id_user",
    ];
    public $timestamps = true;

    public static function createLog($activity, $ket)
    {
        self::create([
            'id_user' => auth()->user()->id_user,
            'activity' => $activity,
            'deskripsi' => $ket . ' pada ' . date('Y-F-d H:i'),
            'time' => now()
        ]);
        return true;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}