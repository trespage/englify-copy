@extends('layouts.siswa')

@section('title', 'Hasil Quiz — ' . ($quiz->materi->judul ?? $quiz->judul ?? 'Quiz'))

@section('content')
<div class="max-w-5xl mx-auto space-y-6 pb-12">

    <!-- ===================================================== -->
    <!-- TOP NAVIGATION & BREADCRUMB                           -->
    <!-- ===================================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('siswa.peta-quiz') }}" 
               class="w-10 h-10 rounded-xl bg-white border border-[#97CADB]/40 hover:bg-[#D6EBEE]/50 hover:border-[#018ABE] text-slate-600 hover:text-[#018ABE] transition flex items-center justify-center shadow-xs"
               title="Kembali ke Peta Quiz">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <div class="flex items-center gap-2">
                    @php
                        $kategoriNama = $quiz->materi?->kategori?->nama_kategori ?? $quiz->bab?->kategori?->nama_kategori ?? 'Quiz';
                        $kategoriColor = match(strtolower($kategoriNama)) {
                            'speaking' => 'bg-rose-50 text-rose-700 border-rose-200',
                            'writing'  => 'bg-blue-50 text-blue-700 border-blue-200',
                            'reading'  => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'listening'=> 'bg-amber-50 text-amber-700 border-amber-200',
                            default    => 'bg-sky-50 text-[#018ABE] border-[#97CADB]/40'
                        };
                    @endphp
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold border {{ $kategoriColor }}">
                        {{ $kategoriNama }}
                    </span>
                    <span class="text-xs font-semibold text-slate-400">
                        {{ $quiz->materi?->babModel?->judul ?? ($quiz->materi?->bab ? 'Bab ' . $quiz->materi->bab : ($quiz->bab?->judul ?? '')) }}
                    </span>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-[#001B48] mt-0.5">
                    Hasil Quiz: {{ $quiz->materi->judul ?? $quiz->judul ?? 'Pembelajaran' }}
                </h1>
            </div>
        </div>

        <div class="flex items-center gap-2 self-start sm:self-auto">
            <button type="button" onclick="openCelebrationModal()" 
                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-gradient-to-r from-amber-400 to-orange-500 hover:from-amber-500 hover:to-orange-600 text-white text-xs font-bold shadow-md shadow-amber-400/25 transition hover:scale-105 cursor-pointer">
                <span>🎉 Putar Perayaan</span>
            </button>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 border border-emerald-200 text-xs font-bold text-emerald-700 shadow-2xs">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Sudah Diselesaikan</span>
            </span>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- FLASH MESSAGES                                        -->
    <!-- ===================================================== -->
    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-2xl flex items-center gap-3 shadow-xs animate-fade-in">
        <div class="w-9 h-9 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div class="flex-1">
            <p class="text-sm font-bold">{{ session('success') }}</p>
            <p class="text-xs text-emerald-700">Hasil quiz kamu telah tersimpan ke dalam catatan progress akun.</p>
        </div>
    </div>
    @endif

    @if(session('info'))
    <div class="p-4 bg-sky-50 border border-[#97CADB]/50 text-[#02457A] rounded-2xl flex items-center gap-3 shadow-xs">
        <div class="w-9 h-9 rounded-xl bg-[#018ABE] text-white flex items-center justify-center shrink-0 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <p class="text-xs sm:text-sm font-semibold">{{ session('info') }}</p>
    </div>
    @endif

    <!-- ===================================================== -->
    <!-- CELEBRATORY RESULT HERO BANNER                         -->
    <!-- ===================================================== -->
    @php
        $skor = (int) ($hasil?->skor_diperoleh ?? 0);
        $totalSoal = isset($totalSoal) && $totalSoal > 0 ? $totalSoal : ($soal->count() ?: 1);
        $benarCount = $jawaban->isNotEmpty() 
            ? $jawaban->where('benar', true)->count() 
            : (int) round(($skor / 100) * $totalSoal);
        $salahCount = max(0, $totalSoal - $benarCount);
        $akurasi = $totalSoal > 0 ? round(($benarCount / $totalSoal) * 100) : 0;

        if ($skor >= 90) {
            $badgeTitle = "Nilai Sempurna! 🌟";
            $badgeDesc = "Kemampuan bahasa Inggrismu pada materi ini sangat luar biasa!";
            $badgeColor = "from-amber-400 to-amber-500 text-white shadow-amber-500/30";
        } elseif ($skor >= 75) {
            $badgeTitle = "Sangat Memuaskan! 🎉";
            $badgeDesc = "Kerja bagus! Kamu memahami hampir seluruh konsep pada materi ini.";
            $badgeColor = "from-emerald-400 to-teal-500 text-white shadow-emerald-500/30";
        } elseif ($skor >= 60) {
            $badgeTitle = "Bagus Sekali! 👍";
            $badgeDesc = "Kamu sudah berhasil lulus kuis ini. Jangan ragu baca lagi materinya agar makin mahir.";
            $badgeColor = "from-[#018ABE] to-[#02457A] text-white shadow-[#018ABE]/30";
        } else {
            $badgeTitle = "Terus Berlatih! 💪";
            $badgeDesc = "Setiap langkah adalah proses. Pelajari kembali materi bacaan untuk memperkuat pemahamanmu.";
            $badgeColor = "from-rose-400 to-rose-500 text-white shadow-rose-500/30";
        }
    @endphp

    <div class="relative rounded-3xl bg-gradient-to-br from-[#001B48] via-[#02457A] to-[#018ABE] text-white p-4 sm:p-9 shadow-xl shadow-[#02457A]/25 overflow-hidden">
        
        <!-- Decorative Glow Orbs -->
        <div class="absolute -top-12 -right-12 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-12 -left-12 w-64 h-64 bg-[#018ABE]/30 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6 sm:gap-8">
            
            <!-- Left Info -->
            <div class="space-y-3 sm:space-y-4 text-center md:text-left flex-1">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-xs font-bold text-sky-100">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Quiz Telah Dinilai</span>
                </div>

                <div>
                    <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight font-display text-white">
                        {{ $badgeTitle }}
                    </h2>
                    <p class="text-sky-100/90 text-xs sm:text-base mt-1.5 sm:mt-2 max-w-xl leading-relaxed">
                        {{ $badgeDesc }}
                    </p>
                </div>

                <!-- Quick Stats Badges -->
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 pt-1 sm:pt-2">
                    <span class="px-2.5 sm:px-3.5 py-1 sm:py-1.5 rounded-xl bg-white/10 backdrop-blur border border-white/15 text-[11px] sm:text-xs font-semibold text-white flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ $benarCount }} Benar</span>
                    </span>
                    <span class="px-2.5 sm:px-3.5 py-1 sm:py-1.5 rounded-xl bg-white/10 backdrop-blur border border-white/15 text-[11px] sm:text-xs font-semibold text-white flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-rose-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        <span>{{ $salahCount }} Salah</span>
                    </span>
                    <span class="px-2.5 sm:px-3.5 py-1 sm:py-1.5 rounded-xl bg-white/10 backdrop-blur border border-white/15 text-[11px] sm:text-xs font-semibold text-white flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <span>Akurasi {{ $akurasi }}%</span>
                    </span>
                </div>
            </div>

            <!-- Right Circular Score Card with Cat Mascot -->
            <div class="flex items-center gap-4 shrink-0">
                <div class="bg-white/10 backdrop-blur-md rounded-2xl sm:rounded-3xl p-4 sm:p-5 border border-white/20 text-center shadow-xl shadow-black/10 min-w-[140px] sm:min-w-[170px]">
                    <span class="text-[10px] sm:text-[11px] font-bold uppercase tracking-wider text-sky-200 block mb-1">Skor Diperoleh</span>
                    <div class="text-4xl sm:text-6xl font-extrabold tracking-tight font-display text-white">
                        {{ $skor }}
                    </div>
                    <span class="text-[10px] sm:text-xs font-semibold text-sky-100/80 block mt-1">Skala 100 Poin</span>
                    <div class="mt-2.5 sm:mt-3 pt-2.5 sm:pt-3 border-t border-white/15">
                        <span class="inline-block px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-extrabold bg-gradient-to-r {{ $badgeColor }} shadow-md">
                            {{ $skor >= 75 ? 'Lulus Kompetensi' : 'Selesai Dikerjakan' }}
                        </span>
                    </div>
                </div>

                <!-- Peeking Cat Mascot -->
                <div class="relative shrink-0 hidden sm:block">
                    <img src="{{ asset('images/cat-welcome.png') }}" alt="Englify Cat" class="w-24 sm:w-28 h-auto object-contain drop-shadow-xl animate-float">
                </div>
            </div>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- 4 KEY STATS CARDS                                     -->
    <!-- ===================================================== -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        
        <!-- 1. Skor Akhir -->
        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-[#97CADB]/35 shadow-xs flex items-center gap-2.5 sm:gap-3.5">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-gradient-to-br from-[#018ABE] to-[#02457A] text-white flex items-center justify-center shrink-0 shadow-md shadow-[#018ABE]/20">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] sm:text-[11px] font-bold uppercase tracking-wider text-slate-400 truncate">Total Skor</p>
                <p class="text-xl sm:text-2xl font-extrabold text-[#001B48] leading-tight">{{ $skor }}<span class="text-[10px] sm:text-xs text-slate-400 font-normal"> / 100</span></p>
            </div>
        </div>

        <!-- 2. Soal Benar -->
        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-[#97CADB]/35 shadow-xs flex items-center gap-2.5 sm:gap-3.5">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-200 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] sm:text-[11px] font-bold uppercase tracking-wider text-slate-400 truncate">Jawaban Benar</p>
                <p class="text-xl sm:text-2xl font-extrabold text-emerald-700 leading-tight">{{ $benarCount }} <span class="text-[10px] sm:text-xs text-slate-400 font-normal">/ {{ $totalSoal }}</span></p>
            </div>
        </div>

        <!-- 3. Tingkat Akurasi -->
        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-[#97CADB]/35 shadow-xs flex items-center gap-2.5 sm:gap-3.5">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-[#D6EBEE] text-[#02457A] border border-[#97CADB]/40 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] sm:text-[11px] font-bold uppercase tracking-wider text-slate-400 truncate">Akurasi</p>
                <p class="text-xl sm:text-2xl font-extrabold text-[#02457A] leading-tight">{{ $akurasi }}%</p>
            </div>
        </div>

        <!-- 4. Waktu Penyelesaian -->
        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-[#97CADB]/35 shadow-xs flex items-center gap-2.5 sm:gap-3.5">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-amber-50 text-amber-600 border border-amber-200 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] sm:text-[11px] font-bold uppercase tracking-wider text-slate-400 truncate">Selesai Pada</p>
                <p class="text-xs sm:text-sm font-bold text-slate-800 leading-snug truncate">{{ $hasil?->created_at?->format('d M Y') ?? 'Hari Ini' }}</p>
                <p class="text-[10px] text-slate-400">{{ $hasil?->created_at?->format('H:i') ?? '-' }} WIB</p>
            </div>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- DETAIL JAWABAN & REVIEW SOAL                           -->
    <!-- (Hanya Ditampilkan 1 Kali Sesaat Setelah Selesai Kuis) -->
    <!-- ===================================================== -->
    @if(!empty($canReview) && $jawaban->isNotEmpty())
    <div id="reviewJawabanSection" class="bg-white rounded-3xl border border-[#97CADB]/35 shadow-sm p-4 sm:p-8 space-y-4 sm:space-y-6">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-4 border-b border-slate-100 gap-2">
            <div>
                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold mb-1">
                    <span>👁️ Review Sesi Ini (1 Kali)</span>
                </div>
                <h3 class="text-lg font-extrabold text-[#001B48] flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span>Pembahasan &amp; Review Jawaban</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Tinjau jawaban kamu untuk memperdalam pemahaman materi bahasa Inggris ini sebelum meninggalkan halaman.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold px-3 py-1 bg-slate-50 text-slate-600 rounded-full border border-slate-200">
                    Total {{ $totalSoal }} Pertanyaan
                </span>
            </div>
        </div>

        <div class="space-y-4">
            @foreach($soal as $index => $pertanyaan)
                @php
                    $jawabanSiswa = $jawaban->firstWhere('id_quiz', $pertanyaan->id_quiz);
                    $isBenar = $jawabanSiswa && $jawabanSiswa->benar;
                    $userKey = $jawabanSiswa ? strtoupper(trim($jawabanSiswa->jawaban_user)) : null;
                    $correctKey = strtoupper(trim($pertanyaan->kunci_jawaban));
                @endphp

                <div class="rounded-2xl border transition-all duration-200 overflow-hidden {{ $isBenar ? 'border-emerald-200 bg-emerald-50/20' : 'border-rose-200 bg-rose-50/20' }}">
                    
                    <!-- Question Header -->
                    <div class="p-4 sm:p-5">
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <div class="flex items-center gap-2.5">
                                <span class="w-7 h-7 rounded-lg text-xs font-extrabold flex items-center justify-center {{ $isBenar ? 'bg-emerald-600 text-white' : 'bg-rose-500 text-white' }}">
                                    {{ $loop->iteration }}
                                </span>
                                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    Soal {{ $loop->iteration }}
                                </span>
                            </div>

                            @if($isBenar)
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span>Benar</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-200">
                                    <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                    <span>Kurang Tepat</span>
                                </span>
                            @endif
                        </div>

                        <!-- Pertanyaan -->
                        <p class="text-sm sm:text-base font-bold text-[#001B48] leading-relaxed">
                            {{ $pertanyaan->pertanyaan }}
                        </p>

                        <!-- Pilihan Jawaban Lengkap -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 mt-4 pt-3 border-t border-slate-100/80">
                            @foreach(['A', 'B', 'C', 'D'] as $optKey)
                                @php
                                    $field = 'pilihan_' . strtolower($optKey);
                                    $text = $pertanyaan->$field;
                                    if (!$text) continue;

                                    $isUserChoice = ($userKey === $optKey);
                                    $isCorrectAnswer = ($correctKey === $optKey);

                                    // Dynamic styling based on options
                                    if ($isCorrectAnswer) {
                                        $pillClass = "bg-emerald-50 border-emerald-300 text-emerald-900 font-semibold ring-1 ring-emerald-400";
                                        $badgeText = $isUserChoice ? "Jawaban Kamu (Benar) ✓" : "Kunci Jawaban ✓";
                                        $badgeStyle = "bg-emerald-600 text-white";
                                    } elseif ($isUserChoice && !$isBenar) {
                                        $pillClass = "bg-rose-50 border-rose-300 text-rose-900 font-semibold ring-1 ring-rose-400";
                                        $badgeText = "Jawaban Kamu ✗";
                                        $badgeStyle = "bg-rose-600 text-white";
                                    } else {
                                        $pillClass = "bg-white border-slate-200 text-slate-700 hover:bg-slate-50";
                                        $badgeText = null;
                                        $badgeStyle = "";
                                    }
                                @endphp

                                <div class="p-3 rounded-xl border {{ $pillClass }} flex items-center justify-between gap-2 text-xs transition">
                                    <div class="flex items-center gap-2.5">
                                        <span class="w-6 h-6 rounded-md bg-slate-100 text-slate-700 font-bold flex items-center justify-center shrink-0 text-xs">
                                            {{ $optKey }}
                                        </span>
                                        <span class="leading-snug">{{ $text }}</span>
                                    </div>
                                    @if($badgeText)
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold shrink-0 {{ $badgeStyle }}">
                                            {{ $badgeText }}
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- ===================================================== -->
    <!-- ENGLIFY CAT MASCOT CARD                               -->
    <!-- ===================================================== -->
    <div class="bg-gradient-to-br from-[#D6EBEE] via-white to-[#97CADB]/30 rounded-3xl p-4 sm:p-7 border border-[#97CADB]/40 shadow-xs flex flex-col sm:flex-row items-center gap-4 sm:gap-5">
        <img src="{{ asset('images/cat-welcome.png') }}" alt="Englify Cat" class="w-20 sm:w-28 h-auto shrink-0 drop-shadow-md">
        <div class="space-y-1.5 text-center sm:text-left">
            <div class="inline-flex items-center gap-1.5 px-3 py-0.5 sm:py-1 rounded-full bg-[#018ABE]/15 text-[#02457A] text-[11px] sm:text-xs font-bold">
                <span>🐾 Cat Mascot Buddy</span>
            </div>
            <p class="font-cute text-xl sm:text-3xl text-[#018ABE] leading-tight">
                @if($skor >= 80)
                    "Good Job, Amazing Learner! 🎉"
                @elseif($skor >= 60)
                    "Great Effort! You're Doing Well! ✨"
                @else
                    "Never Give Up! Keep Practicing! 💪"
                @endif
            </p>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-2xl">
                @if($skor >= 80)
                    Luar biasa! Kamu menguasai materi ini dengan sangat baik. Ayo lanjutkan perjalananmu ke materi bab berikutnya di peta kuis!
                @elseif($skor >= 60)
                    Hasil yang cukup bagus! Masih ada beberapa konsep yang bisa kamu perdalam lagi dengan membaca ulang materi pembelajaran.
                @else
                    Jangan berkecil hati! Proses belajar membutuhkan ketekunan. Buka kembali materi pembelajarannya dan pahami poin-poin utamanya ya!
                @endif
            </p>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- ACTION BUTTONS                                        -->
    <!-- ===================================================== -->
    <div class="flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 pt-2">
        <a href="{{ route('siswa.peta-quiz') }}" 
           class="w-full sm:flex-1 py-3 sm:py-3.5 px-5 sm:px-6 rounded-2xl bg-gradient-to-r from-[#018ABE] to-[#02457A] hover:from-[#02457A] hover:to-[#001B48] text-white text-xs sm:text-sm font-bold transition-all shadow-lg shadow-[#018ABE]/25 flex items-center justify-center gap-2 hover:-translate-y-0.5 cursor-pointer">
            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            <span>Kembali ke Peta Quiz</span>
        </a>

        @if($quiz->id_materi)
        <a href="{{ route('siswa.materi.baca', $quiz->id_materi) }}" 
           class="w-full sm:w-auto py-3 sm:py-3.5 px-5 sm:px-6 rounded-2xl bg-white border border-[#97CADB]/50 hover:bg-[#D6EBEE]/50 text-slate-700 hover:text-[#018ABE] text-xs sm:text-sm font-bold transition flex items-center justify-center gap-2 shadow-xs cursor-pointer">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <span>Baca Lagi Materi</span>
        </a>
        @endif

        <a href="{{ route('siswa.progres') }}" 
           class="w-full sm:w-auto py-3 sm:py-3.5 px-5 sm:px-6 rounded-2xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs sm:text-sm font-bold transition flex items-center justify-center gap-2 shadow-xs cursor-pointer">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <span>Lihat Progress</span>
        </a>
    </div>

</div>

<!-- ===================================================== -->
<!-- POPUP SELEBRASI & SAMBUTAN SELESAI KUIS               -->
<!-- ===================================================== -->
<div id="celebrationModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 bg-[#001B48]/65 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
    <div id="celebrationCard" class="relative w-full max-w-md bg-white rounded-3xl p-5 sm:p-7 text-center shadow-2xl border border-[#97CADB]/60 transform scale-95 transition-all duration-300 max-h-[90vh] overflow-y-auto">
        
        <!-- Glowing Ambient Circles (dibatasi overflow-hidden agar tidak menambah ruang kosong di bawah card) -->
        <div class="absolute inset-0 rounded-3xl overflow-hidden pointer-events-none -z-0">
            <div class="absolute -top-12 -right-12 w-44 h-44 bg-amber-300/25 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-12 -left-12 w-44 h-44 bg-[#018ABE]/15 rounded-full blur-2xl"></div>
        </div>

        <!-- Tombol Tutup X -->
        <button type="button" onclick="closeCelebrationModal()" class="absolute top-3.5 right-3.5 sm:top-4 sm:right-4 z-10 w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-600 flex items-center justify-center transition cursor-pointer" title="Tutup">
            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        <div class="relative z-10">
            <!-- Cat Mascot with Animated Trophy / Sparkles -->
            <div class="relative mx-auto w-24 sm:w-28 mb-3">
                <img src="{{ asset('images/cat-welcome.png') }}" alt="Celebration Cat" class="w-full h-auto object-contain drop-shadow-lg animate-float">
                <div class="absolute -top-1 -right-2 text-xl text-amber-400 animate-pulse">✨</div>
                <div class="absolute top-1/2 -left-2 text-lg text-[#018ABE]">✦</div>
            </div>

            <!-- Dynamic Celebratory Content Based on Score -->
            <div class="space-y-2.5 sm:space-y-3">
                @if($skor >= 90)
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gradient-to-r from-amber-400 to-amber-500 text-white text-xs font-extrabold shadow-sm shadow-amber-400/40">
                        <span>🏆 NILAI SEMPURNA • PERFECT SCORE!</span>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-extrabold text-[#001B48] font-display">
                        Luar Biasa, Hebat Sekali! 🎉
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed px-1 sm:px-2">
                        Selamat! Kamu berhasil menuntaskan seluruh kuis pada materi <strong>"{{ $quiz->materi->judul ?? $quiz->judul ?? 'Materi' }}"</strong> dengan skor sempurna <strong>{{ $skor }}/100</strong>!
                    </p>
                    <div class="bg-[#D6EBEE]/70 border border-[#97CADB]/50 rounded-2xl p-2.5 max-w-sm mx-auto">
                        <p class="font-cute text-lg sm:text-xl text-[#018ABE] leading-snug">
                            "You are an absolute English Champion! Pertahankan prestasimu!" 🐾⭐
                        </p>
                    </div>
                @elseif($skor >= 75)
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-xs font-extrabold shadow-sm shadow-emerald-500/30">
                        <span>🌟 SANGAT MEMUASKAN • GREAT JOB!</span>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-extrabold text-[#001B48] font-display">
                        Kerja Kerasmu Membuahkan Hasil! ✨
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed px-1 sm:px-2">
                        Skor kamu <strong>{{ $skor }}/100</strong>! Kamu memahami hampir seluruh konsep pada materi <strong>"{{ $quiz->materi->judul ?? $quiz->judul ?? 'Materi' }}"</strong>.
                    </p>
                    <div class="bg-[#D6EBEE]/70 border border-[#97CADB]/50 rounded-2xl p-2.5 max-w-sm mx-auto">
                        <p class="font-cute text-lg sm:text-xl text-[#018ABE] leading-snug">
                            "Proud of your progress! Langkahmu sudah sangat mantap!" 🐾🎉
                        </p>
                    </div>
                @elseif($skor >= 60)
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gradient-to-r from-[#018ABE] to-[#02457A] text-white text-xs font-extrabold shadow-sm shadow-[#018ABE]/30">
                        <span>👍 LULUS KOMPETENSI • WELL DONE!</span>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-extrabold text-[#001B48] font-display">
                        Selamat, Kuis Berhasil Selesai! 🎯
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed px-1 sm:px-2">
                        Kamu meraih skor <strong>{{ $skor }}/100</strong>. Perjalanan belajarmu di materi <strong>"{{ $quiz->materi->judul ?? $quiz->judul ?? 'Materi' }}"</strong> telah berhasil dituntaskan.
                    </p>
                    <div class="bg-[#D6EBEE]/70 border border-[#97CADB]/50 rounded-2xl p-2.5 max-w-sm mx-auto">
                        <p class="font-cute text-lg sm:text-xl text-[#018ABE] leading-snug">
                            "Practice makes progress! Jangan ragu baca lagi materinya ya!" 🐾📖
                        </p>
                    </div>
                @else
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gradient-to-r from-amber-400 to-orange-500 text-white text-xs font-extrabold shadow-sm shadow-amber-500/30">
                        <span>💪 TETAP SEMANGAT • KEEP PRACTICING!</span>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-extrabold text-[#001B48] font-display">
                        Kuis Selesai! Terus Belajar! 📚
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed px-1 sm:px-2">
                        Skor kamu <strong>{{ $skor }}/100</strong>. Jangan berkecil hati! Proses belajar adalah perjalanan. Tinjau jawaban yang kurang tepat di bawah untuk belajar lagi.
                    </p>
                    <div class="bg-[#D6EBEE]/70 border border-[#97CADB]/50 rounded-2xl p-2.5 max-w-sm mx-auto">
                        <p class="font-cute text-lg sm:text-xl text-[#018ABE] leading-snug">
                            "Never give up! Setiap kesalahan adalah kesempatan belajar!" 🐾
                        </p>
                    </div>
                @endif
            </div>

            <!-- Tombol Aksi di Modal -->
            <div class="mt-5 pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-center gap-2.5">
                <a href="{{ route('siswa.peta-quiz') }}" 
                   class="w-full sm:flex-1 py-2.5 sm:py-3 px-4 rounded-xl bg-gradient-to-r from-[#018ABE] to-[#02457A] hover:from-[#02457A] hover:to-[#001B48] text-white text-xs sm:text-sm font-bold shadow-md shadow-[#018ABE]/25 transition flex items-center justify-center gap-2">
                    <span>Lanjut ke Peta Quiz</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
                @if(!empty($canReview))
                <button type="button" onclick="closeCelebrationModal(true)" 
                        class="w-full sm:flex-1 py-2.5 sm:py-3 px-4 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs sm:text-sm font-bold transition flex items-center justify-center gap-2 shadow-xs cursor-pointer">
                    <span>Lihat Pembahasan</span>
                </button>
                @else
                <button type="button" onclick="closeCelebrationModal(false)" 
                        class="w-full sm:flex-1 py-2.5 sm:py-3 px-4 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs sm:text-sm font-bold transition flex items-center justify-center gap-2 shadow-xs cursor-pointer">
                    <span>Tutup</span>
                </button>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
<script>
// Supresi toast duplikat di halaman hasil agar fokus ke popup perayaan
window.__suppressGlobalToast = true;

function fireCelebrationConfetti() {
    if (typeof confetti !== 'function') return;

    const count = 200;
    const defaults = { origin: { y: 0.65 } };

    function fire(particleRatio, opts) {
        confetti(Object.assign({}, defaults, opts, {
            particleCount: Math.floor(count * particleRatio)
        }));
    }

    fire(0.25, { spread: 26, startVelocity: 55, colors: ['#018ABE', '#97CADB', '#FFD700', '#10B981'] });
    fire(0.2, { spread: 60, colors: ['#001B48', '#02457A', '#F59E0B', '#3B82F6'] });
    fire(0.35, { spread: 100, decay: 0.91, scalar: 0.8 });
    fire(0.1, { spread: 120, startVelocity: 25, decay: 0.92, colors: ['#10B981', '#F43F5E', '#8B5CF6'] });
    fire(0.1, { spread: 120, startVelocity: 45 });
}

function openCelebrationModal() {
    const modal = document.getElementById('celebrationModal');
    const card = document.getElementById('celebrationCard');
    if (!modal || !card) return;

    modal.classList.remove('opacity-0', 'pointer-events-none');
    modal.classList.add('opacity-100', 'pointer-events-auto');
    card.classList.remove('scale-95');
    card.classList.add('scale-100');

    @if($skor >= 60)
        setTimeout(fireCelebrationConfetti, 150);
    @endif
}

function closeCelebrationModal(scrollToReview = false) {
    const modal = document.getElementById('celebrationModal');
    const card = document.getElementById('celebrationCard');
    if (!modal || !card) return;

    card.classList.remove('scale-100');
    card.classList.add('scale-95');
    modal.classList.remove('opacity-100', 'pointer-events-auto');
    modal.classList.add('opacity-0', 'pointer-events-none');

    if (scrollToReview) {
        setTimeout(() => {
            const reviewEl = document.getElementById('reviewJawabanSection');
            if (reviewEl) {
                reviewEl.scrollIntoView({ behavior: 'smooth' });
            }
        }, 200);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    @if(session('show_celebration') || session('success'))
        setTimeout(openCelebrationModal, 350);
    @endif
});
</script>
@endsection
