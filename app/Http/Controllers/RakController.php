<?php

namespace App\Http\Controllers;

use App\Models\Rak;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Untuk error handling jika perlu

class RakController extends Controller
{
    public function index(Request $request)
    {
        $query = Rak::with('Lokasi');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('barcode', 'like', '%' . $search . '%')
                    ->orWhereHas('Lokasi', function($q) use ($search) {
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
            'id_lokasi' => 'required|exists:lokasi,id', // Ganti 'lokasis' jadi 'lokasi' sesuai table
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

    public function show($id)
    {
        $rak = Rak::with('Lokasi')->findOrFail($id);
        return view('raks.show', compact('rak'));
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
                'unique:rak,barcode,' . $id_rak // Ignore ID saat update
            ],
            'kolom' => 'required|integer|min:1|max:1000',
            'baris' => 'required|integer|min:1|max:1000',
            'kapasitas' => 'required|integer|min:1|max:9999',
            'id_lokasi' => 'required|exists:lokasi,id',
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
}
