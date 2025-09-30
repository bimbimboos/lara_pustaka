<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $table = 'lokasi_rak'; // Nama table sesuai SQLyog-mu (ganti jika beda, misal 'lokasi_rak')
    protected $primaryKey = 'id_lokasi'; // Standar, asumsi id di table lokasi
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'lantai',
        'ruang',
        // Tambah field lain jika ada di SQLyog, misal: 'alamat', 'deskripsi'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi: Satu lokasi punya banyak rak
    public function rak()
    {
        return $this->hasMany(Rak::class, 'id_lokasi', 'id'); // Foreign key di rak: id_lokasi, local key: id
    }
}
