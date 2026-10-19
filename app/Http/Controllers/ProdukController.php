<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::query();

        if ($request->filled('q')) {
            $query->where('nama', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->query('sort') === 'harga') {
            $query->orderBy('harga', 'asc');
        }

        $query->orderBy('nama', 'asc');

        $produks = $query->paginate(10)->withQueryString();

        return view('produk.index', compact('produks'));
    }

    public function create()
    {
        return view('produk.create'); 
    }

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

    public function edit(Produk $produk)
    {
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
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

        $produk->update($validatedData);

        return redirect()->route('produk.index')
                         ->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();

        return redirect()->route('produk.index')
                         ->with('success', 'Barang telah berhasil dihapus dari katalog.');
    }
}