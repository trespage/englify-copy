@extends('layouts.admin')

@section('title', 'Hasil Quiz')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                Hasil Quiz
            </h1>
            <p class="text-slate-500 mt-1 ml-1">Monitor hasil quiz dan performa siswa.</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Total Quiz Dikerjakan</p>
                    <p class="text-4xl font-bold mt-2">{{ $totalQuiz }}</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-sm font-medium">Rata-rata Nilai</p>
                    <p class="text-4xl font-bold mt-2">{{ number_format($averageScore, 1) }}</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Rekap Tersimpan</p>
                    <p class="text-4xl font-bold mt-2">{{ $totalCompleted }}</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Hasil Quiz Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-800">Riwayat Pengerjaan Quiz</h3>
            <div class="flex gap-2">
                <input type="text" placeholder="Cari siswa..." class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20">
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Siswa</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Materi</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Skor</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Waktu</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($hasilQuizzes as $hasil)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-sm">
                                    {{ substr($hasil->user->nama ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $hasil->user->nama ?? '-' }}</p>
                                    <p class="text-xs text-slate-500">{{ $hasil->user->email ?? '' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-slate-800">{{ $hasil->quiz->materi->judul ?? '-' }}</p>
                            <p class="text-xs text-slate-500">{{ $hasil->quiz->judul ?? '' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center justify-center min-w-12 h-12 px-3 rounded-xl font-bold text-lg bg-emerald-100 text-emerald-700">
                                {{ $hasil->skor_diperoleh }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $hasil->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.hasil-quiz.detail', $hasil->id_hasil) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-purple-50 text-purple-600 rounded-lg text-xs font-semibold hover:bg-purple-100 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <p class="text-slate-500 font-medium">Belum ada hasil quiz</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($hasilQuizzes->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $hasilQuizzes->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
