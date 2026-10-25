@extends('layouts.superadmin')

@section('title', 'Data Sistem')

@section('content')
<div class="space-y-6">
    <!-- Header Section (UPDATED - Sesuai Screenshot) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-sky-100 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Data Sistem</h1>
                <p class="text-slate-500 mt-1">Informasi umum terkait pengguna dan aktivitas sistem.</p>
            </div>
        </div>
        <div class="flex items-center gap-2 text-sm bg-white px-4 py-2.5 rounded-xl border border-slate-200/70 shadow-sm">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <div class="flex items-center gap-2">
                <span class="font-semibold text-slate-700">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
                <span class="text-slate-300">•</span>
                <span class="font-bold text-sky-600">{{ \Carbon\Carbon::now()->format('H:i') }} WIB</span>
            </div>
        </div>
    </div>

    <!-- Welcome Banner (UPDATED - Gradient Biru Sesuai Screenshot) -->
    <div class="bg-gradient-to-r from-sky-600 to-indigo-600 rounded-2xl p-6 sm:p-8 text-white relative overflow-hidden shadow-lg">
        <div class="absolute top-0 right-0 w-64 h-64 opacity-10">
            <svg viewBox="0 0 200 200" class="w-full h-full" fill="currentColor">
                <circle cx="100" cy="60" r="40"/>
                <circle cx="60" cy="140" r="35"/>
                <circle cx="140" cy="140" r="35"/>
            </svg>
        </div>
        <div class="absolute bottom-0 right-0 w-32 h-32 opacity-10">
            <svg viewBox="0 0 200 200" class="w-full h-full" fill="currentColor">
                <circle cx="100" cy="100" r="30"/>
                <circle cx="70" cy="160" r="25"/>
                <circle cx="130" cy="160" r="25"/>
            </svg>
        </div>
        <div class="relative flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex-1">
                <h2 class="text-2xl sm:text-3xl font-bold mb-2">Selamat Datang, Super Admin!</h2>
                <p class="text-sky-100 text-sm sm:text-base">Berikut adalah ringkasan data sistem dan divisi di Englify.</p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 border border-white/30 shadow-lg">
                <p class="font-cute text-lg sm:text-xl text-white leading-tight">Bersama Englify,</p>
                <p class="font-cute text-lg sm:text-xl text-white leading-tight">lebih banyak pembelajaran!</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Siswa -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/70 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-sky-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-bold {{ $siswaGrowth >= 0 ? 'text-emerald-600 bg-emerald-50' : 'text-rose-600 bg-rose-50' }} px-2 py-1 rounded-full">{{ $siswaGrowth }}</span>
            </div>
            <p class="text-sm text-slate-500 font-medium">Total Siswa</p>
            <p class="text-3xl font-bold text-slate-800 mt-1">{{ $totalSiswa }}</p>
            <p class="text-xs text-slate-400 mt-1">dari bulan lalu</p>
        </div>

        <!-- Total Admin Divisi -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/70 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-purple-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <span class="text-xs font-bold {{ $adminGrowth >= 0 ? 'text-emerald-600 bg-emerald-50' : 'text-rose-600 bg-rose-50' }} px-2 py-1 rounded-full">{{ $adminGrowth }}</span>
            </div>
            <p class="text-sm text-slate-500 font-medium">Total Admin Divisi</p>
            <p class="text-3xl font-bold text-slate-800 mt-1">{{ $totalAdmin }}</p>
            <p class="text-xs text-slate-400 mt-1">dari bulan lalu</p>
        </div>

        <!-- Total Divisi -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/70 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-emerald-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5h1.5a1.5 1.5 0 000-3H9V6"/>
                    </svg>
                </div>
                <span class="text-xs font-bold {{ $divisiGrowth >= 0 ? 'text-emerald-600 bg-emerald-50' : 'text-rose-600 bg-rose-50' }} px-2 py-1 rounded-full">{{ $divisiGrowth }}</span>
            </div>
            <p class="text-sm text-slate-500 font-medium">Total Divisi</p>
            <p class="text-3xl font-bold text-slate-800 mt-1">{{ $totalDivisi }}</p>
            <p class="text-xs text-slate-400 mt-1">dari bulan lalu</p>
        </div>

        <!-- Aktivitas Sistem -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/70 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-amber-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <span class="text-xs font-bold text-sky-600 bg-sky-50 px-2 py-1 rounded-full">Real-time</span>
            </div>
            <p class="text-sm text-slate-500 font-medium">Aktivitas Sistem</p>
            <p class="text-3xl font-bold text-slate-800 mt-1">{{ number_format($totalAktivitas, 0, ',', '.') }}</p>
            <p class="text-xs text-slate-400 mt-1">total aktivitas</p>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Line Chart -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/70">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Grafik Pengguna</h3>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="flex items-center gap-1.5 text-xs text-slate-600"><span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span> Siswa</span>
                        <span class="flex items-center gap-1.5 text-xs text-slate-600"><span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span> Admin Divisi</span>
                    </div>
                </div>
                <span class="text-xs font-semibold text-slate-600 bg-slate-50 border border-slate-200/80 rounded-lg px-3 py-1.5">7 Hari Terakhir</span>
            </div>
            <div class="relative h-64">
                <canvas id="userLineChart"></canvas>
            </div>
        </div>

        <!-- Bar Chart -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/70">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Statistik Pengguna</h3>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="flex items-center gap-1.5 text-xs text-slate-600"><span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span> Siswa</span>
                        <span class="flex items-center gap-1.5 text-xs text-slate-600"><span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span> Admin Divisi</span>
                    </div>
                </div>
                <span class="text-xs font-semibold text-slate-600 bg-slate-50 border border-slate-200/80 rounded-lg px-3 py-1.5">7 Hari Terakhir</span>
            </div>
            <div class="relative h-64">
                <canvas id="userBarChart"></canvas>
            </div>
            <div class="mt-4 p-3 bg-sky-50 rounded-xl flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-sky-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-800">Ringkasan 7 hari terakhir</p>
                    <p class="text-xs text-slate-500">{{ $newSiswaCount }} akun siswa baru ({{ $newSiswaGrowth }}) dan {{ $newAdminCount }} admin divisi baru ({{ $newAdminGrowth }}) dibanding 7 hari sebelumnya.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Aktivitas Terbaru + Status Sistem -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Aktivitas Terbaru -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-slate-200/70">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Aktivitas Terbaru
                </h3>
                <a href="{{ route('superadmin.dashboard') }}" class="text-xs font-bold text-sky-600 hover:text-sky-700 flex items-center gap-1">
                    Lihat Semua
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="space-y-3">
                @forelse($recentActivities as $activity)
                    <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition">
                        <div class="w-10 h-10 rounded-xl bg-sky-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-slate-800">{{ $activity->title }}</p>
                            <p class="text-xs text-slate-500">{{ $activity->desc }}</p>
                        </div>
                        <span class="text-xs font-bold text-sky-600 bg-sky-50 px-2.5 py-1 rounded-full shrink-0">{{ $activity->role }}</span>
                    </div>
                @empty
                    <p class="text-sm text-slate-500 text-center py-4">Belum ada aktivitas akun.</p>
                @endforelse
            </div>
        </div>

        <!-- Status Sistem -->
        <div class="space-y-4">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/70">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Status Sistem
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-emerald-50 rounded-xl">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-sm font-semibold text-slate-700">Server</span>
                        </div>
                        <span class="text-xs font-bold text-emerald-700">{{ $systemStatus }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 {{ $warnaDatabase[0] }} rounded-xl">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full {{ $warnaDatabase[2] }} animate-pulse"></span>
                            <span class="text-sm font-semibold text-slate-700">Database</span>
                        </div>
                        <span class="text-xs font-bold {{ $warnaDatabase[1] }}">{{ $statusDatabase }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-xl">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                            <span class="text-sm font-semibold text-slate-700">API</span>
                        </div>
                        <span class="text-xs font-bold text-blue-700">{{ $statusApi }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Info Card -->
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-11 h-11 rounded-xl bg-white/20 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold">Ringkasan Sistem</p>
                        <p class="text-xs text-indigo-100">Data real-time dari database</p>
                    </div>
                </div>
                <div class="flex items-center justify-between text-xs mb-1">
                    <span class="text-indigo-100">Akun aktif</span>
                    <span class="font-bold">{{ $activeAccounts }} / {{ $totalAkun }}</span>
                </div>
                <div class="w-full bg-white/20 rounded-full h-1.5 mb-4">
                    <div class="bg-white h-1.5 rounded-full" style="width: {{ $totalAkun > 0 ? round($activeAccounts / $totalAkun * 100, 1) : 0 }}%"></div>
                </div>
                <div class="flex items-center justify-between text-xs mb-1">
                    <span class="text-indigo-100">Total aktivitas</span>
                    <span class="font-bold">{{ number_format($totalAktivitas, 0, ',', '.') }}</span>
                </div>
                <div class="w-full bg-white/20 rounded-full h-1.5">
                    <div class="bg-white h-1.5 rounded-full" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Divisi Section -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5h1.5a1.5 1.5 0 000-3H9V6"/>
                    </svg>
                    Data Divisi
                </h3>
                <p class="text-sm text-slate-500 mt-1">Informasi jumlah admin dan materi pada setiap divisi.</p>
            </div>
            <a href="{{ route('superadmin.divisi') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition shadow-sm">
                Kelola Divisi
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @php
                $warnaDivisi = [
                    'Speaking'  => ['bg-purple-50', 'border-purple-100', 'bg-purple-100', 'text-purple-600', 'text-purple-700', 'hover:bg-purple-100', 'text-purple-700', 'bg-purple-200', 'bg-purple-500'],
                    'Writing'   => ['bg-emerald-50', 'border-emerald-100', 'bg-emerald-100', 'text-emerald-600', 'text-emerald-700', 'hover:bg-emerald-100', 'text-emerald-700', 'bg-emerald-200', 'bg-emerald-500'],
                    'Reading'   => ['bg-blue-50', 'border-blue-100', 'bg-blue-100', 'text-blue-600', 'text-blue-700', 'hover:bg-blue-100', 'text-blue-700', 'bg-blue-200', 'bg-blue-500'],
                    'Listening' => ['bg-amber-50', 'border-amber-100', 'bg-amber-100', 'text-amber-600', 'text-amber-700', 'hover:bg-amber-100', 'text-amber-700', 'bg-amber-200', 'bg-amber-500'],
                ];
            @endphp
            @forelse($divisi as $d)
                @php
                    [$wBg, $wBorder, $wIcon, $wIconText, $wText, $wHover, $wBtnText, $wTrack, $wFill] = $warnaDivisi[$d['nama']] ?? ['bg-slate-50', 'border-slate-100', 'bg-slate-100', 'text-slate-600', 'text-slate-700', 'hover:bg-slate-100', 'text-slate-700', 'bg-slate-200', 'bg-slate-500'];
                @endphp
                <div class="{{ $wBg }} rounded-2xl p-5 border {{ $wBorder }}">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl {{ $wIcon }} flex items-center justify-center">
                            <svg class="w-5 h-5 {{ $wIconText }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5h1.5a1.5 1.5 0 000-3H9V6"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-slate-800">{{ $d['nama'] }}</p>
                            <p class="text-xs text-slate-500">{{ $d['admin'] }} Admin Divisi</p>
                        </div>
                    </div>
                    <p class="text-sm text-slate-600 mb-2"><span class="font-bold text-slate-800">{{ $d['materi'] }}</span> Materi</p>
                    <div class="w-full {{ $wTrack }} rounded-full h-1.5 mb-3">
                        <div class="{{ $wFill }} h-1.5 rounded-full" style="width: 100%"></div>
                    </div>
                    <a href="{{ route('superadmin.adminDivisi') }}" class="w-full py-2 bg-white {{ $wHover }} {{ $wBtnText }} text-xs font-bold rounded-lg transition flex items-center justify-center gap-1">
                        Lihat Detail
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            @empty
                <p class="col-span-full text-sm text-slate-500 text-center py-4">Belum ada divisi.</p>
            @endforelse
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Line Chart
const lineCtx = document.getElementById('userLineChart').getContext('2d');
new Chart(lineCtx, {
    type: 'line',
    data: {
        labels: @json($chartLabels ?? []),
        datasets: [
            {
                label: 'Siswa',
                data: @json($chartData ?? []),
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 2.5,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#3B82F6',
                pointRadius: 4,
                pointHoverRadius: 6
            },
            {
                label: 'Admin Divisi',
                data: @json($chartAdminData ?? []),
                borderColor: '#A855F7',
                backgroundColor: 'rgba(168, 85, 247, 0.1)',
                borderWidth: 2.5,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#A855F7',
                pointRadius: 4,
                pointHoverRadius: 6
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1e293b',
                titleFont: { size: 13, family: 'Plus Jakarta Sans' },
                bodyFont: { size: 12, family: 'Plus Jakarta Sans' },
                padding: 10,
                cornerRadius: 8
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: '#f1f5f9' },
                ticks: { font: { size: 11, family: 'Plus Jakarta Sans' }, color: '#94a3b8' }
            },
            x: {
                grid: { display: false },
                ticks: { font: { size: 11, family: 'Plus Jakarta Sans' }, color: '#94a3b8' }
            }
        }
    }
});

// Bar Chart
const barCtx = document.getElementById('userBarChart').getContext('2d');
new Chart(barCtx, {
    type: 'bar',
    data: {
        labels: @json($chartLabels ?? []),
        datasets: [
            {
                label: 'Siswa',
                data: @json($chartSiswaHarian ?? []),
                backgroundColor: '#3B82F6',
                borderRadius: 6,
                barPercentage: 0.6
            },
            {
                label: 'Admin Divisi',
                data: @json($chartAdminHarian ?? []),
                backgroundColor: '#A855F7',
                borderRadius: 6,
                barPercentage: 0.6
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1e293b',
                titleFont: { size: 13, family: 'Plus Jakarta Sans' },
                bodyFont: { size: 12, family: 'Plus Jakarta Sans' },
                padding: 10,
                cornerRadius: 8
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: '#f1f5f9' },
                ticks: { font: { size: 11, family: 'Plus Jakarta Sans' }, color: '#94a3b8' }
            },
            x: {
                grid: { display: false },
                ticks: { font: { size: 11, family: 'Plus Jakarta Sans' }, color: '#94a3b8' }
            }
        }
    }
});
</script>
@endpush
