<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    // FORCE table name - ini yang paling penting!
    protected $table = 'kategori_buku';

    // FORCE primary key
    protected $primaryKey = 'id_kategori';

    // Disable timestamps jika tidak ada created_at/updated_at
    public $timestamps = false;

    // Mass assignment
    protected $fillable = ['nama_kategori'];

    // FORCE connection (optional, tapi coba)
    protected $connection = 'mysql';

    public function kategori()
    {
        return $this->hasMany(Subkategori::class, 'id_kategori', 'id_kategori');
    }

    // Override getTable() method untuk memastikan
    public function getTable()
    {
        return 'kategori_buku';
    }
}
