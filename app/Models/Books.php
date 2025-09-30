<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'id_buku';
    public $timestamps = false;

    protected $fillable = [
        'judul',
        'id_kategori',
        'id_penerbit',
        'id_subkat',
        'pengarang',
        'tahun_terbit',
        'isbn',
        'harga',
        'barcode',
    ];

    // Relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    // Relasi ke penerbit
    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class, 'id_penerbit', 'id_penerbit');
    }

    // Relasi ke subkategori
    public function subkategori()
    {
        return $this->belongsTo(Subkategori::class, 'id_subkat', 'id_subkat');
    }
    // Relasi ke book items
    public function items()
    {
        return $this->hasMany(BookItems::class, 'id_buku', 'id_buku');
    }
}
