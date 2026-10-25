@extends('layouts.superadmin')

@section('title', 'Data Sistem')

@section('content')
<div class="space-y-6">

    {{-- ============================================================ --}}
    {{-- HEADER                                                       --}}
    {{-- ============================================================ --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-sky-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                    </svg>
                </div>
                Data Sistem
            </h1>
            <p class="text-slate-500 mt-1 ml-1">Pemantauan status, informasi, dan aktivitas sistem Englify.</p>
        </div>
        <div class="flex items-center gap-2 text-sm text-slate-600 bg-white px-4 py-2 rounded-xl border border-slate-200/70 shadow-sm">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="font-semibold">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
            <span class="text-slate-400">•</span>
            <span class="font-semibold text-sky-600">{{ \Carbon\Carbon::now()->format('H:i') }} WIB</span>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- ROW 1: Status Sistem + Informasi Sistem                     --}}
    {{-- ============================================================ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- ---- STATUS SISTEM ---- --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/70">
            <h2 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                Status Sistem
            </h2>
            <div class="space-y-3">
                {{-- Aplikasi --}}
                <div class="flex items-center justify-between p-3 bg-emerald-50 rounded-xl border border-emerald-100">
                    <div class="flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-sm font-semibold text-slate-700">Aplikasi</span>
                    </div>
                    <span class="text-xs font-bold text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded-full">Online</span>
                </div>

                {{-- Database --}}
                <div class="flex items-center justify-between p-3 {{ $dbStatus === 'Online' ? 'bg-emerald-50 border-emerald-100' : 'bg-rose-50 border-rose-100' }} rounded-xl border">
                    <div class="flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full {{ $dbStatus === 'Online' ? 'bg-emerald-500 animate-pulse' : 'bg-rose-500' }}"></span>
                        <span class="text-sm font-semibold text-slate-700">Database</span>
                    </div>
                    <span class="text-xs font-bold {{ $dbStatus === 'Online' ? 'text-emerald-700 bg-emerald-100' : 'text-rose-700 bg-rose-100' }} px-2.5 py-1 rounded-full">
                        {{ $dbStatus }}
                    </span>
                </div>

                {{-- Server --}}
                <div class="flex items-center justify-between p-3 bg-sky-50 rounded-xl border border-sky-100">
                    <div class="flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-sky-500 animate-pulse"></span>
                        <span class="text-sm font-semibold text-slate-700">Server</span>
                    </div>
                    <span class="text-xs font-bold text-sky-700 bg-sky-100 px-2.5 py-1 rounded-full">Aktif</span>
                </div>

                {{-- Environment --}}
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        </svg>
                        <span class="text-sm font-semibold text-slate-700">Environment</span>
                    </div>
                    <span class="text-xs font-bold text-slate-600 bg-slate-200 px-2.5 py-1 rounded-full capitalize">
                        {{ $systemInfo['env'] }}
                    </span>
                </div>
            </div>
        </div>

        {{-- ---- INFORMASI SISTEM ---- --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/70">
            <h2 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-sky-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                Informasi Sistem
            </h2>
            <div class="space-y-3">
                @foreach ([
                    ['label' => 'Nama Aplikasi',   'value' => $systemInfo['app_name']],
                    ['label' => 'Versi Aplikasi',  'value' => $systemInfo['app_version']],
                    ['label' => 'Framework',       'value' => $systemInfo['framework']],
                    ['label' => 'Database',        'value' => $systemInfo['database']],
                    ['label' => 'Server',          'value' => $systemInfo['server']],
                    ['label' => 'PHP',             'value' => $systemInfo['php_version']],
                ] as $item)
                <div class="flex items-center justify-between py-2 border-b border-slate-100 last:border-0">
                    <span class="text-xs text-slate-500 font-medium">{{ $item['label'] }}</span>
                    <span class="text-xs font-bold text-slate-700 text-right max-w-[55%] truncate" title="{{ $item['value'] }}">{{ $item['value'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- ============================================================ --}}
    {{-- ROW 2: Aktivitas Terbaru + Status Akun                      --}}
    {{-- ============================================================ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ---- AKTIVITAS SISTEM TERBARU (2/3) ---- --}}
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-slate-200/70">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-base font-bold text-slate-800 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    Aktivitas Sistem Terbaru
                </h2>
                <span class="text-xs text-slate-400 font-medium">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMM YYYY') }}</span>
            </div>

            @if($recentActivities->isEmpty())
                <div class="flex flex-col items-center justify-center py-16 text-slate-400">
                    <svg class="w-14 h-14 mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <p class="text-sm font-semibold">Belum ada aktivitas tercatat</p>
                    <p class="text-xs mt-1">Aktivitas akan muncul setelah ada akun yang dibuat atau diperbarui.</p>
                </div>
            @else
                <div class="space-y-2">
                    @foreach($recentActivities as $act)
                    @php
                        $isSiswa  = $act['id_role'] == 3;
                        $isNew    = $act['is_new'];
                        $iconBg   = $isSiswa ? ($isNew ? 'bg-sky-100' : 'bg-sky-50')   : ($isNew ? 'bg-purple-100' : 'bg-purple-50');
                        $iconColor= $isSiswa ? 'text-sky-600' : 'text-purple-600';
                        $badge    = $isSiswa ? 'bg-sky-50 text-sky-700' : 'bg-purple-50 text-purple-700';
                        $actionColor = $isNew ? 'text-emerald-600' : 'text-amber-600';
                        $actionBg    = $isNew ? 'bg-emerald-50' : 'bg-amber-50';
                    @endphp
                    <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition group">
                        <div class="w-9 h-9 rounded-xl {{ $iconBg }} flex items-center justify-center shrink-0">
                            @if($isNew)
                                <svg class="w-4 h-4 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <p class="text-sm font-bold text-slate-800">{{ $act['action'] }}</p>
                                <span class="text-[11px] font-bold {{ $actionBg }} {{ $actionColor }} px-2 py-0.5 rounded-full">
                                    {{ $isNew ? 'Baru' : 'Diperbarui' }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 truncate">
                                {{ $act['nama'] }} ({{ $act['role'] }}) &bull;
                                {{ \Carbon\Carbon::parse($act['time'])->locale('id')->diffForHumans() }}
                            </p>
                        </div>
                        <span class="text-[11px] font-bold {{ $badge }} px-2.5 py-1 rounded-full shrink-0">
                            {{ $act['role'] }}
                        </span>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ---- STATUS AKUN + PEMBARUAN TERAKHIR (1/3) ---- --}}
        <div class="space-y-5">

            {{-- Status Akun --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/70">
                <h2 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-sky-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    Status Akun
                </h2>

                {{-- Siswa --}}
                <div class="mb-4">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Siswa</p>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span class="text-xs text-slate-600">Aktif</span>
                            </div>
                            <span class="text-xs font-bold text-slate-800">{{ $accountStats['siswa_aktif'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                                <span class="text-xs text-slate-600">Nonaktif</span>
                            </div>
                            <span class="text-xs font-bold text-slate-800">{{ $accountStats['siswa_nonaktif'] }}</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-1.5 mt-1">
                            @php
                                $siswaPercent = $accountStats['siswa_total'] > 0
                                    ? round(($accountStats['siswa_aktif'] / $accountStats['siswa_total']) * 100)
                                    : 0;
                            @endphp
                            <div class="h-1.5 rounded-full bg-emerald-500 transition-all duration-500" style="width: {{ $siswaPercent }}%"></div>
                        </div>
                        <p class="text-[10px] text-slate-400">{{ $siswaPercent }}% aktif dari total {{ $accountStats['siswa_total'] }} akun</p>
                    </div>
                </div>

                {{-- Admin Divisi --}}
                <div class="border-t border-slate-100 pt-4">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Admin Divisi</p>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                                <span class="text-xs text-slate-600">Aktif</span>
                            </div>
                            <span class="text-xs font-bold text-slate-800">{{ $accountStats['admin_aktif'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                                <span class="text-xs text-slate-600">Nonaktif</span>
                            </div>
                            <span class="text-xs font-bold text-slate-800">{{ $accountStats['admin_nonaktif'] }}</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-1.5 mt-1">
                            @php
                                $adminPercent = $accountStats['admin_total'] > 0
                                    ? round(($accountStats['admin_aktif'] / $accountStats['admin_total']) * 100)
                                    : 0;
                            @endphp
                            <div class="h-1.5 rounded-full bg-purple-500 transition-all duration-500" style="width: {{ $adminPercent }}%"></div>
                        </div>
                        <p class="text-[10px] text-slate-400">{{ $adminPercent }}% aktif dari total {{ $accountStats['admin_total'] }} akun</p>
                    </div>
                </div>
            </div>

            {{-- Informasi Pembaruan Terakhir --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/70">
                <h2 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-violet-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </div>
                    Pembaruan Terakhir
                </h2>
                <div class="space-y-3">
                    <div class="p-3 bg-sky-50 rounded-xl border border-sky-100">
                        <p class="text-xs font-bold text-sky-700 mb-1">Akun Siswa</p>
                        @if($lastUpdate['siswa'])
                            <p class="text-xs text-slate-600 font-semibold">
                                {{ \Carbon\Carbon::parse($lastUpdate['siswa'])->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}
                            </p>
                            <p class="text-[10px] text-slate-400 mt-0.5">
                                {{ \Carbon\Carbon::parse($lastUpdate['siswa'])->locale('id')->diffForHumans() }}
                            </p>
                        @else
                            <p class="text-xs text-slate-400 italic">Belum ada data</p>
                        @endif
                    </div>
                    <div class="p-3 bg-purple-50 rounded-xl border border-purple-100">
                        <p class="text-xs font-bold text-purple-700 mb-1">Akun Admin Divisi</p>
                        @if($lastUpdate['admin'])
                            <p class="text-xs text-slate-600 font-semibold">
                                {{ \Carbon\Carbon::parse($lastUpdate['admin'])->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}
                            </p>
                            <p class="text-[10px] text-slate-400 mt-0.5">
                                {{ \Carbon\Carbon::parse($lastUpdate['admin'])->locale('id')->diffForHumans() }}
                            </p>
                        @else
                            <p class="text-xs text-slate-400 italic">Belum ada data</p>
                        @endif
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-xs font-bold text-slate-600 mb-1">Halaman Dimuat</p>
                        <p class="text-xs text-slate-600 font-semibold">
                            {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}
                        </p>
                        <p class="text-[10px] text-slate-400 mt-0.5">Waktu server saat ini</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
