@extends('layouts.superadmin')

@section('title', 'Dashboard Super Admin')

@section('content')
<div class="space-y-6">

    @if($errors->any())
    <div class="bg-rose-50 border border-rose-200 text-rose-800 text-sm px-4 py-3 rounded-2xl shadow-xs">
        <p class="font-bold mb-1">Gagal menyimpan akun:</p>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- ============================================================== -->
    <!-- 1. WELCOME BANNER (Matching the mockup illustration)          -->
    <!-- ============================================================== -->
    <div class="bg-gradient-to-r from-blue-50/90 via-sky-50/60 to-white rounded-3xl p-6 sm:p-8 border border-blue-100 shadow-card relative overflow-hidden">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 relative z-10">
            <!-- Left: Greeting text & sparkles -->
            <div class="max-w-xl">
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="text-sky-500 text-lg">✦</span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight">
                        Selamat Datang, Satpam &amp; HRD!
                    </h1>
                </div>
                <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                    Kelola akun dan data sistem Englify dengan mudah dan aman.
                </p>
                <div class="mt-4 flex flex-wrap items-center gap-3">
                    <button onclick="openTambahModal('siswa')" 
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-bold shadow-md shadow-blue-500/20 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Tambah Siswa Baru
                    </button>
                    <button onclick="openTambahModal('admin')" 
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs sm:text-sm font-bold shadow-xs transition">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Tambah Admin Divisi
                    </button>
                </div>
            </div>

            <!-- Right: Englify Cat Mascot & Speech Callout -->
            <div class="flex items-center gap-4 self-center sm:self-auto shrink-0">
                <!-- Speech Bubble -->
                <div class="hidden md:block relative bg-white/90 backdrop-blur-xs border border-blue-200/80 rounded-2xl p-3.5 shadow-sm max-w-[210px]">
                    <p class="font-cute text-base text-slate-700 leading-tight">
                        “Kelola akun, bangun masa depan bersama Englify!” 🐾
                    </p>
                    <span class="absolute -right-2 top-1/2 -translate-y-1/2 w-3 h-3 bg-white border-t border-r border-blue-200/80 transform rotate-45"></span>
                </div>
                <!-- Mascot Image -->
                <div class="relative">
                    <img src="{{ asset('images/cat-welcome.png') }}" alt="Englify Cat Mascot" 
                         class="w-32 sm:w-44 h-auto object-contain drop-shadow-lg transform hover:scale-105 transition-transform duration-300">
                    <span class="absolute -top-2 right-1 text-amber-400 text-sm animate-bounce">✨</span>
                </div>
            </div>
        </div>
        
        <!-- Subtle decorative gradient blur spots -->
        <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-blue-100/50 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -top-10 -left-10 w-40 h-40 bg-sky-100/50 rounded-full blur-2xl pointer-events-none"></div>
    </div>


    <!-- ============================================================== -->
    <!-- 2. METRIC CARDS ROW (Exact match: Total Siswa, Divisi, Sistem) -->
    <!-- ============================================================== -->
    <!-- Desktop: 3 prominent cards | Mobile: 2x2 grid (including Admin Divisi) -->
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-3.5 sm:gap-5">
        
        <!-- CARD 1: Total Siswa -->
        <div class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 border border-slate-200/80 shadow-card hover:shadow-hover transition duration-200">
            <div class="flex items-center justify-between mb-2 sm:mb-3">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <!-- Users icon -->
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <span class="inline-flex items-center text-[10px] sm:text-xs font-bold text-emerald-600 bg-emerald-50 border border-emerald-200/80 px-2 py-0.5 rounded-full">
                    {{ $siswaGrowth ?? '+ 0%' }}
                </span>
            </div>
            <p class="text-xs sm:text-sm font-semibold text-slate-500">Total Siswa</p>
            <div class="flex items-baseline gap-2 mt-0.5">
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight">
                    {{ $totalSiswa ?? 0 }}
                </h3>
            </div>
            <p class="text-[10px] sm:text-xs text-slate-400 mt-1">dari bulan lalu</p>
        </div>

        <!-- CARD 2: Total Admin -->
        <div class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 border border-slate-200/80 shadow-card hover:shadow-hover transition duration-200">
            <div class="flex items-center justify-between mb-2 sm:mb-3">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-violet-50 text-violet-600 flex items-center justify-center">
                    <!-- Shield icon -->
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <span class="inline-flex items-center text-[10px] sm:text-xs font-bold text-emerald-600 bg-emerald-50 border border-emerald-200/80 px-2 py-0.5 rounded-full">
                    {{ $adminGrowth ?? '+ 0%' }}
                </span>
            </div>
            <p class="text-xs sm:text-sm font-semibold text-slate-500">Total Admin</p>
            <div class="flex items-baseline gap-2 mt-0.5">
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight">
                    {{ $totalAdmin ?? 0 }}
                </h3>
            </div>
            <p class="text-[10px] sm:text-xs text-slate-400 mt-1">dari bulan lalu</p>
        </div>

        <!-- CARD 3: Data Sistem (Desktop 3rd card, on mobile shown in 2x2 grid) -->
        <div class="col-span-2 lg:col-span-1 bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 border border-slate-200/80 shadow-card hover:shadow-hover transition duration-200">
            <div class="flex items-center justify-between mb-2 sm:mb-3">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center">
                    <!-- Server / database check icon -->
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                    </svg>
                </div>
                <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-xs">
                    ✓
                </span>
            </div>
            <p class="text-xs sm:text-sm font-semibold text-slate-500">Data Sistem</p>
            <div class="flex items-baseline gap-2 mt-0.5">
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight">
                    {{ $systemStatus ?? 'Normal' }}
                </h3>
            </div>
            <p class="text-[10px] sm:text-xs text-slate-400 mt-1">Semua sistem berjalan dengan baik/aktif</p>
        </div>

        <!-- Extra card for mobile view: Total Divisi (so mobile has exact 2x2 symmetry) -->
        <div class="lg:hidden bg-white rounded-2xl p-4 border border-slate-200/80 shadow-card">
            <div class="flex items-center justify-between mb-2">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                </div>
                <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">{{ $divisiGrowth ?? '+ 0%' }}</span>
            </div>
            <p class="text-xs font-semibold text-slate-500">Total Divisi</p>
            <h3 class="text-2xl font-extrabold text-slate-800">{{ $totalDivisi ?? 0 }}</h3>
            <p class="text-[10px] text-slate-400 mt-1">dari bulan lalu</p>
        </div>
    </div>


    <!-- ============================================================== -->
    <!-- 3. MIDDLE SECTION (2 COLUMNS: Aktivitas Terbaru & Statistik)   -->
    <!-- ============================================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 sm:gap-6">
        
        <!-- ============ LEFT COLUMN: Aktivitas Terbaru ============ -->
        <div class="bg-white rounded-3xl p-5 sm:p-7 border border-slate-200/80 shadow-card flex flex-col justify-between">
            <div>
                <!-- Header with Lihat Semua link -->
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-base sm:text-lg font-extrabold text-slate-800">
                        Aktivitas Terbaru
                    </h2>
                    <a href="#tabel-kelola-akun" class="text-xs sm:text-sm font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 group">
                        <span>Lihat Semua</span>
                        <span class="transition-transform group-hover:translate-x-1">→</span>
                    </a>
                </div>

                <!-- Activity List items -->
                <div class="space-y-3.5">
                    @forelse(($recentActivities ?? collect()) as $act)
                    <div class="flex items-center justify-between gap-3 p-2.5 rounded-2xl hover:bg-slate-50/80 transition duration-150">
                        <!-- Icon & text -->
                        <div class="flex items-center gap-3.5 min-w-0">
                            <!-- Circular user icon -->
                            <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs sm:text-sm font-bold text-slate-800 truncate">
                                    {{ $act->title }}
                                </p>
                                <p class="text-[11px] sm:text-xs text-slate-500 truncate">
                                    {{ $act->desc }}
                                </p>
                                <p class="text-[10px] text-slate-400 mt-0.5">
                                    {{ $act->time }}
                                </p>
                            </div>
                        </div>
                        <!-- Role Badge (Siswa / Admin Divisi) -->
                        <span class="shrink-0 text-[11px] font-bold px-3 py-1 rounded-full border {{ $act->badge_class }}">
                            {{ $act->role }}
                        </span>
                    </div>
                    @empty
                    <p class="text-xs text-slate-400 text-center py-6">Belum ada aktivitas tercatat.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- ============ RIGHT COLUMN: Statistik Akun & Ringkasan ============ -->
        <div class="space-y-5">
            <!-- 1. Statistik Akun (Line Chart) -->
            <div class="bg-white rounded-3xl p-5 sm:p-7 border border-slate-200/80 shadow-card">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-base sm:text-lg font-extrabold text-slate-800">
                        Statistik Akun
                    </h2>
                    <!-- Timeframe Pill Dropdown -->
                    <div class="relative">
                        <button class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-600 text-xs font-semibold transition">
                            <span>7 Hari Terakhir</span>
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Legend: Siswa -->
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                    <span class="text-xs font-bold text-slate-600">Siswa</span>
                </div>

                <!-- Interactive Chart Canvas -->
                <div class="h-44 sm:h-52 w-full relative">
                    <canvas id="studentGrowthChart"></canvas>
                </div>
            </div>

            <!-- 2. Ringkasan (4 mini boxes in a row) -->
            <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/80 shadow-card">
                <h3 class="text-sm font-extrabold text-slate-800 mb-3.5">Ringkasan</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <!-- Mini 1: Siswa Baru -->
                    <div class="bg-slate-50/80 rounded-2xl p-3 border border-slate-100 flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="w-7 h-7 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-xs">👥</span>
                            <span class="text-[10px] font-bold text-emerald-600">{{ $newSiswaGrowth ?? '▲ 0%' }}</span>
                        </div>
                        <div class="mt-2">
                            <p class="text-[10px] font-semibold text-slate-400">Siswa Baru</p>
                            <p class="text-lg font-extrabold text-slate-800 leading-tight">{{ $newSiswaCount ?? 0 }}</p>
                        </div>
                    </div>

                    <!-- Mini 2: Admin Baru -->
                    <div class="bg-slate-50/80 rounded-2xl p-3 border border-slate-100 flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="w-7 h-7 rounded-lg bg-violet-100 text-violet-600 flex items-center justify-center text-xs">🛡️</span>
                            <span class="text-[10px] font-bold text-emerald-600">{{ $newAdminGrowth ?? '▲ 0%' }}</span>
                        </div>
                        <div class="mt-2">
                            <p class="text-[10px] font-semibold text-slate-400">Admin Baru</p>
                            <p class="text-lg font-extrabold text-slate-800 leading-tight">{{ $newAdminCount ?? 0 }}</p>
                        </div>
                    </div>

                    <!-- Mini 3: Divisi Aktif -->
                    <div class="bg-slate-50/80 rounded-2xl p-3 border border-slate-100 flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs">🏛️</span>
                            <span class="text-[10px] font-bold text-emerald-600">{{ $totalAkunGrowth ?? '▲ 0%' }}</span>
                        </div>
                        <div class="mt-2">
                            <p class="text-[10px] font-semibold text-slate-400">Total Akun</p>
                            <p class="text-lg font-extrabold text-slate-800 leading-tight">{{ $totalAkun ?? 0 }}</p>
                        </div>
                    </div>

                    <!-- Mini 4: Akun Aktif -->
                    <div class="bg-slate-50/80 rounded-2xl p-3 border border-slate-100 flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs">✓</span>
                            <span class="text-[10px] font-bold text-emerald-600">{{ $activeGrowth ?? '▲ 0%' }}</span>
                        </div>
                        <div class="mt-2">
                            <p class="text-[10px] font-semibold text-slate-400">Akun Aktif</p>
                            <p class="text-lg font-extrabold text-slate-800 leading-tight">{{ $activeAccounts ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ============================================================== -->
    <!-- 4. BOTTOM SECTION: KELOLA AKUN (Dual Tables Side-by-Side)      -->
    <!-- ============================================================== -->
    <div id="tabel-kelola-akun" class="bg-white rounded-3xl p-5 sm:p-8 border border-slate-200/80 shadow-card">
        <!-- Section Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <!-- Users table / folder badge icon -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg sm:text-xl font-extrabold text-slate-800">Kelola Akun</h2>
                    <p class="text-xs sm:text-sm text-slate-500">Buat dan kelola akun siswa serta admin divisi.</p>
                </div>
            </div>

            <!-- Primary Action: + Tambah Akun -->
            <button onclick="openTambahModal('siswa')" 
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs sm:text-sm shadow-md shadow-blue-500/25 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                <span>Tambah Akun</span>
            </button>
        </div>

        <!-- Dual Table Container: 2 equal columns on desktop, stacked on mobile -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 pt-6">

            <!-- ===================== TABLE 1: AKUN SISWA ===================== -->
            <div class="border border-slate-100 rounded-2xl p-4 sm:p-5 bg-[#FAFCFF] flex flex-col justify-between">
                <div>
                    <!-- Sub-header -->
                    <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <span class="w-7 h-7 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-xs">👤</span>
                            <div>
                                <h3 class="text-sm font-extrabold text-slate-800">Akun Siswa</h3>
                                <p class="text-[11px] text-slate-400">{{ $totalSiswa ?? 0 }} akun</p>
                            </div>
                        </div>
                        <a href="{{ route('superadmin.siswa') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                            Lihat Semua &gt;
                        </a>
                    </div>

                    <!-- Responsive Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs min-w-[340px]">
                            <thead>
                                <tr class="text-slate-400 font-bold border-b border-slate-100">
                                    <th class="py-2.5 px-2">No</th>
                                    <th class="py-2.5 px-2">Nama</th>
                                    <th class="py-2.5 px-2">Email</th>
                                    <th class="py-2.5 px-2">Status</th>
                                    <th class="py-2.5 px-2 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                @forelse(($students ?? collect())->take(5) as $idx => $s)
                                <tr class="hover:bg-blue-50/40 transition">
                                    <td class="py-2.5 px-2 font-semibold text-slate-400">{{ $idx + 1 }}</td>
                                    <td class="py-2.5 px-2 font-bold text-slate-800">{{ $s->nama }}</td>
                                    <td class="py-2.5 px-2 text-slate-500 truncate max-w-[140px]">{{ $s->email }}</td>
                                    <td class="py-2.5 px-2">
                                        <span class="inline-block text-[10px] font-bold px-2.5 py-0.5 rounded-full {{ strtolower($s->status ?? 'aktif') === 'aktif' ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : 'bg-amber-50 text-amber-600 border border-amber-200' }}">
                                            {{ ucfirst($s->status ?? 'aktif') }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-2 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <!-- Edit button -->
                                            <button onclick="openEditModal(@js($s->id_user), @js($s->nama), @js($s->email), 'siswa')" 
                                                    class="p-1 rounded text-blue-500 hover:bg-blue-100 transition" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                            </button>
                                            <!-- Delete button -->
                                            <form action="{{ route('superadmin.siswa.destroy', $s->id_user) }}" method="POST" onsubmit="return confirmHapus(@js($s->nama))">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1 rounded text-rose-500 hover:bg-rose-100 transition" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-slate-400">Belum ada akun siswa.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination Matching Mockup (< [1] 2 3 >) -->
                <div class="flex items-center justify-center gap-1 pt-4 mt-3 border-t border-slate-100">
                    <button class="w-6 h-6 rounded-md flex items-center justify-center text-xs text-slate-400 hover:bg-white hover:text-slate-700">&lt;</button>
                    <button class="w-6 h-6 rounded-md flex items-center justify-center text-xs font-bold bg-blue-600 text-white shadow-xs">1</button>
                    <button class="w-6 h-6 rounded-md flex items-center justify-center text-xs font-bold text-slate-600 hover:bg-white">2</button>
                    <button class="w-6 h-6 rounded-md flex items-center justify-center text-xs font-bold text-slate-600 hover:bg-white">3</button>
                    <button class="w-6 h-6 rounded-md flex items-center justify-center text-xs text-slate-400 hover:bg-white hover:text-slate-700">&gt;</button>
                </div>
            </div>

            <!-- ===================== TABLE 2: AKUN ADMIN ===================== -->
            <div class="border border-slate-100 rounded-2xl p-4 sm:p-5 bg-[#FAFCFF] flex flex-col justify-between">
                <div>
                    <!-- Sub-header -->
                    <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <span class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs">🏛️</span>
                            <div>
                                <h3 class="text-sm font-extrabold text-slate-800">Akun Admin</h3>
                                <p class="text-[11px] text-slate-400">{{ $totalAdmin ?? 0 }} akun</p>
                            </div>
                        </div>
                        <a href="{{ route('superadmin.adminDivisi') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                            Lihat Semua &gt;
                        </a>
                    </div>

                    <!-- Responsive Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs min-w-[340px]">
                            <thead>
                                <tr class="text-slate-400 font-bold border-b border-slate-100">
                                    <th class="py-2.5 px-2">No</th>
                                    <th class="py-2.5 px-2">Nama</th>
                                    <th class="py-2.5 px-2">Status</th>
                                    <th class="py-2.5 px-2 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                @forelse(($admins ?? collect())->take(5) as $idx => $a)
                                <tr class="hover:bg-blue-50/40 transition">
                                    <td class="py-2.5 px-2 font-semibold text-slate-400">{{ $idx + 1 }}</td>
                                    <td class="py-2.5 px-2 font-bold text-slate-800">{{ $a->nama }}</td>
                                    <td class="py-2.5 px-2">
                                        <span class="inline-block text-[10px] font-bold px-2.5 py-0.5 rounded-full {{ strtolower($a->status ?? 'aktif') === 'aktif' ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : 'bg-amber-50 text-amber-600 border border-amber-200' }}">
                                            {{ ucfirst($a->status ?? 'aktif') }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-2 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <!-- Edit button -->
                                            <button onclick="openEditModal(@js($a->id_user), @js($a->nama), @js($a->email ?? ''), 'admin')" 
                                                    class="p-1 rounded text-blue-500 hover:bg-blue-100 transition" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                            </button>
                                            <!-- Delete button -->
                                            <form action="{{ route('superadmin.adminDivisi.destroy', $a->id_user) }}" method="POST" onsubmit="return confirmHapus(@js($a->nama))">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1 rounded text-rose-500 hover:bg-rose-100 transition" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-slate-400">Belum ada akun admin divisi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination Matching Mockup (< [1] 2 3 >) -->
                <div class="flex items-center justify-center gap-1 pt-4 mt-3 border-t border-slate-100">
                    <button class="w-6 h-6 rounded-md flex items-center justify-center text-xs text-slate-400 hover:bg-white hover:text-slate-700">&lt;</button>
                    <button class="w-6 h-6 rounded-md flex items-center justify-center text-xs font-bold bg-blue-600 text-white shadow-xs">1</button>
                    <button class="w-6 h-6 rounded-md flex items-center justify-center text-xs font-bold text-slate-600 hover:bg-white">2</button>
                    <button class="w-6 h-6 rounded-md flex items-center justify-center text-xs font-bold text-slate-600 hover:bg-white">3</button>
                    <button class="w-6 h-6 rounded-md flex items-center justify-center text-xs text-slate-400 hover:bg-white hover:text-slate-700">&gt;</button>
                </div>
            </div>

        </div>
    </div>

</div>

<!-- ============================================================== -->
<!-- MODAL TAMBAH AKUN (Siswa / Admin Divisi)                       -->
<!-- ============================================================== -->
<div id="modal-tambah-akun" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full p-6 sm:p-7 relative max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
            <h3 id="modal-tambah-title" class="text-lg font-extrabold text-slate-800">Tambah Akun Baru</h3>
            <button onclick="closeTambahModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form action="{{ route('superadmin.users.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Tipe Role Akun</label>
                <div class="grid grid-cols-2 gap-2">
                    <label class="flex items-center gap-2 p-3 rounded-2xl border border-slate-200 cursor-pointer has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50/50">
                        <input type="radio" name="role" value="siswa" id="role-siswa" checked class="text-blue-600">
                        <span class="text-xs font-bold text-slate-800">Akun Siswa</span>
                    </label>
                    <label class="flex items-center gap-2 p-3 rounded-2xl border border-slate-200 cursor-pointer has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50/50">
                        <input type="radio" name="role" value="admin" id="role-admin" class="text-blue-600">
                        <span class="text-xs font-bold text-slate-800">Admin Divisi</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap</label>
                <input type="text" name="nama" required placeholder="Contoh: Rani Putri"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Email Pengguna</label>
                <input type="email" name="email" required placeholder="Contoh: rani@gmail.com"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Password Awal (Default: password123)</label>
                <input type="password" name="password" placeholder="Minimal 6 karakter"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex items-center gap-3 pt-3">
                <button type="button" onclick="closeTambahModal()" class="flex-1 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">Batal</button>
                <button type="submit" class="flex-1 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-500/20 transition">Simpan Akun</button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL EDIT AKUN                                                -->
<!-- ============================================================== -->
<div id="modal-edit-akun" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full p-6 sm:p-7 relative">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
            <h3 class="text-lg font-extrabold text-slate-800">Edit Akun Pengguna</h3>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="edit-akun-form" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap</label>
                <input type="text" id="edit-nama" name="nama" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Email</label>
                <input type="email" id="edit-email" name="email" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex items-center gap-3 pt-3">
                <button type="button" onclick="closeEditModal()" class="flex-1 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">Batal</button>
                <button type="submit" class="flex-1 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-500/20 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Modal Tambah logic
function openTambahModal(type) {
    const m = document.getElementById('modal-tambah-akun');
    const roleSiswa = document.getElementById('role-siswa');
    const roleAdmin = document.getElementById('role-admin');
    const title = document.getElementById('modal-tambah-title');
    
    if (type === 'admin') {
        roleAdmin.checked = true;
        title.textContent = 'Tambah Akun Admin Divisi';
    } else {
        roleSiswa.checked = true;
        title.textContent = 'Tambah Akun Siswa Baru';
    }
    m.classList.remove('hidden');
    m.classList.add('flex');
}

function closeTambahModal() {
    const m = document.getElementById('modal-tambah-akun');
    m.classList.add('hidden');
    m.classList.remove('flex');
}

// Modal Edit logic
function openEditModal(id, nama, email, role) {
    const form = document.getElementById('edit-akun-form');
    const routeTemplate = role === 'admin'
        ? @js(route('superadmin.adminDivisi.update', ['id' => '__ID__']))
        : @js(route('superadmin.siswa.update', ['id' => '__ID__']));
    form.action = routeTemplate.replace('__ID__', encodeURIComponent(id));
    document.getElementById('edit-nama').value = nama;
    document.getElementById('edit-email').value = email;
    const m = document.getElementById('modal-edit-akun');
    m.classList.remove('hidden');
    m.classList.add('flex');
}

function closeEditModal() {
    const m = document.getElementById('modal-edit-akun');
    m.classList.add('hidden');
    m.classList.remove('flex');
}

// Confirm Delete logic
function confirmHapus(nama) {
    return confirm('Yakin ingin menghapus akun "' + nama + '"?');
}

// Switch Table tabs if needed on mobile
function switchTableTab(tab) {
    const target = document.getElementById('tabel-kelola-akun');
    if (target) {
        target.scrollIntoView({ behavior: 'smooth' });
    }
}

// ESC closes modals
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeTambahModal();
        closeEditModal();
        const guide = document.getElementById('guide-modal');
        if (guide && !guide.classList.contains('hidden')) {
            guide.classList.add('hidden');
            guide.classList.remove('flex');
        }
    }
});

// Initialize Chart.js Growth Line Chart
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('studentGrowthChart').getContext('2d');
    
    // Gradient fill under the curve
    const gradient = ctx.createLinearGradient(0, 0, 0, 180);
    gradient.addColorStop(0, 'rgba(59, 130, 246, 0.28)');
    gradient.addColorStop(1, 'rgba(59, 130, 246, 0.00)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels ?? []),
            datasets: [{
                label: 'Siswa',
                data: @json($chartData ?? []),
                borderColor: '#3B82F6',
                borderWidth: 2.5,
                pointBackgroundColor: '#3B82F6',
                pointBorderColor: '#FFFFFF',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                tension: 0.35, // smooth curved line
                fill: true,
                backgroundColor: gradient
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#152442',
                    titleColor: '#FFFFFF',
                    bodyColor: '#93C5FD',
                    padding: 10,
                    cornerRadius: 10,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Total Siswa: ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        color: '#94a3b8',
                        font: { size: 10, weight: '500' }
                    }
                },
                y: {
                    min: 0,
                    max: @json($chartMax ?? 10),
                    ticks: {
                        stepSize: @json($chartStep ?? 2),
                        color: '#94a3b8',
                        font: { size: 10, weight: '500' }
                    },
                    grid: {
                        color: '#f1f5f9',
                        drawBorder: false
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection
