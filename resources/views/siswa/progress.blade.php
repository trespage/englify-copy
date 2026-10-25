@extends('layouts.siswa')

@section('title', 'Progress Belajar')

@section('content')
<div class="space-y-6">

    <!-- ===================================================== -->
    <!-- HEADER                                                 -->
    <!-- ===================================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Progress Belajar</h1>
            <p class="text-slate-500 text-sm mt-0.5">Pantau perkembangan belajarmu dan raih targetmu!</p>
        </div>
        <div class="flex items-center gap-2 text-sm bg-white px-4 py-2.5 rounded-xl border border-[#97CADB]/30 shadow-sm">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="font-semibold text-slate-700">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- STATS CARDS                                            -->
    <!-- ===================================================== -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <!-- Materi Dibaca -->
        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-[#97CADB]/30 shadow-sm hover:shadow-md transition">
            <div class="flex items-start justify-between mb-2 sm:mb-3">
                <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl bg-[#D6EBEE] flex items-center justify-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <span class="text-[10px] sm:text-xs font-bold text-[#018ABE] bg-[#D6EBEE] px-1.5 sm:px-2 py-0.5 sm:py-1 rounded-full">{{ $materiDibaca ?? 0 }}/{{ $totalMateri ?? 0 }}</span>
            </div>
            <p class="text-xs sm:text-sm font-semibold text-slate-500">Materi Dibaca</p>
            <p class="text-xl sm:text-3xl font-extrabold text-slate-800 mt-1">{{ $materiDibaca ?? 0 }}<span class="text-xs sm:text-lg text-slate-400">/{{ $totalMateri ?? 0 }}</span></p>
            <div class="mt-2.5 sm:mt-3 w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-[#018ABE] rounded-full transition-all" style="width: {{ $totalMateri ? ($materiDibaca / $totalMateri * 100) : 0 }}%"></div>
            </div>
        </div>

        <!-- Quiz Dikerjakan -->
        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-[#97CADB]/30 shadow-sm hover:shadow-md transition">
            <div class="flex items-start justify-between mb-2 sm:mb-3">
                <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl bg-[#D6EBEE] flex items-center justify-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#02457A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs sm:text-sm font-semibold text-slate-500">Quiz Dikerjakan</p>
            <p class="text-xl sm:text-3xl font-extrabold text-slate-800 mt-1">{{ $totalQuiz ?? 0 }}</p>
            <p class="text-[10px] sm:text-xs text-slate-400 mt-1 truncate">Total quiz selesai</p>
        </div>

        <!-- Rata-rata Skor -->
        <div class="bg-white rounded-2xl p-3.5 sm:p-5 border border-[#97CADB]/30 shadow-sm hover:shadow-md transition">
            <div class="flex items-start justify-between mb-2 sm:mb-3">
                <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl bg-emerald-50 flex items-center justify-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                @if(($rataRataNilai ?? 0) >= 80)
                    <span class="text-[10px] sm:text-xs font-bold text-emerald-600 bg-emerald-50 px-1.5 sm:px-2 py-0.5 sm:py-1 rounded-full">Great!</span>
                @elseif(($rataRataNilai ?? 0) >= 60)
                    <span class="text-[10px] sm:text-xs font-bold text-[#018ABE] bg-[#D6EBEE] px-1.5 sm:px-2 py-0.5 sm:py-1 rounded-full">Good!</span>
                @else
                    <span class="text-[10px] sm:text-xs font-bold text-amber-600 bg-amber-50 px-1.5 sm:px-2 py-0.5 sm:py-1 rounded-full">Keep Going!</span>
                @endif
            </div>
            <p class="text-xs sm:text-sm font-semibold text-slate-500">Rata-rata Skor</p>
            <p class="text-xl sm:text-3xl font-extrabold text-emerald-600 mt-1">{{ number_format($rataRataNilai ?? 0, 1) }}</p>
            <p class="text-[10px] sm:text-xs text-slate-400 mt-1 truncate">dari semua quiz</p>
        </div>

        <!-- Total Poin -->
        <div class="bg-gradient-to-br from-[#018ABE] to-[#02457A] rounded-2xl p-3.5 sm:p-5 text-white shadow-lg shadow-[#018ABE]/30">
            <div class="flex items-start justify-between mb-2 sm:mb-3">
                <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs sm:text-sm font-semibold text-white/90">Total Poin</p>
            <p class="text-xl sm:text-3xl font-extrabold text-white mt-1">{{ $totalSkor ?? 0 }}</p>
            <p class="text-[10px] sm:text-xs text-white/80 mt-1 truncate">Terus kumpulkan poin!</p>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- MAIN CONTENT: AKTIVITAS MINGGU INI + PENCAPAIAN        -->
    <!-- ===================================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left: Aktivitas Minggu Ini (2/3) -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-[#97CADB]/30 shadow-sm overflow-hidden flex flex-col">
            <div class="px-4 sm:px-6 py-3.5 sm:py-4 border-b border-[#97CADB]/20 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Aktivitas Minggu Ini
                </h3>
                <span class="self-start sm:self-auto text-xs font-bold text-[#018ABE] bg-[#D6EBEE] px-2.5 py-1 rounded-full">
                    {{ \Carbon\Carbon::now()->startOfWeek()->format('d M') }} - {{ \Carbon\Carbon::now()->endOfWeek()->format('d M') }}
                </span>
            </div>

            <div class="p-4 sm:p-6 flex-1 flex flex-col">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 mb-4 sm:mb-6">
                    <!-- Materi Dibaca Minggu Ini -->
                    <div class="p-3.5 sm:p-4 rounded-xl bg-[#D6EBEE] border border-[#97CADB]/40">
                        <div class="flex items-center gap-3 mb-1 sm:mb-2">
                            <div class="w-10 h-10 rounded-lg bg-[#97CADB] flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-semibold">Materi Dibaca</p>
                                <p class="text-xl sm:text-2xl font-extrabold text-[#018ABE]">{{ $aktivitasMingguIni['materi_dibaca'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quiz Dikerjakan Minggu Ini -->
                    <div class="p-3.5 sm:p-4 rounded-xl bg-[#D6EBEE] border border-[#97CADB]/40">
                        <div class="flex items-center gap-3 mb-1 sm:mb-2">
                            <div class="w-10 h-10 rounded-lg bg-[#97CADB] flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-[#02457A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-semibold">Quiz Dikerjakan</p>
                                <p class="text-xl sm:text-2xl font-extrabold text-[#02457A]">{{ $aktivitasMingguIni['quiz_dikerjakan'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Motivasi Message -->
                <div class="p-4 rounded-xl bg-gradient-to-r from-[#D6EBEE] to-[#97CADB]/30 border border-[#97CADB]/40">
                    <div class="flex items-start gap-3">
                        <span class="text-2xl">💪</span>
                        <div>
                            <p class="text-sm font-bold text-slate-800 mb-1">
                                @if(($aktivitasMingguIni['quiz_dikerjakan'] ?? 0) >= 3)
                                    Luar biasa! Kamu sangat produktif minggu ini!
                                @elseif(($aktivitasMingguIni['quiz_dikerjakan'] ?? 0) >= 1)
                                    Bagus! Terus pertahankan semangat belajarmu!
                                @else
                                    Ayo mulai belajar! Setiap langkah kecil berarti.
                                @endif
                            </p>
                            <p class="text-xs text-slate-600">
                                @if(($aktivitasMingguIni['quiz_dikerjakan'] ?? 0) >= 3)
                                    Kamu sudah mengerjakan {{ $aktivitasMingguIni['quiz_dikerjakan'] }} quiz minggu ini. Hebat!
                                @elseif(($aktivitasMingguIni['quiz_dikerjakan'] ?? 0) >= 1)
                                    Kamu sudah mengerjakan {{ $aktivitasMingguIni['quiz_dikerjakan'] }} quiz. Coba kerjakan lebih banyak lagi!
                                @else
                                    Belum ada quiz yang dikerjakan minggu ini. Yuk mulai dari yang paling mudah!
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Area Aktivitas / Teks Transparan Jika Belum Ada Aktivitas -->
                @php
                    $adaAktivitasMingguIni = (($aktivitasMingguIni['materi_dibaca'] ?? 0) > 0) || (($aktivitasMingguIni['quiz_dikerjakan'] ?? 0) > 0);
                    $riwayatMingguIni = isset($riwayat) ? $riwayat->where('created_at', '>=', \Carbon\Carbon::now()->startOfWeek()) : collect();
                @endphp

                @if(!$adaAktivitasMingguIni)
                    <!-- Centered Transparent Empty State -->
                    <div class="mt-6 flex-1 min-h-[200px] flex flex-col items-center justify-center text-center p-6 rounded-2xl border-2 border-dashed border-[#97CADB]/30 bg-gradient-to-b from-[#D6EBEE]/20 via-[#D6EBEE]/10 to-transparent relative overflow-hidden select-none">


                        <!-- Ikon Lembut / Transparan di Tengah -->
                        <div class="relative z-10 w-14 h-14 rounded-2xl bg-white/70 border border-[#97CADB]/40 shadow-sm flex items-center justify-center mb-3">
                            <svg class="w-7 h-7 text-[#018ABE]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>

                        <!-- Teks Transparan di Tengah -->
                        <h4 class="relative z-10 text-sm md:text-base font-bold text-slate-400/80 tracking-wide uppercase">
                            Belum Ada Aktivitas Minggu Ini
                        </h4>
                        <p class="relative z-10 text-xs text-slate-400/80 max-w-sm mt-1.5 leading-relaxed">
                            Materi yang kamu baca dan quiz yang kamu selesaikan akan otomatis tercatat di sini setelah kamu mulai belajar.
                        </p>

                        <!-- Tombol Mulai Belajar -->
                        <a href="{{ route('siswa.materi') }}" class="relative z-10 mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#018ABE]/10 hover:bg-[#018ABE] text-[#018ABE] hover:text-white border border-[#018ABE]/20 font-bold text-xs transition duration-200 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                            <span>Mulai Belajar Materi</span>
                        </a>
                    </div>
                @else
                    <!-- Daftar Aktivitas Minggu Ini -->
                    <div class="mt-6 flex-1 space-y-2.5">
                        <div class="flex items-center justify-between pb-2 border-b border-[#97CADB]/20">
                            <p class="text-xs font-bold text-slate-600 uppercase tracking-wider">Aktivitas Terbaru Minggu Ini</p>
                            <span class="text-[11px] font-semibold text-[#018ABE]">Terbaru</span>
                        </div>
                        <div class="divide-y divide-slate-100">
                            @foreach($riwayatMingguIni->take(3) as $act)
                            <div class="flex items-center justify-between py-2.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-[#D6EBEE] text-[#018ABE] flex items-center justify-center text-xs font-bold shrink-0">
                                        ✓
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-bold text-slate-700 truncate">{{ $act->quiz->judul ?? 'Quiz Selesai' }}</p>
                                        <p class="text-[10px] text-slate-400">{{ $act->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <span class="text-xs font-extrabold text-[#02457A] bg-[#D6EBEE] px-2.5 py-1 rounded-full shrink-0">
                                    {{ $act->skor_diperoleh }} Poin
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right: Pencapaian (Achievement Badges) -->
        <div class="space-y-4">
            <div class="bg-white rounded-2xl border border-[#97CADB]/30 shadow-sm p-6">
                <h4 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5zm14 3c0 .6-.4 1-1 1H6c-.6 0-1-.4-1-1v-1h14v1z"/>
                    </svg>
                    Pencapaian
                </h4>
                <div class="space-y-3">
                    <!-- First Quiz -->
                    <div class="flex items-center gap-3 p-3 rounded-xl {{ $pencapaian['first_quiz'] ? 'bg-emerald-50 border border-emerald-100' : 'bg-slate-50 border border-[#97CADB]/20 opacity-50' }}">
                        <div class="w-10 h-10 rounded-full {{ $pencapaian['first_quiz'] ? 'bg-emerald-100' : 'bg-slate-100' }} flex items-center justify-center text-xl">
                            {{ $pencapaian['first_quiz'] ? '🎯' : '🔒' }}
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-bold text-slate-800">First Quiz!</p>
                            <p class="text-[10px] text-slate-500">Selesaikan quiz pertama</p>
                        </div>
                        @if($pencapaian['first_quiz'])
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        @endif
                    </div>

                    <!-- Five Quiz (Book Worm) -->
                    <div class="flex items-center gap-3 p-3 rounded-xl {{ $pencapaian['five_quiz'] ? 'bg-[#D6EBEE] border border-[#97CADB]/40' : 'bg-slate-50 border border-[#97CADB]/20 opacity-50' }}">
                        <div class="w-10 h-10 rounded-full {{ $pencapaian['five_quiz'] ? 'bg-[#97CADB]' : 'bg-slate-100' }} flex items-center justify-center text-xl">
                            {{ $pencapaian['five_quiz'] ? '📚' : '🔒' }}
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-bold text-slate-800">Book Worm</p>
                            <p class="text-[10px] text-slate-500">Selesaikan 5 quiz</p>
                        </div>
                        @if($pencapaian['five_quiz'])
                        <svg class="w-5 h-5 text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        @endif
                    </div>

                    <!-- Perfect Score -->
                    <div class="flex items-center gap-3 p-3 rounded-xl {{ $pencapaian['perfect_score'] ? 'bg-amber-50 border border-amber-100' : 'bg-slate-50 border border-[#97CADB]/20 opacity-50' }}">
                        <div class="w-10 h-10 rounded-full {{ $pencapaian['perfect_score'] ? 'bg-amber-100' : 'bg-slate-100' }} flex items-center justify-center text-xl">
                            {{ $pencapaian['perfect_score'] ? '💯' : '🔒' }}
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-bold text-slate-800">Perfect Score</p>
                            <p class="text-[10px] text-slate-500">Dapat nilai 100</p>
                        </div>
                        @if($pencapaian['perfect_score'])
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        @endif
                    </div>

                    <!-- Bookworm (Rajin Baca) -->
                    <div class="flex items-center gap-3 p-3 rounded-xl {{ $pencapaian['bookworm'] ? 'bg-[#D6EBEE] border border-[#97CADB]/40' : 'bg-slate-50 border border-[#97CADB]/20 opacity-50' }}">
                        <div class="w-10 h-10 rounded-full {{ $pencapaian['bookworm'] ? 'bg-[#97CADB]' : 'bg-slate-100' }} flex items-center justify-center text-xl">
                            {{ $pencapaian['bookworm'] ? '📖' : '🔒' }}
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-bold text-slate-800">Rajin Baca</p>
                            <p class="text-[10px] text-slate-500">Baca 5 materi</p>
                        </div>
                        @if($pencapaian['bookworm'])
                        <svg class="w-5 h-5 text-[#02457A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        @endif
                    </div>

                    <!-- High Achiever -->
                    <div class="flex items-center gap-3 p-3 rounded-xl {{ $pencapaian['high_achiever'] ? 'bg-rose-50 border border-rose-100' : 'bg-slate-50 border border-[#97CADB]/20 opacity-50' }}">
                        <div class="w-10 h-10 rounded-full {{ $pencapaian['high_achiever'] ? 'bg-rose-100' : 'bg-slate-100' }} flex items-center justify-center text-xl">
                            {{ $pencapaian['high_achiever'] ? '⭐' : '🔒' }}
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-bold text-slate-800">High Achiever</p>
                            <p class="text-[10px] text-slate-500">Rata-rata ≥ 80</p>
                        </div>
                        @if($pencapaian['high_achiever'])
                        <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Cat Mascot (Desktop: Tetap di kolom kanan sidebar) -->
            <div class="hidden lg:block bg-gradient-to-br from-[#D6EBEE] to-[#97CADB]/30 rounded-2xl p-5 border border-[#97CADB]/40 text-center">
                <img src="{{ asset('images/cat-welcome.png') }}" alt="Englify Cat" class="w-24 h-auto mx-auto mb-2">
                <p class="font-cute text-lg text-[#018ABE] leading-tight">Good Job!</p>
                <p class="text-xs text-slate-500 mt-1">Terus semangat belajar ya! ✨</p>
            </div>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- RIWAYAT PENGERJAAN QUIZ                                -->
    <!-- ===================================================== -->
    <div class="bg-white rounded-2xl border border-[#97CADB]/30 shadow-sm overflow-hidden">
        <div class="px-4 sm:px-6 py-3.5 sm:py-4 border-b border-[#97CADB]/20 flex items-center justify-between">
            <h3 class="text-sm sm:text-base font-bold text-slate-800 flex items-center gap-2">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#02457A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Riwayat Pengerjaan Quiz
            </h3>
            <a href="{{ route('siswa.quiz') }}" class="text-xs font-semibold text-[#018ABE] hover:text-[#02457A] flex items-center gap-1">
                Lihat Semua
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        @if(isset($riwayat) && $riwayat->count() > 0)
        <div class="divide-y divide-slate-100">
            @foreach($riwayat->take(5) as $hasil)
            <div class="px-4 sm:px-6 py-3 sm:py-4 hover:bg-slate-50 transition flex items-center justify-between gap-3">
                <div class="flex items-center gap-3 sm:gap-4 min-w-0">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-gradient-to-br from-[#D6EBEE] to-[#97CADB] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-[#02457A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h4 class="font-bold text-slate-800 text-xs sm:text-sm truncate">{{ $hasil->quiz->judul ?? 'Quiz' }}</h4>
                        <p class="text-[10px] sm:text-xs text-slate-500">{{ $hasil->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                    <div class="text-right">
                        <p class="text-base sm:text-lg font-extrabold text-slate-800">{{ $hasil->skor_diperoleh }}</p>
                        <p class="text-[9px] sm:text-[10px] text-slate-400">poin</p>
                    </div>
                    @if($hasil->skor_diperoleh >= 80)
                        <span class="px-2 sm:px-3 py-0.5 sm:py-1 bg-emerald-100 text-emerald-700 text-[10px] sm:text-xs font-bold rounded-full">Excellent</span>
                    @elseif($hasil->skor_diperoleh >= 60)
                        <span class="px-2 sm:px-3 py-0.5 sm:py-1 bg-[#97CADB] text-[#02457A] text-[10px] sm:text-xs font-bold rounded-full">Good</span>
                    @else
                        <span class="px-2 sm:px-3 py-0.5 sm:py-1 bg-amber-100 text-amber-700 text-[10px] sm:text-xs font-bold rounded-full">Keep Trying</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Empty State -->
        <div class="px-4 sm:px-6 py-10 sm:py-12 text-center">
            <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto mb-4 rounded-full bg-slate-100 flex items-center justify-center">
                <svg class="w-8 h-8 sm:w-10 sm:h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <p class="text-slate-500 text-xs sm:text-sm mb-4">Kamu belum mengerjakan quiz apapun</p>
            <a href="{{ route('siswa.quiz') }}" class="inline-flex items-center gap-2 px-5 sm:px-6 py-2.5 sm:py-3 bg-[#018ABE] hover:bg-[#02457A] text-white text-xs sm:text-sm font-semibold rounded-xl transition shadow-lg shadow-[#018ABE]/30">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Mulai Mengerjakan Quiz
            </a>
        </div>
        @endif
    </div>

    <!-- ===================================================== -->
    <!-- PROGRESS PER KATEGORI                                  -->
    <!-- ===================================================== -->
    <div class="bg-white rounded-2xl border border-[#97CADB]/30 shadow-sm overflow-hidden">
        <div class="px-4 sm:px-6 py-3.5 sm:py-4 border-b border-[#97CADB]/20 flex flex-col sm:flex-row sm:items-center justify-between gap-1">
            <h3 class="text-sm sm:text-base font-bold text-slate-800">Progress Per Kategori</h3>
            <span class="text-[11px] sm:text-xs text-slate-400 font-medium">Berdasarkan penyelesaian kuis</span>
        </div>
        <div class="p-4 sm:p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            @forelse($progressPerKategori ?? [] as $item)
                @php
                    $namaLower = strtolower($item['nama'] ?? '');
                    $style = match($namaLower) {
                        'writing' => [
                            'card' => 'bg-blue-50/60 border-blue-200/60',
                            'text' => 'text-blue-600',
                            'bar'  => 'bg-blue-600',
                            'track'=> 'bg-blue-100',
                            'icon' => 'writing',
                        ],
                        'speaking' => [
                            'card' => 'bg-rose-50/60 border-rose-200/60',
                            'text' => 'text-rose-600',
                            'bar'  => 'bg-rose-600',
                            'track'=> 'bg-rose-100',
                            'icon' => 'speaking',
                        ],
                        'reading' => [
                            'card' => 'bg-emerald-50/60 border-emerald-200/60',
                            'text' => 'text-emerald-600',
                            'bar'  => 'bg-emerald-600',
                            'track'=> 'bg-emerald-100',
                            'icon' => 'reading',
                        ],
                        'listening' => [
                            'card' => 'bg-purple-50/60 border-purple-200/60',
                            'text' => 'text-purple-600',
                            'bar'  => 'bg-purple-600',
                            'track'=> 'bg-purple-100',
                            'icon' => 'listening',
                        ],
                        default => [
                            'card' => 'bg-slate-50 border-slate-200',
                            'text' => 'text-[#018ABE]',
                            'bar'  => 'bg-[#018ABE]',
                            'track'=> 'bg-slate-200',
                            'icon' => 'default',
                        ],
                    };
                @endphp
                <div class="p-4 rounded-xl {{ $style['card'] }} border transition hover:shadow-xs">
                    <div class="flex items-center gap-2 mb-3">
                        @if($style['icon'] === 'writing')
                            <svg class="w-5 h-5 {{ $style['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        @elseif($style['icon'] === 'speaking')
                            <svg class="w-5 h-5 {{ $style['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        @elseif($style['icon'] === 'reading')
                            <svg class="w-5 h-5 {{ $style['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        @elseif($style['icon'] === 'listening')
                            <svg class="w-5 h-5 {{ $style['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
                            </svg>
                        @else
                            <svg class="w-5 h-5 {{ $style['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        @endif
                        <span class="text-sm font-bold text-slate-800">{{ $item['nama'] }}</span>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-2xl font-extrabold {{ $style['text'] }}">{{ $item['persentase'] }}%</span>
                        <span class="text-xs text-slate-500">{{ $item['quiz_selesai'] }}/{{ $item['total_quiz'] }} quiz</span>
                    </div>
                    <div class="w-full h-2 {{ $style['track'] }} rounded-full overflow-hidden">
                        <div class="h-full {{ $style['bar'] }} rounded-full transition-all duration-500" style="width: {{ $item['persentase'] }}%"></div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-6 text-center text-slate-400 text-xs">
                    Belum ada data kategori pembelajaran.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Cat Mascot (Mobile: Diletakkan di akhir halaman agar rapi) -->
    <div class="block lg:hidden bg-gradient-to-br from-[#D6EBEE] to-[#97CADB]/30 rounded-2xl p-5 border border-[#97CADB]/40 text-center shadow-xs">
        <img src="{{ asset('images/cat-welcome.png') }}" alt="Englify Cat" class="w-20 h-auto mx-auto mb-2 drop-shadow-xs">
        <p class="font-cute text-lg text-[#018ABE] leading-tight">Good Job!</p>
        <p class="text-xs text-slate-500 mt-1">Terus semangat belajar ya! ✨</p>
    </div>

</div>
@endsection
