<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    // Menentukan nama tabel (opsional jika mengikuti konvensi jamak bahasa Inggris, tapi disarankan untuk bahasa Indonesia)
    protected $table = 'produks';

    // Mengizinkan kolom berikut diisi secara massal
    protected $fillable = [
        'nama',
        'kategori',
        'harga',
        'stok',
    ];
}