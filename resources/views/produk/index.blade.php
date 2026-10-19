<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk - Kopdes Merah Putih</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8 font-sans antialiased">

    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">📦 Katalog Produk Kopdes Merah Putih</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('produk.index') }}" method="GET" class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200 flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label for="q" class="block text-sm font-medium text-gray-700 mb-1">Cari Nama Barang</label>
                <input type="text" name="q" id="q" value="{{ request('q') }}" placeholder="Contoh: Beras" 
                    class="shadow-sm border-gray-300 rounded-md w-full py-2 px-3 border focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>

            <div class="w-48">
                <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="kategori" id="kategori" class="shadow-sm border-gray-300 rounded-md w-full py-2 px-3 border focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="">Semua Kategori</option>
                    <option value="sembako" {{ request('kategori') == 'sembako' ? 'selected' : '' }}>Sembako</option>
                    <option value="minuman" {{ request('kategori') == 'minuman' ? 'selected' : '' }}>Minuman</option>
                    <option value="rumah_tangga" {{ request('kategori') == 'rumah_tangga' ? 'selected' : '' }}>Rumah Tangga</option>
                    <option value="perawatan_diri" {{ request('kategori') == 'perawatan_diri' ? 'selected' : '' }}>Perawatan Diri</option>
                </select>
            </div>

            <div class="flex items-center mb-2">
                <input type="checkbox" name="sort" value="harga" id="sort" {{ request('sort') == 'harga' ? 'checked' : '' }}
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="sort" class="ml-2 block text-sm text-gray-900">Urutkan Harga Termurah</label>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white py-2 px-4 rounded shadow text-sm font-medium">Terapkan</button>
                <a href="{{ route('produk.index') }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 py-2 px-4 rounded shadow-sm text-sm font-medium text-center">Reset</a>
            </div>
        </form>

        <div class="mb-6">
            <a href="{{ route('produk.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow">
                + Tambah Barang Baru
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left border-b">Nama Barang</th>
                        <th class="py-3 px-6 text-left border-b">Kategori</th>
                        <th class="py-3 px-6 text-left border-b">Harga</th>
                        <th class="py-3 px-6 text-center border-b">Stok</th>
                        <th class="py-3 px-6 text-center border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse ($produks as $produk)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-6 text-left font-semibold text-gray-800">
                                {{ $produk->nama }}
                            </td>
                            <td class="py-3 px-6 text-left capitalize">
                                <span class="bg-gray-200 py-1 px-3 rounded-full text-xs">
                                    {{ str_replace('_', ' ', $produk->kategori) }}
                                </span>
                            </td>
                            <td class="py-3 px-6 text-left">
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-6 text-center">
                                @if($produk->stok > 10)
                                    <span class="text-green-600 font-bold">{{ $produk->stok }}</span>
                                @elseif($produk->stok > 0)
                                    <span class="text-yellow-600 font-bold">{{ $produk->stok }} (Menipis)</span>
                                @else
                                    <span class="text-red-600 font-bold">Habis</span>
                                @endif
                            </td>
                            <td class="py-3 px-6 text-center whitespace-nowrap">
                                <div class="flex item-center justify-center space-x-3">
                                    <a href="{{ route('produk.edit', $produk->id) }}" class="text-blue-500 hover:text-blue-700 font-medium bg-blue-50 py-1 px-3 rounded text-xs border border-blue-200">
                                        Edit
                                    </a>
                                    
                                    <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini dari katalog?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium bg-red-50 py-1 px-3 rounded text-xs border border-red-200">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 px-6 text-center text-gray-500 text-base">
                                Belum ada barang yang didaftarkan ke dalam katalog.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $produks->links() }}
        </div>
    </div>

</body>
</html>