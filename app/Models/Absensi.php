<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';
    protected $fillable = [
        'tanggal',
        'divisi_id',
        'nik',
        'status',
        'catatan',
        'foto'
    ];

    public function karyawan()
    {
        return $this->hasOne(Karyawan::class, 'nik', 'nik');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'username', 'nik');
    }
}
