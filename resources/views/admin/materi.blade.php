<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Materi - Englify</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col fixed h-full">
        <div class="p-6 border-b border-slate-800">
            <h1 class="text-2xl font-bold text-indigo-400">Englify</h1>
            <p class="text-xs text-slate-400 mt-1">Admin Divisi Panel</p>
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="/admin/dashboard" class="flex items-center gap-3 py-2.5 px-4 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition">Dashboard</a>
            <a href="/admin/kategori" class="flex items-center gap-3 py-2.5 px-4 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition">Data Master Kategori</a>
            <a href="/admin/materi" class="flex items-center gap-3 py-2.5 px-4 bg-indigo-600 rounded-lg font-medium text-white">Kelola Materi</a>
            <a href="#" class="flex items-center gap-3 py-2.5 px-4 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition">Kelola Quiz</a>
        </nav>
        <div class="p-4 border-t border-slate-800">
            <form action="/logout" method="POST">
                @csrf
                <button class="w-full py-2 px-4 bg-red-600 hover:bg-red-700 rounded-lg font-medium transition">Logout</button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-64 p-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-slate-800">Kelola Materi Pembelajaran</h2>
                <p class="text-slate-500 mt-1">Buat dan atur materi untuk setiap kategori.</p>
            </div>
            <button onclick="openModal()" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Materi
            </button>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg text-sm font-medium mb-6 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabel Materi -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Urutan</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Judul & Bab</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($materis as $materi)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 text-sm font-bold text-slate-700">#{{ $materi->urutan }}</td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold text-slate-800">{{ $materi->judul }}</p>
                                <p class="text-xs text-slate-500 mt-1">Bab: {{ $materi->bab }}</p>
                                @if($materi->deskripsi)
                                    <p class="text-xs text-slate-400 mt-1 line-clamp-1">{{ Str::limit($materi->deskripsi, 50) }}</p>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold bg-indigo-50 text-indigo-700 rounded-full border border-indigo-100">
                                {{ $materi->kategori->nama_kategori ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($materi->status == 'Published')
                                <span class="px-3 py-1 text-xs font-semibold bg-emerald-100 text-emerald-700 rounded-full border border-emerald-200">Published</span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold bg-amber-100 text-amber-700 rounded-full border border-amber-200">Draft</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <button onclick='openEditModal({{ json_encode($materi) }})' class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <form action="{{ route('admin.materi.destroy', $materi->id_materi) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus materi ini?');" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500 text-sm">Belum ada materi. Klik "Tambah Materi" untuk memulai.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <!-- Modal Tambah/Edit Materi -->
    <div id="modal-materi" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-3xl max-h-[90vh] overflow-y-auto p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-slate-800" id="modal-title">Tambah Materi Baru</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Form Tambah -->
            <form id="form-tambah" method="POST" action="{{ route('admin.materi.store') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Judul Materi</label>
                        <input type="text" name="judul" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Contoh: Narrative Text">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Bab</label>
                        <input type="text" name="bab" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Contoh: Bab 1">
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Urutan</label>
                        <input type="number" name="urutan" required min="1" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="1">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Kategori</label>
                        <select name="id_kategori" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                            <option value="">-- Pilih --</option>
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Status</label>
                        <select name="status" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                            <option value="Draft">Draft</option>
                            <option value="Published">Published</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi Singkat</label>
                    <input type="text" name="deskripsi" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Deskripsi singkat materi (opsional)">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Isi Materi</label>
                    <textarea name="isi_materi" required rows="6" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Tulis isi materi lengkap di sini..."></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">URL Audio (Opsional)</label>
                        <input type="url" name="audio_url" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="https://...">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Transcript (Opsional)</label>
                        <input type="text" name="transcript" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Teks transcript audio">
                    </div>
                </div>
                <div class="flex justify-end gap-2 pt-2 border-t border-slate-100">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200 text-sm font-semibold">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm font-semibold">Simpan Materi</button>
                </div>
            </form>

            <!-- Form Edit -->
            <form id="form-edit" method="POST" action="" class="space-y-4 hidden">
                @csrf @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Judul Materi</label>
                        <input type="text" name="judul" id="edit-judul" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Bab</label>
                        <input type="text" name="bab" id="edit-bab" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Urutan</label>
                        <input type="number" name="urutan" id="edit-urutan" required min="1" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Kategori</label>
                        <select name="id_kategori" id="edit-kategori" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Status</label>
                        <select name="status" id="edit-status" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                            <option value="Draft">Draft</option>
                            <option value="Published">Published</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi Singkat</label>
                    <input type="text" name="deskripsi" id="edit-deskripsi" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Isi Materi</label>
                    <textarea name="isi_materi" id="edit-isi" required rows="6" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">URL Audio</label>
                        <input type="url" name="audio_url" id="edit-audio" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Transcript</label>
                        <input type="text" name="transcript" id="edit-transcript" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                </div>
                <div class="flex justify-end gap-2 pt-2 border-t border-slate-100">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200 text-sm font-semibold">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 text-sm font-semibold">Update Materi</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('modal-materi');
        const formTambah = document.getElementById('form-tambah');
        const formEdit = document.getElementById('form-edit');
        const modalTitle = document.getElementById('modal-title');

        function openModal() {
            modal.classList.remove('hidden'); modal.classList.add('flex');
            formTambah.classList.remove('hidden'); formEdit.classList.add('hidden');
            modalTitle.textContent = 'Tambah Materi Baru';
        }

        function openEditModal(materi) {
            modal.classList.remove('hidden'); modal.classList.add('flex');
            formTambah.classList.add('hidden'); formEdit.classList.remove('hidden');
            modalTitle.textContent = 'Edit Materi';
            formEdit.action = `/admin/materi/${materi.id_materi}`;

            document.getElementById('edit-judul').value = materi.judul;
            document.getElementById('edit-bab').value = materi.bab;
            document.getElementById('edit-urutan').value = materi.urutan;
            document.getElementById('edit-kategori').value = materi.id_kategori;
            document.getElementById('edit-status').value = materi.status;
            document.getElementById('edit-deskripsi').value = materi.deskripsi || '';
            document.getElementById('edit-isi').value = materi.isi_materi;
            document.getElementById('edit-audio').value = materi.audio_url || '';
            document.getElementById('edit-transcript').value = materi.transcript || '';
        }

        function closeModal() { modal.classList.add('hidden'); modal.classList.remove('flex'); }
        @if ($errors->any()) document.addEventListener('DOMContentLoaded', openModal); @endif
    </script>
</body>
</html>
