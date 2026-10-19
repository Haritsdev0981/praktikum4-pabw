<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Kopdes Merah Putih</title>
    <!-- Menggunakan Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8 font-sans antialiased">

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Pendaftaran Barang Baru</h1>
        
        <!-- Menampilkan pesan error umum jika ada -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Oops!</strong>
                <span class="block sm:inline">Ada masalah dengan data yang Anda masukkan.</span>
            </div>
        @endif

        <form action="{{ route('produk.store') }}" method="POST">
            <!-- CSRF Token wajib untuk keamanan form di Laravel -->
            @csrf

            <!-- Input Nama -->
            <div class="mb-4">
                <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama Barang</label>
                <input type="text" name="nama" id="nama" maxlength="100" value="{{ old('nama') }}" 
                    class="shadow appearance-none border @error('nama') border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    placeholder="Contoh: Beras Rojo Lele 5kg" required>
                @error('nama')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Select Kategori -->
            <div class="mb-4">
                <label for="kategori" class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                <select name="kategori" id="kategori" required
                    class="shadow appearance-none border @error('kategori') border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="" disabled {{ old('kategori') ? '' : 'selected' }}>-- Pilih Kategori --</option>
                    <option value="sembako" {{ old('kategori') == 'sembako' ? 'selected' : '' }}>Sembako</option>
                    <option value="minuman" {{ old('kategori') == 'minuman' ? 'selected' : '' }}>Minuman</option>
                    <option value="rumah_tangga" {{ old('kategori') == 'rumah_tangga' ? 'selected' : '' }}>Rumah Tangga</option>
                    <option value="perawatan_diri" {{ old('kategori') == 'perawatan_diri' ? 'selected' : '' }}>Perawatan Diri</option>
                </select>
                @error('kategori')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Input Harga -->
            <div class="mb-4">
                <label for="harga" class="block text-gray-700 text-sm font-bold mb-2">Harga (Rp)</label>
                <input type="number" name="harga" id="harga" min="1" value="{{ old('harga') }}"
                    class="shadow appearance-none border @error('harga') border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    placeholder="Contoh: 75000" required>
                @error('harga')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Input Stok -->
            <div class="mb-6">
                <label for="stok" class="block text-gray-700 text-sm font-bold mb-2">Jumlah Stok</label>
                <input type="number" name="stok" id="stok" min="0" value="{{ old('stok') }}"
                    class="shadow appearance-none border @error('stok') border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    placeholder="Contoh: 20" required>
                @error('stok')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-between mt-8">
                <a href="{{ route('produk.index') }}" class="text-gray-600 hover:text-gray-800 font-semibold underline">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline shadow">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>

</body>
</html>