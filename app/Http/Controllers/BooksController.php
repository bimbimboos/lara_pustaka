<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\Subkategori;

class BooksController extends Controller
{
    public function index(Request $request)
    {
        $query = Books::with(['kategori', 'penerbit', 'subkategori']);

        // 🔍 Search buku berdasarkan judul, penerbit, tahun terbit, pengarang, kategori, subkategori
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('pengarang', 'like', "%{$search}%")
                    ->orWhere('tahun_terbit', 'like', "%{$search}%")
                    ->orWhereHas('penerbit', function($sub) use ($search) {
                        $sub->where('nama', 'like', "%{$search}%");
                    })
                    ->orWhereHas('kategori', function($sub) use ($search) {
                        $sub->where('nama_kategori', 'like', "%{$search}%");
                    })
                    ->orWhereHas('subkategori', function($sub) use ($search) {
                        $sub->where('nama_subkat', 'like', "%{$search}%");
                    });
            });
        }

        $books = $query->paginate(5);

        $kategoris = Kategori::all();
        $penerbits = Penerbit::all();
        $subkategories = Subkategori::all();

        return view('books.index', compact('books', 'kategoris', 'penerbits', 'subkategories'));
    }

    public function create()
    {
        $penerbits = Penerbit::all();
        $kategoris = Kategori::all();
        $subkategories = Subkategori::all();

        return view('books.create', compact('penerbits', 'kategoris', 'subkategories'));
    }

    public function store(Request $request)
    {
        // 🔒 Validasi dulu supaya ga ada null value
        $request->validate([
            'judul' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori_buku,id_kategori',
            'id_penerbit' => 'required|exists:penerbit,id_penerbit',
            'id_subkat' => 'required|exists:subkategories,id_subkat',
            'pengarang' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|string|max:10',
            'isbn' => 'nullable|string|max:50',
            'harga' => 'nullable|numeric',
            'barcode' => 'nullable|string|max:255',
        ]);

        Books::create($request->only([
            'judul',
            'id_kategori',
            'id_penerbit',
            'id_subkat',
            'pengarang',
            'tahun_terbit',
            'isbn',
            'harga',
            'barcode',
        ]));

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $book = Books::findOrFail($id);
        $penerbits = Penerbit::all();
        $kategoris = Kategori::all();
        $subkategories = Subkategori::all();

        return view('books.edit', compact('book', 'penerbits', 'kategoris', 'subkategories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori_buku,id_kategori',
            'id_penerbit' => 'required|exists:penerbit,id_penerbit',
            'id_subkat' => 'required|exists:subkategories,id_subkat',
            'pengarang' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|string|max:10',
            'isbn' => 'nullable|string|max:50',
            'harga' => 'nullable|numeric',
            'barcode' => 'nullable|string|max:255',
        ]);

        $book = Books::findOrFail($id);

        $book->update($request->only([
            'judul',
            'id_kategori',
            'id_penerbit',
            'id_subkat',
            'pengarang',
            'tahun_terbit',
            'isbn',
            'harga',
            'barcode',
        ]));

        return redirect()->route('books.index')->with('success', 'Buku berhasil diupdate!');
    }

    public function destroy($id)
    {
        $book = Books::findOrFail($id);
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus!');
    }

    public function kategori()
    {
        $kategoris = Kategori::all();
        return view('kategori.index', compact('kategoris'));
    }

    public function subkategori()
    {
        $subkategories = Subkategori::all();
        return view('subkategori.index', compact('subkategories'));
    }

    public function penerbit()
    {
        $penerbits = Penerbit::all();
        return view('penerbit.index', compact('penerbits'));
    }

    // 🔹 FIXED: Method show untuk redirect ke list item buku
    public function show($id)
    {
        $book = Books::with(['kategori', 'penerbit', 'subkategori'])->findOrFail($id);

        return view('books.show', compact('book'));
    }

}
