<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    use HasFactory;

    protected $table = 'rak';
    protected $primaryKey = 'id_rak'; // Custom primary key
    public $incrementing = true; // Auto-increment
    protected $keyType = 'int'; // Integer key

    protected $fillable = [
        'nama',
        'barcode',
        'kolom',
        'baris',
        'kapasitas',
        'id_lokasi'
    ];

    // Relasi: Rak belongs to satu lokasi
    public function Lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi');
    }
}
