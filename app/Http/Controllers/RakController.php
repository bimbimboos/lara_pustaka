<?php

namespace App\Http\Controllers;

use App\Models\PenataanBuku;
use App\Models\Items;
use App\Models\Rak;
use App\Models\Lokasi;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RakController extends Controller
{
    public function index(Request $request)
    {
        $query = Rak::with('lokasi'); // Perbaiki 'Lokasi' ke 'lokasi' (case-sensitive)

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('barcode', 'like', '%' . $search . '%')
                    ->orWhere('kategori', 'like', '%' . $search . '%')
                    ->orWhereHas('lokasi', function ($q) use ($search) {
                        $q->where('ruang', 'like', '%' . $search . '%');
                    });
            });
        }

        $raks = $query->paginate(10);

        return view('raks.index', compact('raks'));
    }

    public function create()
    {
        $lokasis = Lokasi::all(); // Ambil semua lokasi untuk dropdown
        return view('raks.create', compact('lokasis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'barcode' => 'required|string|max:100|unique:rak,barcode',
            'kolom' => 'required|integer|min:1|max:1000',
            'baris' => 'required|integer|min:1|max:1000',
            'kapasitas' => 'required|integer|min:1|max:9999',
            'id_lokasi' => 'required|exists:lokasi,id',
            'id_kategori' => 'required|exists:kategori,id_kategori'
        ], [
            'barcode.unique' => 'Barcode sudah digunakan!',
            'id_lokasi.exists' => 'Lokasi tidak valid!',
        ]);

        try {
            Rak::create($validated);
            return redirect()->route('raks.index')->with('success', 'Rak berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menambahkan rak: ' . $e->getMessage());
        }
    }

    public function show($id_rak)
    {
        $rak = Rak::with('lokasi')->findOrFail($id_rak);
        $jumlah_terisi = PenataanBuku::where('id_rak', $id_rak)->sum('jumlah_buku');

        // Ambil data penataan buku dengan relasi lengkap
        $items = PenataanBuku::with(['books.subkategori.kategori'])
            ->where('id_rak', $id_rak)
            ->orderBy('kolom')
            ->orderBy('baris')
            ->get();

        // Debug: Cek data yang diambil
        // dd($items->pluck('books')->toArray());

        // Persiapkan data subkategori per kolom yang sesuai dengan kategori rak
        $subkategori_per_kolom = [];
        $grouped_by_column = $items->groupBy('kolom');

        foreach ($grouped_by_column as $kolom => $column_items) {
            $min_baris = $column_items->min('baris');
            $max_baris = $column_items->max('baris');
            $range_baris = $min_baris === $max_baris ? $min_baris : "$min_baris-$max_baris";
            $total_buku = $column_items->sum('jumlah_buku');

            // Cari subkategori yang match dengan id_kategori rak
            $subkategori = null;
            foreach ($column_items as $item) {
                if ($item->books && $item->books->subkategori) {
                    if ($item->books->subkategori->id_kategori == $rak->id_kategori) {
                        $subkategori = $item->books->subkategori;
                        break; // Ambil yang pertama yang match
                    }
                }
            }

            $subkategori_per_kolom[$kolom] = [
                'subkategori' => $subkategori,
                'range_baris' => "Baris $range_baris",
                'total_buku' => $total_buku,
            ];
        }

        // Ubah ke koleksi
        $subkategori_per_kolom = collect($subkategori_per_kolom);

        return view('raks.show', compact('rak', 'jumlah_terisi', 'items', 'subkategori_per_kolom'));
    }

    public function edit($id_rak)
    {
        $rak = Rak::findOrFail($id_rak);
        $lokasis = Lokasi::all();
        return view('raks.edit', compact('rak', 'lokasis'));
    }

    public function update(Request $request, $id_rak)
    {
        $rak = Rak::findOrFail($id_rak);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'barcode' => [
                'required',
                'string',
                'max:100',
                'unique:rak,barcode,' . $id_rak, // Ignore ID saat update
            ],
            'kolom' => 'required|integer|min:1|max:1000',
            'baris' => 'required|integer|min:1|max:1000',
            'kapasitas' => 'required|integer|min:1|max:9999',
            'id_lokasi' => 'required|exists:lokasi,id',
            'id_kategori' => 'required|exists:kategori,id_kategori'
        ], [
            'barcode.unique' => 'Barcode sudah digunakan!',
            'id_lokasi.exists' => 'Lokasi tidak valid!',
        ]);

        try {
            $rak->update($validated);
            return redirect()->route('raks.index')->with('success', 'Rak berhasil diupdate!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal mengupdate rak: ' . $e->getMessage());
        }
    }

    public function destroy($id_rak)
    {
        $rak = Rak::findOrFail($id_rak);

        try {
            $rak->delete();
            return redirect()->route('raks.index')->with('success', 'Rak berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus rak: ' . $e->getMessage() . ' (Mungkin ada data terkait?)');
        }
    }
    public function showEksemplar($id_rak)
    {
        $rak = Rak::with('lokasi')->findOrFail($id_rak);
        $eksemplar = PenataanBuku::with(['books'])
            ->where('id_rak', $id_rak)
            ->orderBy('kolom')
            ->orderBy('baris')
            ->get();

        return view('bookitems.index', compact('rak', 'eksemplar')); // Pake view Items/index
    }

    public function showBookEksemplar($id_buku)
    {
        $book = \App\Models\Book::with('subkategori.kategori')->findOrFail($id_buku);
        $eksemplar = PenataanBuku::with(['rak.lokasi'])
            ->where('id_buku', $id_buku)
            ->orderBy('kolom')
            ->orderBy('baris')
            ->get();

        return view('bookitems.index', compact('book', 'eksemplar')); // Pake view yang sama
    }
}
