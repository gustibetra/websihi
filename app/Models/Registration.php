<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    // ✅ PENTING: Tentukan nama tabel secara eksplisit
    // Sesuaikan dengan nama tabel Anda di phpMyAdmin
    protected $table = 'registrations';

    protected $fillable = [
        'nama_lengkap',
        'jenis_kelamin',
        'tgl_lahir',
        'asal_sekolah',
        'alamat_rumah',
        'tahun_lulus',
        'jurusan_sekolah',
        'no_whatsapp',
        'no_ortu',
        'email',
        'program',
        'status',
    ];

    // ✅ BARU: Cast kolom datetime agar aman
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'tgl_lahir'  => 'date',
    ];
}