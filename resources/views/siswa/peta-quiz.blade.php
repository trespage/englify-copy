@extends('layouts.siswa')

@section('title', 'Peta Quiz')

@section('content')
<div class="space-y-6">

    <!-- ===================================================== -->
    <!-- HEADER WITH CAT MASCOT                                 -->
    <!-- ===================================================== -->
    <div class="bg-gradient-to-br from-[#D6EBEE] via-[#97CADB]/30 to-white rounded-2xl p-6 relative overflow-hidden border border-[#97CADB]/50">
        <div class="absolute top-4 right-40 text-[#018ABE]/20 text-xs opacity-60"></div>
        <div class="absolute bottom-4 right-48 text-[#02457A]/20 text-xs opacity-60">✦</div>
        <div class="absolute top-8 right-20 text-[#018ABE]/20 text-xs opacity-60">✨</div>

        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-white/80 backdrop-blur flex items-center justify-center shrink-0 shadow-sm">
                <svg class="w-7 h-7 text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>

            <div class="flex-1 min-w-0">
                <h1 class="text-2xl font-extrabold text-[#001B48] leading-tight">Peta Quiz</h1>
                <p class="text-slate-600 text-sm mt-1">Lihat urutan quiz per bab, nilai, waktu, dan status pengerjaanmu.</p>
            </div>

            <div class="hidden sm:flex items-center gap-3 shrink-0">
                <div class="text-right">
                    <p class="font-cute text-lg text-[#02457A] leading-tight transform -rotate-2">Sedikit demi sedikit,</p>
                    <p class="font-cute text-lg text-[#02457A] leading-tight transform -rotate-2">lama-lama jadi</p>
                    <p class="font-cute text-lg text-[#02457A] leading-tight transform -rotate-2">bisa! ✨</p>
                </div>
                <img src="{{ asset('images/cat-welcome.png') }}" alt="Englify Cat" class="w-24 h-auto object-contain">
            </div>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- STATS CARDS (RINGKASAN DI ATAS)                        -->
    <!-- ===================================================== -->
    @php
        $totalProgress = $totalQuiz > 0 ? round(($quizSelesai / $totalQuiz) * 100) : 0;
    @endphp
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <!-- Materi Selesai -->
        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-[#97CADB]/30 shadow-sm hover:shadow-md transition">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-[#D6EBEE] flex items-center justify-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
            <p class="text-[11px] sm:text-xs font-semibold text-slate-500">Materi Selesai</p>
            <p class="text-xl sm:text-2xl font-extrabold text-[#001B48] mt-1">{{ $materiSelesai }} <span class="text-xs text-slate-400">/ {{ $totalMateri }}</span></p>
        </div>

        <!-- Quiz Selesai -->
        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-[#97CADB]/30 shadow-sm hover:shadow-md transition">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-[11px] sm:text-xs font-semibold text-slate-500">Quiz Selesai</p>
            <p class="text-xl sm:text-2xl font-extrabold text-emerald-600 mt-1">{{ $quizSelesai }} <span class="text-xs text-slate-400">/ {{ $totalQuiz }}</span></p>
        </div>

        <!-- Rata-rata Nilai -->
        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-[#97CADB]/30 shadow-sm hover:shadow-md transition">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
            <p class="text-[11px] sm:text-xs font-semibold text-slate-500">Rata-rata Nilai</p>
            <p class="text-xl sm:text-2xl font-extrabold text-amber-600 mt-1">{{ round($rataRataNilai) }}%</p>
        </div>

        <!-- Progress Bar -->
        <div class="bg-gradient-to-br from-[#018ABE] to-[#02457A] rounded-2xl p-3.5 sm:p-5 text-white shadow-lg shadow-[#018ABE]/30">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
            </div>
            <p class="text-[11px] sm:text-xs font-semibold text-white/90">Total Progress</p>
            <p class="text-xl sm:text-2xl font-extrabold text-white mt-1">{{ $totalProgress }}%</p>
            <div class="w-full h-1.5 bg-white/20 rounded-full overflow-hidden mt-2">
                <div class="h-full bg-white rounded-full" style="width: {{ $totalProgress }}%"></div>
            </div>
        </div>
    </div>

    <!-- TABS FILTER KATEGORI -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-hide" style="-webkit-overflow-scrolling: touch;">
        <button type="button" 
                data-cat="all"
                onclick="filterPetaKategori('all', this)" 
                class="peta-filter-btn px-4 py-2 rounded-xl text-xs whitespace-nowrap shadow-sm transition bg-gradient-to-r from-[#02457A] to-[#018ABE] border-2 border-[#018ABE]/40 text-white shadow-sm shadow-[#018ABE]/25 ring-2 ring-[#018ABE]/30 ring-offset-1 font-extrabold">
            Semua Kategori
        </button>
        @foreach($kategoriList as $kat)
            @php 
                $c = $kat->color; 
                $catKey = strtolower($kat->nama_kategori);
            @endphp
            <button type="button" 
                    data-cat="{{ $catKey }}"
                    onclick="filterPetaKategori('{{ $kat->nama_kategori }}', this)" 
                    class="peta-filter-btn px-4 py-2 bg-white border {{ $c['border'] }} {{ $c['text'] }} hover:bg-slate-50 rounded-xl text-xs font-bold whitespace-nowrap shadow-sm transition flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full {{ $c['bg'] }}"></span>
                {{ $kat->nama_kategori }}
            </button>
        @endforeach
    </div>

    <!-- ===================================================== -->
    <!-- QUIZ MAP (FULL WIDTH - 3/4) + SIDEBAR (1/4)            -->
    <!-- ===================================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 sm:gap-6">

        <!-- QUIZ MAP (3/4) -->
        <div class="lg:col-span-3 space-y-4">
            @forelse($babs as $bab)
                @php
                    $kat = $bab->kategori->nama_kategori ?? '';
                    $totalQuizBab = $bab->quizzes->count();
                    $selesaiBabCount = $bab->quizzes->filter(fn($q) => $q->hasilQuiz->isNotEmpty())->count();

                    $headerGradient = 'from-[#D6EBEE] to-white';
                    $iconBg = 'bg-[#97CADB]/30';
                    $iconColor = 'text-[#018ABE]';

                    if ($kat == 'Speaking') {
                        $headerGradient = 'from-rose-50 to-white';
                        $iconBg = 'bg-rose-100';
                        $iconColor = 'text-rose-600';
                    } elseif ($kat == 'Writing') {
                        $headerGradient = 'from-blue-50 to-white';
                        $iconBg = 'bg-blue-100';
                        $iconColor = 'text-blue-600';
                    } elseif ($kat == 'Reading') {
                        $headerGradient = 'from-emerald-50 to-white';
                        $iconBg = 'bg-emerald-100';
                        $iconColor = 'text-emerald-600';
                    } elseif ($kat == 'Listening') {
                        $headerGradient = 'from-purple-50 to-white';
                        $iconBg = 'bg-purple-100';
                        $iconColor = 'text-purple-600';
                    }
                @endphp

                <div class="peta-bab-card bg-white rounded-2xl border border-[#97CADB]/30 shadow-sm overflow-hidden" data-category="{{ $kat }}">
                    <div class="px-4 sm:px-6 py-3.5 sm:py-4 border-b border-slate-100 bg-gradient-to-r {{ $headerGradient }}">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 sm:gap-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl {{ $iconBg }} flex items-center justify-center shrink-0">
                                    @if($kat == 'Writing')
                                        <svg class="w-5 h-5 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    @elseif($kat == 'Speaking')
                                        <svg class="w-5 h-5 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                    @elseif($kat == 'Reading')
                                        <svg class="w-5 h-5 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
                                        </svg>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <h3 class="font-bold text-[#001B48] text-base sm:text-lg truncate">Bab {{ $bab->urutan }} - {{ $bab->judul }}</h3>
                                    <p class="text-xs text-slate-500">{{ $kat ?: 'English Lesson' }}</p>
                                </div>
                            </div>
                            @php
                                $totalMateriBab = $bab->materi->count();
                                $selesaiBabCount = $bab->materi->filter(fn($m) => $m->sudah_selesai)->count();
                            @endphp
                            <div class="flex items-center gap-1.5 px-3 py-1.5 {{ $selesaiBabCount > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }} text-xs font-bold rounded-full self-start sm:self-center shrink-0">
                                @if($selesaiBabCount > 0)
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @endif
                                <span>{{ $selesaiBabCount }}/{{ $totalMateriBab }} Selesai</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-3.5 sm:p-6">
                        <div class="flex items-center justify-start overflow-x-auto pb-3 gap-2.5 sm:gap-3 scrollbar-hide" style="-webkit-overflow-scrolling: touch;">
                            @forelse($bab->materi as $materi)
                                @php
                                    $isSelesai = $materi->sudah_selesai;
                                    $isLocked = $materi->is_locked ?? false;
                                    $lockedBy = $materi->locked_by ?? 'sebelumnya';
                                    $hasQuiz = $materi->total_soal > 0;
                                    $skor = $materi->skor_diperoleh;
                                    $modalData = [
                                        'id_materi'     => $materi->id_materi,
                                        'judul_materi'  => $materi->judul,
                                        'bab_judul'     => 'Bab ' . $bab->urutan . ' – ' . $bab->judul,
                                        'kategori'      => $kat,
                                        'total_soal'    => $materi->total_soal,
                                        'total_poin'    => $materi->total_poin,
                                        'durasi_menit'  => (int) ($materi->durasi_menit ?? $bab->durasi_menit ?? 15),
                                        'sudah_selesai' => $materi->sudah_selesai,
                                        'sudah_dibaca'  => (bool) ($materi->sudah_dibaca ?? false),
                                        'is_locked'     => $isLocked,
                                        'locked_by'     => $lockedBy,
                                        'skor'          => $materi->skor_diperoleh,
                                        'waktu_selesai' => $materi->waktu_selesai,
                                        'url_materi'    => $isLocked ? null : route('siswa.materi.baca', $materi->id_materi),
                                        'url_quiz'      => ($isLocked || $isSelesai || !$materi->target_quiz_id) ? null : route('siswa.quiz.kerjakan', $materi->target_quiz_id),
                                        'url_hasil'     => $materi->target_quiz_id ? route('siswa.quiz.hasil', $materi->target_quiz_id) : null,
                                    ];
                                @endphp

                                <div onclick="openQuizDetailModal(this)" 
                                     data-quiz='@json($modalData)'
                                     class="flex flex-col items-center gap-2 cursor-pointer group shrink-0 min-w-[105px] text-center" 
                                     title="Klik untuk melihat total & hasil quiz: {{ $materi->judul }}">
                                    <div class="relative">
                                        @if($isSelesai)
                                            <!-- Selesai (Emerald) -->
                                            <div class="w-14 h-14 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition transform">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </div>
                                            <div class="absolute -top-1 -right-1 w-5 h-5 bg-emerald-700 rounded-full flex items-center justify-center border-2 border-white">
                                                <span class="text-[9px] font-bold text-white">{{ $loop->iteration }}</span>
                                            </div>
                                        @elseif($isLocked)
                                            <!-- Terkunci (Locked) -->
                                            <div class="w-14 h-14 rounded-full bg-slate-100 border-2 border-slate-300 flex items-center justify-center text-slate-400 group-hover:scale-105 transition shadow-xs">
                                                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                            </div>
                                            <div class="absolute -top-1 -right-1 w-5 h-5 bg-slate-400 rounded-full flex items-center justify-center border-2 border-white">
                                                <span class="text-[9px] font-bold text-white">{{ $loop->iteration }}</span>
                                            </div>
                                        @elseif($hasQuiz)
                                            <!-- Tersedia tapi belum dikerjakan (Blue Englify) -->
                                            <div class="w-14 h-14 rounded-full bg-white border-2 border-[#018ABE] flex items-center justify-center group-hover:bg-[#018ABE] group-hover:text-white transition shadow-xs group-hover:scale-110">
                                                <span class="text-lg font-extrabold text-[#018ABE] group-hover:text-white">{{ $loop->iteration }}</span>
                                            </div>
                                        @else
                                            <!-- Materi belum ada kuis -->
                                            <div class="w-14 h-14 rounded-full bg-slate-100 border-2 border-slate-300 flex items-center justify-center text-slate-400 group-hover:scale-105 transition">
                                                <span class="text-lg font-bold text-slate-400">{{ $loop->iteration }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="text-center w-full px-1">
                                        <p class="text-xs font-bold {{ $isLocked ? 'text-slate-500' : 'text-slate-800' }} truncate" title="{{ $materi->judul }}">{{ $materi->judul }}</p>
                                        @if($isSelesai)
                                            <p class="text-[11px] font-extrabold text-emerald-600">{{ $skor }}/100</p>
                                            <p class="text-[9px] text-slate-400">Selesai</p>
                                        @elseif($isLocked)
                                            <p class="text-[11px] font-bold text-amber-600">Terkunci</p>
                                            <p class="text-[9px] text-slate-400">🔒 Kuis</p>
                                        @elseif($hasQuiz)
                                            <p class="text-[11px] font-bold text-[#018ABE]">{{ $materi->total_soal }} Soal</p>
                                            <p class="text-[9px] text-slate-400">Siap Dikerjakan</p>
                                        @else
                                            <p class="text-[10px] text-slate-400 italic">Belum ada kuis</p>
                                        @endif
                                    </div>
                                </div>

                                @if(!$loop->last)
                                    <div class="flex-1 h-1 bg-slate-200 mx-1 relative min-w-[20px] max-w-[70px] rounded-full self-center -mt-6">
                                        @if($isSelesai)
                                            <div class="absolute inset-0 bg-gradient-to-r from-emerald-400 to-emerald-500 rounded-full" style="width: 100%"></div>
                                        @endif
                                    </div>
                                @endif
                            @empty
                                <p class="text-sm text-slate-400 py-3 text-center w-full">Belum ada materi untuk bab ini.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-[#97CADB]/30 p-12 text-center">
                    <p class="text-slate-400 text-sm">Belum ada bab quiz yang tersedia.</p>
                </div>
            @endforelse
        </div>

        <!-- SIDEBAR KANAN (1/4) - Motivasi & Tips -->
        <div class="lg:col-span-1 space-y-4">
            <!-- Motivasi Card -->
            <div class="bg-gradient-to-br from-[#018ABE] to-[#02457A] rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 opacity-10 -mr-8 -mt-8">
                    <svg viewBox="0 0 200 200" class="w-full h-full text-white" fill="currentColor">
                        <circle cx="100" cy="60" r="40"/>
                        <circle cx="60" cy="140" r="35"/>
                        <circle cx="140" cy="140" r="35"/>
                    </svg>
                </div>
                <div class="relative">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-2xl">🌟</span>
                        <p class="text-xs font-bold uppercase tracking-wider text-white/90">Pencapaianmu</p>
                    </div>
                    <p class="font-cute text-xl text-white leading-tight mb-3">
                        Kamu sudah melangkah jauh! Terus semangat belajarnya! 💜
                    </p>
                    <p class="text-xs text-white/80 leading-relaxed">
                        Jangan lupa untuk mengulang materi yang masih belum kamu pahami ya!
                    </p>
                </div>
            </div>

            <!-- Tips Card -->
            <div class="bg-white rounded-2xl border border-[#97CADB]/30 shadow-sm p-6">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-[#001B48]">Tips Hari Ini</p>
                        <p class="text-[10px] text-slate-500">Untuk belajar lebih efektif</p>
                    </div>
                </div>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Coba ulangi materi yang masih belum kamu pahami agar hasil quiz berikutnya bisa lebih baik! Jangan ragu untuk bertanya pada guru atau teman jika ada yang kurang jelas. 💪
                </p>
            </div>

            <!-- Cat Mascot -->
            <div class="bg-gradient-to-br from-[#D6EBEE] to-white rounded-2xl p-5 border border-[#97CADB]/50 text-center">
                <img src="{{ asset('images/cat-welcome.png') }}" alt="Englify Cat" class="w-24 h-auto mx-auto mb-2">
                <p class="font-cute text-lg text-[#02457A] leading-tight">Good Job!</p>
                <p class="text-xs text-slate-500 mt-1">Terus semangat belajar ya! ✨</p>
            </div>
        </div>
    </div>

</div>

<!-- ============================================================== -->
<!-- MODAL DETAIL & HASIL QUIZ PER MATERI                           -->
<!-- ============================================================== -->
@include('siswa.quiz.modal-detail')
@endsection

@push('scripts')
<script>
const petaStyleMap = {
    'speaking': {
        active: ['bg-rose-100', 'border-rose-600', 'border-2', 'text-rose-900', 'ring-2', 'ring-rose-300', 'ring-offset-1', 'font-extrabold'],
        inactive: ['bg-white', 'border', 'border-rose-500', 'text-rose-600', 'font-bold']
    },
    'writing': {
        active: ['bg-blue-100', 'border-blue-600', 'border-2', 'text-blue-900', 'ring-2', 'ring-blue-300', 'ring-offset-1', 'font-extrabold'],
        inactive: ['bg-white', 'border', 'border-blue-500', 'text-blue-600', 'font-bold']
    },
    'reading': {
        active: ['bg-emerald-100', 'border-emerald-600', 'border-2', 'text-emerald-900', 'ring-2', 'ring-emerald-300', 'ring-offset-1', 'font-extrabold'],
        inactive: ['bg-white', 'border', 'border-emerald-500', 'text-emerald-600', 'font-bold']
    },
    'listening': {
        active: ['bg-purple-100', 'border-purple-600', 'border-2', 'text-purple-900', 'ring-2', 'ring-purple-300', 'ring-offset-1', 'font-extrabold'],
        inactive: ['bg-white', 'border', 'border-purple-500', 'text-purple-600', 'font-bold']
    },
    'all': {
        active: ['bg-gradient-to-r', 'from-[#02457A]', 'to-[#018ABE]', 'border-2', 'border-[#018ABE]/40', 'text-white', 'shadow-sm', 'shadow-[#018ABE]/25', 'ring-2', 'ring-[#018ABE]/30', 'ring-offset-1', 'font-extrabold'],
        inactive: ['bg-white', 'border', 'border-slate-300', 'text-slate-700', 'font-bold']
    }
};

function filterPetaKategori(category, btn) {
    const targetKey = (category || 'all').toLowerCase();

    // Reset all buttons to inactive styles
    document.querySelectorAll('.peta-filter-btn').forEach(b => {
        const k = (b.dataset.cat || 'all').toLowerCase();
        const conf = petaStyleMap[k] || petaStyleMap['all'];
        b.classList.remove(...conf.active);
        b.classList.add(...conf.inactive);
    });

    // Apply active styles to clicked button
    const activeConf = petaStyleMap[targetKey] || petaStyleMap['all'];
    btn.classList.remove(...activeConf.inactive);
    btn.classList.add(...activeConf.active);

    const cards = document.querySelectorAll('.peta-bab-card');
    cards.forEach(card => {
        const cat = (card.dataset.category || '').toLowerCase();
        if (targetKey === 'all' || cat === targetKey) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>
@endpush
