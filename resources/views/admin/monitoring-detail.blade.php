@extends('layouts.admin')

@section('title', 'Detail Monitoring Siswa')

@section('content')
<div class="space-y-6">

    <!-- BACK BUTTON + HEADER -->
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.monitoring-siswa') }}" class="p-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 transition">
            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="flex-1">
            <h1 class="text-2xl font-extrabold text-slate-800">Detail Monitoring Siswa</h1>
            <p class="text-slate-500 text-sm mt-0.5">Progress dan aktivitas individual siswa</p>
        </div>
    </div>

    <!-- STUDENT PROFILE CARD -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-bold text-3xl shrink-0">
                {{ substr($student->nama ?? 'S', 0, 1) }}
            </div>
            <div class="flex-1">
                <h2 class="text-2xl font-extrabold text-slate-800">{{ $student->nama }}</h2>
                <p class="text-slate-500 text-sm mt-1">{{ $student->email }}</p>
                <div class="flex items-center gap-3 mt-2">
                    @php $statusAktif = ($student->status ?? 'aktif') === 'aktif'; @endphp
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold {{ $statusAktif ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $statusAktif ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                        {{ $statusAktif ? 'Aktif' : 'Nonaktif' }}
                    </span>
                    <span class="text-xs text-slate-500">Bergabung sejak {{ $student->created_at?->format('d M Y') }}</span>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.kirim-reminder', ['id_user' => $student->id_user]) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition">
                    Kirim Pesan
                </a>
            </div>
        </div>
    </div>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
            <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-500">Total Poin</p>
            <p class="text-3xl font-extrabold text-amber-600 mt-1">{{ number_format($totalPoin ?? 0) }}</p>
            <p class="text-xs text-slate-400 mt-1">Akumulasi skor quiz</p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
            <div class="w-11 h-11 rounded-xl bg-purple-50 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-500">Quiz Dikerjakan</p>
            <p class="text-3xl font-extrabold text-purple-600 mt-1">{{ $totalQuizDikerjakan }}</p>
            <p class="text-xs text-slate-400 mt-1">Quiz diselesaikan</p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-500">Rata-rata Nilai</p>
            <p class="text-3xl font-extrabold text-emerald-600 mt-1">{{ number_format($rataRataNilai, 1) }}</p>
            <p class="text-xs text-slate-400 mt-1">Dari semua quiz</p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
            <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-500">Materi Dibaca</p>
            <p class="text-3xl font-extrabold text-blue-600 mt-1">{{ $totalMateriDibaca }}</p>
            <p class="text-xs text-slate-400 mt-1">Materi selesai</p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
            <div class="w-11 h-11 rounded-xl bg-slate-100 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-500">Terakhir Aktif</p>
            <p class="text-lg font-extrabold text-slate-700 mt-1">{{ $lastActive ? $lastActive->diffForHumans() : 'Belum pernah aktif' }}</p>
            <p class="text-xs text-slate-400 mt-1">Sesi belajar</p>
        </div>
    </div>

    <!-- PROGRESS OVERVIEW -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Progress Keseluruhan</h3>

        <div class="mb-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-semibold text-slate-700">Total Progress</span>
                <span class="text-sm font-bold text-indigo-600">{{ $progressKeseluruhan }}%</span>
            </div>
            <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-full" style="width: {{ $progressKeseluruhan }}%"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @php
                $warnaSkill = [
                    'Speaking'  => ['bg-emerald-50', 'text-emerald-700', 'bg-emerald-200', 'bg-emerald-500'],
                    'Writing'   => ['bg-purple-50', 'text-purple-700', 'bg-purple-200', 'bg-purple-500'],
                    'Reading'   => ['bg-blue-50', 'text-blue-700', 'bg-blue-200', 'bg-blue-500'],
                    'Listening' => ['bg-amber-50', 'text-amber-700', 'bg-amber-200', 'bg-amber-500'],
                ];
            @endphp
            @forelse($progressPerSkill as $skill)
                @php
                    [$wBg, $wText, $wTrack, $wFill] = $warnaSkill[$skill['nama']] ?? ['bg-slate-50', 'text-slate-700', 'bg-slate-200', 'bg-slate-500'];
                @endphp
                <div class="p-4 {{ $wBg }} rounded-xl">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold {{ $wText }}">{{ $skill['nama'] }}</span>
                        <span class="text-sm font-bold {{ $wText }}">{{ $skill['persen'] }}%</span>
                    </div>
                    <div class="w-full h-2 {{ $wTrack }} rounded-full overflow-hidden">
                        <div class="h-full {{ $wFill }} rounded-full" style="width: {{ $skill['persen'] }}%"></div>
                    </div>
                    <p class="text-[11px] {{ $wText }} mt-2">{{ $skill['selesai'] }} / {{ $skill['total'] }} materi selesai</p>
                </div>
            @empty
                <div class="col-span-full p-4 text-center text-sm text-slate-500">Belum ada kategori materi.</div>
            @endforelse
        </div>
    </div>

    <!-- RECENT ACTIVITY -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="text-lg font-bold text-slate-800">Aktivitas Terbaru</h3>
        </div>

        <div class="p-4 space-y-3">
            @forelse($aktivitas as $item)
                @php
                    $isQuiz = $item['type'] === 'quiz';
                    $warnaIcon = $isQuiz ? 'purple' : 'blue';
                    $warnaBg   = $isQuiz ? 'bg-purple-50' : 'bg-blue-50';
                    $warnaText = $isQuiz ? 'text-purple-600' : 'text-blue-600';
                @endphp
                <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-slate-50 transition">
                    <div class="w-9 h-9 rounded-xl {{ $warnaBg }} flex items-center justify-center shrink-0">
                        @if($isQuiz)
                            <svg class="w-4 h-4 {{ $warnaText }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        @else
                            <svg class="w-4 h-4 {{ $warnaText }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-slate-800">{{ $item['judul'] }}</p>
                        <p class="text-[11px] text-slate-500">{{ $item['detail'] }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5">{{ $item['label'] }}</p>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center">
                    <p class="text-sm font-semibold text-slate-500">Belum ada aktivitas</p>
                    <p class="text-xs text-slate-400 mt-1">Siswa belum mengerjakan quiz atau membaca materi.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
