<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penerbit extends Model
{
    protected $table = 'penerbit';
    protected $primaryKey = 'id_penerbit';
    public $timestamps = false;

    protected $fillable = ['id_penerbit', 'nama', 'alamat', 'kontak'];
}
