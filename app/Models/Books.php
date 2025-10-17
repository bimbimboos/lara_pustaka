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
            'jumlah',
        ];

        public function kategori()
        {
            return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
        }

        public function penerbit()
        {
            return $this->belongsTo(Penerbit::class, 'id_penerbit', 'id_penerbit');
        }

        public function subkategori()
        {
            return $this->belongsTo(Subkategori::class, 'id_subkat', 'id_subkat');
        }

        // PERBAIKI RELASI INI
        public function penataan()  // Ubah dari PenataanBuku() ke penataan()
        {
            return $this->hasMany(PenataanBuku::class, 'id_buku', 'id_buku');  // Foreign key: id_buku
        }
        public function item()
        {
            return $this->hasmany(Items::class, 'id_buku', 'id_buku');
        }
    }
