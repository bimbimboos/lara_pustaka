<?php

namespace App\Http\Controllers;

use App\Models\Subkategori;
use App\Models\Kategori;
use Illuminate\Http\Request;

class SubkategoriController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $subkategoris = Subkategori::with('kategori')
            ->when($search, function ($query, $search) {
                $query->where('nama_subkat', 'like', "%{$search}%")
                    ->orWhereHas('kategori', function ($q) use ($search) {
                        $q->where('nama_kategori', 'like', "%{$search}%");
                    });
            })
            ->paginate(5);

        $kategoris = Kategori::all();

        return view('subkategori.index', compact('subkategoris', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('subkategori.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_subkat' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori_buku,id_kategori',
        ]);

        Subkategori::create([
            'nama_subkat' => $request->input('nama_subkat'),
            'id_kategori' => $request->input('id_kategori'),
        ]);

        return redirect()
            ->route('subkategori.index')
            ->with('success', 'Subkategori berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $subkategori = Subkategori::findOrFail($id);
        $kategoris = Kategori::all();
        return view('subkategori.edit', compact('subkategori', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_subkat' => 'required|string|max:255',
            // PERBAIKAN: Tabel yang benar adalah 'kategori_buku'
            'id_kategori' => 'required|exists:kategori_buku,id_kategori',
        ]);

        $subkategori = Subkategori::findOrFail($id);
        $subkategori->update([
            'nama_subkat' => $request->nama_subkat,
            'id_kategori' => $request->id_kategori,
        ]);

        return redirect()->route('subkategori.index')
            ->with('success', 'Subkategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $subkategori = Subkategori::findOrFail($id);
        $subkategori->delete();

        return redirect()->route('subkategori.index')
            ->with('success', 'Subkategori berhasil dihapus!');
    }
}
