<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subkategori extends Model
{
    protected $table = 'subkategories';
    protected $primaryKey = 'id_subkat';
    public $timestamps = false;

    protected $fillable = ['nama_subkat', 'id_kategori'];
    public function kategori()
    {
        // id_kategori di tabel subkategories tetap bisa di-relasikan walau nggak ada FK
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
}
