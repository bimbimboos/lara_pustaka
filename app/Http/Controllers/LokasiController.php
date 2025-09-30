<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Lokasi = Lokasi::paginate(10);
        return view('Lokasi.index', compact('Lokasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Lokasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ruang' => 'required|string|max:255',
            'lantai' => 'nullable|string|max:255',
        ]);

        Lokasi::create($request->all());

        return redirect()->route('Lokasi.index')
            ->with('success', 'Lokasi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $lokasi = Lokasi::with('raks')->findOrFail($id);
        return view('Lokasi.show', compact('lokasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        return view('Lokasi.edit', compact('lokasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'ruang' => 'required|string|max:255',
            'lantai' => 'nullable|string|max:255',
        ]);

        $lokasi = Lokasi::findOrFail($id);
        $lokasi->update($request->all());

        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Lokasi berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lokasi = Lokasi::findOrFail($id);

        // Cek apakah lokasi masih digunakan oleh rak
        if ($lokasi->raks()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Lokasi tidak dapat dihapus karena masih digunakan oleh rak!');
        }

        $lokasi->delete();

        return redirect()->route('Lokasi.index')
            ->with('success', 'Lokasi berhasil dihapus!');
    }
}
