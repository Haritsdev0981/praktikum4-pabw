<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        // Mulai membuat query builder
        $query = Produk::query();

        // 1. Pencarian nama produk (Pencocokan sebagian menggunakan LIKE)
        if ($request->filled('q')) {
            $query->where('nama', 'like', '%' . $request->q . '%');
        }

        // 2. Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // 3. Pengurutan berdasarkan harga termurah jika parameter sort=harga ada
        if ($request->query('sort') === 'harga') {
            $query->orderBy('harga', 'asc');
        }

        // 4. Pengurutan sekunder berdasarkan nama (selalu diaplikasikan)
        $query->orderBy('nama', 'asc');

        // 5. Paginasi 10 baris per halaman & mempertahankan parameter query (withQueryString)
        $produks = $query->paginate(10)->withQueryString();

        // Mengirim data ke view
        return view('produk.index', compact('produks'));
    }

    // Method baru untuk menangani rute GET /produk/create
    public function create()
    {
        // Mengarahkan ke file view resources/views/produk/create.blade.php
        return view('produk.create'); 
    }

    // Method store yang sudah kita buat sebelumnya
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama'     => 'required|string|max:100',
            'kategori' => 'required|in:sembako,minuman,rumah_tangga,perawatan_diri',
            'harga'    => 'required|integer|min:1',
            'stok'     => 'required|integer|min:0',
        ]);

        Produk::create($validatedData);

        return redirect()->route('produk.index')
                         ->with('success', 'Barang baru berhasil didaftarkan ke katalog Kopdes Merah Putih.');
    }

    // Menampilkan form edit produk (Route Model Binding otomatis mencari data berdasarkan ID)
    public function edit(Produk $produk)
    {
        return view('produk.edit', compact('produk'));
    }

    // Memvalidasi dan menyimpan perubahan data
    public function update(Request $request, Produk $produk)
    {
        // Validasi ulang dengan aturan yang persis sama seperti saat Create
        $validatedData = $request->validate([
            'nama'     => 'required|string|max:100',
            'kategori' => 'required|in:sembako,minuman,rumah_tangga,perawatan_diri',
            'harga'    => 'required|integer|min:1',
            'stok'     => 'required|integer|min:0',
        ], [
            'nama.max' => 'Nama produk tidak boleh lebih dari 100 karakter.',
            'kategori.in' => 'Kategori yang dipilih tidak valid.',
            'harga.min' => 'Harga produk minimal Rp1.',
            'stok.min' => 'Stok tidak boleh bernilai negatif.'
        ]);

        // Melakukan update data ke database
        $produk->update($validatedData);

        // Kembali ke halaman index dengan pesan sukses khusus update
        return redirect()->route('produk.index')
                         ->with('success', 'Data barang berhasil diperbarui.');
    }

    // Menghapus data produk dari database
    public function destroy(Produk $produk)
    {
        $produk->delete();

        // Kembali ke halaman index dengan pesan sukses khusus delete
        return redirect()->route('produk.index')
                         ->with('success', 'Barang telah berhasil dihapus dari katalog.');
    }
}