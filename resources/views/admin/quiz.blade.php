@extends('layouts.admin')

@section('title', 'Kelola Quiz')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                Kelola Soal Quiz
            </h1>
            <p class="text-slate-500 mt-1 ml-1">Buat dan kelola soal quiz per materi untuk siswa.</p>
        </div>
        <button onclick="openModal('add')" class="inline-flex items-center gap-2 px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-xl shadow-lg shadow-purple-600/30 transition-all hover:scale-105">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Buat Soal Baru
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200">
            <p class="text-sm text-slate-500 font-medium">Total Soal</p>
            <p class="text-3xl font-bold text-slate-800 mt-1">{{ $quizzes->total() }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200">
            <p class="text-sm text-slate-500 font-medium">Total Poin</p>
            <p class="text-3xl font-bold text-emerald-600 mt-1">{{ $quizzes->sum('poin') }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200">
            <p class="text-sm text-slate-500 font-medium">Materi Ada Quiz</p>
            <p class="text-3xl font-bold text-purple-600 mt-1">{{ $quizzes->pluck('id_materi')->unique()->count() }}</p>
        </div>
    </div>

    <!-- Quiz List -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-200">
            <h3 class="text-lg font-bold text-slate-800">Daftar Soal</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Pertanyaan</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Materi</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Kunci</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Poin</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($quizzes as $quiz)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-slate-800">{{ \Illuminate\Support\Str::limit($quiz->pertanyaan, 80) }}</p>
                            <p class="text-xs text-slate-500 mt-1">A. {{ \Illuminate\Support\Str::limit($quiz->pilihan_a, 40) }} • B. {{ \Illuminate\Support\Str::limit($quiz->pilihan_b, 40) }} • C. {{ \Illuminate\Support\Str::limit($quiz->pilihan_c, 40) }} • D. {{ \Illuminate\Support\Str::limit($quiz->pilihan_d, 40) }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-50 text-blue-700">
                                {{ $quiz->materi->judul ?? '-' }}
                            </span>
                            <p class="text-xs text-slate-500 mt-1">{{ $quiz->materi->kategori->nama_kategori ?? '' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-sm font-bold bg-emerald-100 text-emerald-700">{{ $quiz->kunci_jawaban }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-slate-700">{{ $quiz->poin }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick='editQuiz(@js($quiz))' class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button onclick="deleteQuiz({{ $quiz->id_quiz }})" class="p-2 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <p class="text-slate-500 font-medium">Belum ada soal quiz</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($quizzes->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $quizzes->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal Tambah/Edit Soal -->
<div id="quizModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between sticky top-0 bg-white">
            <h3 id="modalTitle" class="text-xl font-bold text-slate-800">Buat Soal Baru</h3>
            <button onclick="closeModal()" class="p-2 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="quizForm" action="{{ route('admin.quiz.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="_method" id="quizMethod" value="PUT" disabled>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Materi</label>
                <select id="inputMateri" name="id_materi" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500">
                    <option value="">Pilih Materi</option>
                    @foreach($materis as $materi)
                        <option value="{{ $materi->id_materi }}">{{ $materi->judul }} ({{ $materi->kategori->nama_kategori ?? '-' }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Pertanyaan</label>
                <textarea id="inputPertanyaan" name="pertanyaan" required rows="3" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500" placeholder="Tulis pertanyaan...">{{ old('pertanyaan') }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pilihan A</label>
                    <input type="text" id="inputA" name="pilihan_a" value="{{ old('pilihan_a') }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pilihan B</label>
                    <input type="text" id="inputB" name="pilihan_b" value="{{ old('pilihan_b') }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pilihan C</label>
                    <input type="text" id="inputC" name="pilihan_c" value="{{ old('pilihan_c') }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pilihan D</label>
                    <input type="text" id="inputD" name="pilihan_d" value="{{ old('pilihan_d') }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kunci Jawaban</label>
                    <select id="inputKunci" name="kunci_jawaban" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Poin</label>
                    <input type="number" id="inputPoin" name="poin" value="{{ old('poin', 10) }}" required min="1" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500">
                </div>
            </div>

            <div class="pt-4 flex gap-3">
                <button type="button" onclick="closeModal()" class="flex-1 px-4 py-2.5 border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-50">Batal</button>
                <button type="submit" class="flex-1 px-4 py-2.5 bg-purple-600 text-white font-semibold rounded-xl hover:bg-purple-700 shadow-lg shadow-purple-600/30">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus -->
<div id="deleteModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-sm p-6 text-center">
        <h3 class="text-xl font-bold text-slate-800 mb-2">Hapus Soal?</h3>
        <p class="text-slate-500 text-sm mb-6">Soal yang dihapus tidak dapat dikembalikan.</p>
        <div class="flex gap-3">
            <button onclick="closeDeleteModal()" class="flex-1 px-4 py-3 border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-50">Batal</button>
            <form id="deleteForm" action="{{ route('admin.quiz.destroy', ['id' => '__ID__']) }}" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full px-4 py-3 bg-rose-600 text-white font-semibold rounded-xl hover:bg-rose-700">Hapus</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openModal(type = 'add', quiz = null) {
    const modal = document.getElementById('quizModal');
    const title = document.getElementById('modalTitle');
    const form = document.getElementById('quizForm');

    if (type === 'edit' && quiz) {
        title.textContent = 'Edit Soal Quiz';
        form.action = @js(route('admin.quiz.update', ['id' => '__ID__'])).replace('__ID__', encodeURIComponent(quiz.id_quiz));
        document.getElementById('quizMethod').disabled = false;
        document.getElementById('inputMateri').value = quiz.id_materi;
        document.getElementById('inputPertanyaan').value = quiz.pertanyaan;
        document.getElementById('inputA').value = quiz.pilihan_a;
        document.getElementById('inputB').value = quiz.pilihan_b;
        document.getElementById('inputC').value = quiz.pilihan_c;
        document.getElementById('inputD').value = quiz.pilihan_d;
        document.getElementById('inputKunci').value = quiz.kunci_jawaban;
        document.getElementById('inputPoin').value = quiz.poin;
    } else {
        title.textContent = 'Buat Soal Baru';
        form.reset();
        form.action = @js(route('admin.quiz.store'));
        document.getElementById('quizMethod').disabled = true;
        document.getElementById('inputPoin').value = 10;
    }
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal() {
    document.getElementById('quizModal').classList.add('hidden');
    document.getElementById('quizModal').classList.remove('flex');
    document.getElementById('quizForm').reset();
}

function editQuiz(quiz) {
    openModal('edit', quiz);
}

function deleteQuiz(id) {
    const form = document.getElementById('deleteForm');
    form.action = @js(route('admin.quiz.destroy', ['id' => '__ID__'])).replace('__ID__', encodeURIComponent(id));
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
}

@if($errors->any())
document.addEventListener('DOMContentLoaded', function() {
    openModal('add');
});
@endif
</script>
@endpush
