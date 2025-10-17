<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    use HasFactory;

    protected $table = 'rak';
    protected $primaryKey = 'id_rak';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;  // TAMBAHKAN INI karena tidak pakai created_at/updated_at

    protected $fillable = [
        'nama',
        'barcode',
        'kolom',
        'baris',
        'kapasitas',
        'id_lokasi',
        'id_kategori',
        'jumlah_terisi'
    ];

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi', 'id_lokasi');
    }
    public function raks()
    {
        return $this->hasMany(PenataanBuku::class, 'id_rak', 'id_rak');
    }
    public function kategori()
    {
        return $this->belongsTo( Kategori::class, 'id_kategori', 'id_kategori');
    }
    public function penataan()
    {
        return $this->hasMany(PenataanBuku::class, 'id_rak', 'id_rak');
    }
    public function subkategori()
    {
        return $this->belongsTo( Subkategori::class, 'id_subkat', 'id_subkat');
    }
    public function items()
    {
        return $this->hasMany( Items::class, 'id_rak', 'id_rak');
    }
}
