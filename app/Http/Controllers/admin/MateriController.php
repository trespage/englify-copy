<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\Kategori;

class MateriController extends Controller
{
    // 1. Tampilkan Halaman Materi
    public function index()
    {
        // Ambil semua materi + relasi kategori dan admin
        $materis = Materi::with(['kategori', 'admin'])->orderBy('urutan', 'asc')->get();

        // Ambil semua kategori untuk dropdown
        $kategoris = Kategori::all();

        return view('admin.materi', compact('materis', 'kategoris'));
    }

    // 2. Simpan Materi Baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'bab' => 'required|string|max:100',
            'urutan' => 'required|integer|min:1',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'status' => 'required|in:Draft,Published',
            'deskripsi' => 'nullable|string',
            'isi_materi' => 'required|string',
            'audio_url' => 'nullable|url',
            'transcript' => 'nullable|string',
        ]);

        Materi::create([
            'id_kategori' => $request->id_kategori,
            'id_admin' => auth()->user()->id_user, // Otomatis ambil admin yang login
            'judul' => $request->judul,
            'bab' => $request->bab,
            'urutan' => $request->urutan,
            'status' => $request->status,
            'deskripsi' => $request->deskripsi,
            'isi_materi' => $request->isi_materi,
            'audio_url' => $request->audio_url,
            'transcript' => $request->transcript,
        ]);

        return redirect()->route('admin.materi')->with('success', 'Materi berhasil ditambahkan!');
    }

    // 3. Update Materi
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'bab' => 'required|string|max:100',
            'urutan' => 'required|integer|min:1',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'status' => 'required|in:Draft,Published',
            'deskripsi' => 'nullable|string',
            'isi_materi' => 'required|string',
            'audio_url' => 'nullable|url',
            'transcript' => 'nullable|string',
        ]);

        $materi = Materi::findOrFail($id);
        $materi->update([
            'id_kategori' => $request->id_kategori,
            'judul' => $request->judul,
            'bab' => $request->bab,
            'urutan' => $request->urutan,
            'status' => $request->status,
            'deskripsi' => $request->deskripsi,
            'isi_materi' => $request->isi_materi,
            'audio_url' => $request->audio_url,
            'transcript' => $request->transcript,
        ]);

        return redirect()->route('admin.materi')->with('success', 'Materi berhasil diupdate!');
    }

    // 4. Hapus Materi
    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);
        $materi->delete();

        return redirect()->route('admin.materi')->with('success', 'Materi berhasil dihapus!');
    }
}
