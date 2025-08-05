<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerima extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'nama_ayah',
        'nama_ibu',
        'tempat_lahir',
        'tanggal_lahir',
        'nama_sekolah',
        'tingkat',
        'kelas',
        'alamat',
        'kode_unik',
        'status',
    ];
}
