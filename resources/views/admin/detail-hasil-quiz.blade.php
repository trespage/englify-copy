@extends('layouts.admin')

@section('title', 'Detail Hasil Quiz')

@section('content')
<div class="space-y-6">
    <div>
        <a href="{{ route('admin.hasil-quiz') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">&larr; Kembali ke Hasil Quiz</a>
        <h1 class="text-2xl font-bold text-slate-800 mt-2">Detail Hasil Quiz</h1>
        <p class="text-slate-500 mt-1">Rincian pengerjaan quiz siswa.</p>
    </div>

    <!-- Ringkasan -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <p class="text-xs font-bold text-slate-500 uppercase">Siswa</p>
            <p class="font-bold text-slate-800 mt-1">{{ $hasil->user->nama ?? '-' }}</p>
            <p class="text-xs text-slate-500">{{ $hasil->user->email ?? '' }}</p>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-500 uppercase">Materi</p>
            <p class="font-bold text-slate-800 mt-1">{{ $hasil->quiz->materi->judul ?? '-' }}</p>
            <p class="text-xs text-slate-500">{{ $hasil->quiz->judul ?? '' }}</p>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-500 uppercase">Skor Total</p>
            <p class="text-3xl font-bold text-emerald-600 mt-1">{{ $hasil->skor_diperoleh }}</p>
            <p class="text-xs text-slate-500">Dikerjakan {{ $hasil->created_at->format('d M Y, H:i') }}</p>
        </div>
    </div>

    <!-- Rincian Jawaban -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-200">
            <h3 class="text-lg font-bold text-slate-800">Rincian Jawaban</h3>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($hasil->jawaban as $i => $j)
            <div class="p-6 flex items-start gap-4">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold shrink-0 {{ $j->benar ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">{{ $i + 1 }}</span>
                <div class="flex-1">
                    <p class="font-semibold text-slate-800">{{ $j->quiz->pertanyaan ?? '-' }}</p>
                    <p class="text-sm text-slate-600 mt-1">Jawaban siswa: <span class="font-bold">{{ $j->jawaban_user }}</span> • Kunci: <span class="font-bold">{{ $j->quiz->kunci_jawaban ?? '-' }}</span> • Poin soal: {{ $j->quiz->poin ?? 0 }}</p>
                </div>
                @if($j->benar)
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">Benar</span>
                @else
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700">Salah</span>
                @endif
            </div>
            @empty
            <p class="p-6 text-slate-500 font-medium text-center">Belum ada rincian jawaban.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
