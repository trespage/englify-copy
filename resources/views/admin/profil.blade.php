@extends('layouts.admin')

@section('title', 'Profil Admin Divisi')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                Profil Admin Divisi
            </h1>
            <p class="text-slate-500 mt-1 ml-1">Kelola informasi akun dan keamanan data Anda.</p>
        </div>
    </div>

    <!-- Profile Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 h-28 sm:h-32 relative">
            <div class="absolute top-0 right-0 w-40 h-40 opacity-20 -mr-8 -mt-8">
                <svg viewBox="0 0 200 200" class="w-full h-full text-white" fill="currentColor">
                    <circle cx="100" cy="60" r="40"/>
                    <circle cx="60" cy="140" r="35"/>
                    <circle cx="140" cy="140" r="35"/>
                </svg>
            </div>
        </div>
        <div class="px-6 sm:px-8 pb-6">
            <div class="relative flex flex-col sm:flex-row items-center sm:items-end -mt-12 sm:-mt-14 mb-4 gap-4">
                <!-- Avatar -->
                <div class="relative">
                    <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl bg-white p-2 shadow-lg">
                        <div class="w-full h-full rounded-xl bg-gradient-to-br from-purple-400 to-indigo-500 flex items-center justify-center">
                            <img src="{{ asset('images/cat-welcome.png') }}" alt="Avatar" class="w-full h-full object-contain p-1">
                        </div>
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-emerald-500 rounded-full border-4 border-white flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>

                <!-- Name & Info -->
                <div class="text-center sm:text-left sm:flex-1 sm:mb-2">
                    <div class="flex flex-col sm:flex-row items-center gap-2">
                        <h2 class="text-xl sm:text-2xl font-bold text-slate-800">{{ auth()->user()->nama ?? 'Salsabila Putri' }}</h2>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-700">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Admin Divisi
                        </span>
                    </div>
                    <div class="flex flex-col sm:flex-row items-center gap-1 sm:gap-3 mt-1 text-sm text-slate-500">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ auth()->user()->email }}
                        </span>
                        <span class="hidden sm:inline text-slate-300">•</span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5h1.5a1.5 1.5 0 000-3H9V6"/>
                            </svg>
                            {{ auth()->user()->divisi->nama_divisi ?? 'English Club' }}
                        </span>
                        <span class="hidden sm:inline text-slate-300">•</span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Bergabung sejak {{ \Carbon\Carbon::parse(auth()->user()->created_at)->format('j M Y') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="flex gap-1 border-b border-slate-200 mt-6 overflow-x-auto">
                <button onclick="switchTab('informasi')" id="tab-informasi" class="tab-btn px-4 py-3 text-sm font-semibold border-b-2 border-purple-600 text-purple-600 whitespace-nowrap transition">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Informasi Akun
                    </span>
                </button>
                <button onclick="switchTab('password')" id="tab-password" class="tab-btn px-4 py-3 text-sm font-semibold border-b-2 border-transparent text-slate-500 hover:text-slate-700 whitespace-nowrap transition">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Ubah Password
                    </span>
                </button>
                <button onclick="switchTab('keamanan')" id="tab-keamanan" class="tab-btn px-4 py-3 text-sm font-semibold border-b-2 border-transparent text-slate-500 hover:text-slate-700 whitespace-nowrap transition">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        Keamanan
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- Tab Content: Informasi Akun -->
    <div id="content-informasi" class="tab-content">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informasi Akun (2/3) -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Informasi Akun</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Data dasar akun Anda.</p>
                    </div>
                    <button onclick="openEditModal()" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-purple-50 hover:bg-purple-100 text-purple-600 text-xs font-semibold rounded-lg transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </button>
                </div>

                <div class="space-y-1">
                    <!-- Nama Lengkap -->
                    <div class="flex items-center justify-between p-4 rounded-xl hover:bg-slate-50 transition border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-purple-100 flex items-center justify-center shrink-0">
                                <svg class="w-4.5 h-4.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-medium">Nama Lengkap</p>
                                <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->nama ?? 'Salsabila Putri' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Username -->
                    <div class="flex items-center justify-between p-4 rounded-xl hover:bg-slate-50 transition border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                                <svg class="w-4.5 h-4.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-medium">Username</p>
                                <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->username ?? 'salsabilaputri' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex items-center justify-between p-4 rounded-xl hover:bg-slate-50 transition border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                                <svg class="w-4.5 h-4.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-medium">Email</p>
                                <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Divisi -->
                    <div class="flex items-center justify-between p-4 rounded-xl hover:bg-slate-50 transition border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-amber-100 flex items-center justify-center shrink-0">
                                <svg class="w-4.5 h-4.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5h1.5a1.5 1.5 0 000-3H9V6"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-medium">Divisi</p>
                                <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->divisi->nama_divisi ?? 'English Club' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Role -->
                    <div class="flex items-center justify-between p-4 rounded-xl hover:bg-slate-50 transition border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-indigo-100 flex items-center justify-center shrink-0">
                                <svg class="w-4.5 h-4.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-medium">Role</p>
                                <p class="text-sm font-semibold text-slate-800">Admin Divisi</p>
                            </div>
                        </div>
                    </div>

                    <!-- Status Akun -->
                    <div class="flex items-center justify-between p-4 rounded-xl hover:bg-slate-50 transition border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                                <svg class="w-4.5 h-4.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-medium">Status Akun</p>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Aktif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Kanan: Informasi Divisi + Jaga Keamanan -->
            <div class="space-y-4">
                <!-- Informasi Divisi -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Informasi Divisi</h3>
                    <p class="text-xs text-slate-500 mb-4">Detail divisi yang Anda kelola.</p>

                    <div class="flex items-center gap-3 p-3 rounded-xl bg-purple-50 border border-purple-100 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5h1.5a1.5 1.5 0 000-3H9V6"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-slate-800 text-sm">{{ auth()->user()->divisi->nama_divisi ?? 'English Club' }}</p>
                            <p class="text-xs text-slate-500 truncate">Ditunjuk sebagai admin untuk divisi ini</p>
                        </div>
                    </div>

                    <div class="space-y-2 text-xs">
                        <div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-50">
                            <span class="text-slate-500">Total Siswa</span>
                            <span class="font-bold text-slate-800">24</span>
                        </div>
                        <div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-50">
                            <span class="text-slate-500">Total Materi</span>
                            <span class="font-bold text-slate-800">12</span>
                        </div>
                        <div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-50">
                            <span class="text-slate-500">Total Quiz</span>
                            <span class="font-bold text-slate-800">8</span>
                        </div>
                    </div>
                </div>

                <!-- Jaga Keamanan Akun -->
                <div class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 opacity-10 -mr-8 -mt-8">
                        <svg viewBox="0 0 200 200" class="w-full h-full text-white" fill="currentColor">
                            <circle cx="100" cy="60" r="40"/>
                            <circle cx="60" cy="140" r="35"/>
                            <circle cx="140" cy="140" r="35"/>
                        </svg>
                    </div>
                    <div class="relative">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-11 h-11 rounded-xl bg-white/20 flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold">Jaga Keamanan Akun</p>
                                <p class="text-xs text-purple-100">Lindungi data Anda</p>
                            </div>
                        </div>
                        <p class="text-sm text-purple-50 mb-4">Ganti password secara berkala untuk menjaga keamanan akun Anda.</p>
                        <button onclick="switchTab('password')" class="w-full py-2.5 bg-white text-purple-600 font-semibold rounded-xl text-sm hover:bg-purple-50 transition">
                            Ubah Password Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aktivitas Terakhir -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Aktivitas Terakhir</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Riwayat aktivitas akun Anda.</p>
                </div>
                <a href="#" class="text-xs font-bold text-purple-600 hover:text-purple-700 flex items-center gap-1">
                    Lihat Semua
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <div class="space-y-3">
                <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800">Login berhasil</p>
                        <p class="text-xs text-slate-500">Hari ini, 09:30 • IP: 192.168.1.100</p>
                    </div>
                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full shrink-0">Sukses</span>
                </div>

                <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800">Materi baru ditambahkan</p>
                        <p class="text-xs text-slate-500">Kemarin, 14:20 • "Grammar Basics"</p>
                    </div>
                    <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full shrink-0">Materi</span>
                </div>

                <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800">Quiz dipublikasikan</p>
                        <p class="text-xs text-slate-500">2 hari lalu, 10:15 • "Vocabulary Test"</p>
                    </div>
                    <span class="text-xs font-bold text-purple-600 bg-purple-50 px-2.5 py-1 rounded-full shrink-0">Quiz</span>
                </div>

                <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800">Profil diperbarui</p>
                        <p class="text-xs text-slate-500">5 hari lalu, 16:45</p>
                    </div>
                    <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full shrink-0">Update</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Content: Ubah Password -->
    <div id="content-password" class="tab-content hidden">
        <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-1">Ubah Password</h3>
            <p class="text-xs text-slate-500 mb-6">Pastikan password Anda minimal 8 karakter dengan kombinasi huruf dan angka.</p>

            <form class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password Lama</label>
                    <input type="password" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition" placeholder="Masukkan password lama">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password Baru</label>
                    <input type="password" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition" placeholder="Masukkan password baru">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password Baru</label>
                    <input type="password" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition" placeholder="Konfirmasi password baru">
                </div>
                <div class="pt-4 flex gap-3">
                    <button type="button" class="flex-1 px-4 py-2.5 border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 transition">Batal</button>
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-purple-600 text-white font-semibold rounded-xl hover:bg-purple-700 shadow-lg shadow-purple-600/30 transition">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tab Content: Keamanan -->
    <div id="content-keamanan" class="tab-content hidden">
        <div class="max-w-2xl mx-auto space-y-4">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-slate-800">Status Keamanan Akun</h3>
                        <p class="text-sm text-slate-500 mt-1">Akun Anda saat ini dalam kondisi aman.</p>
                        <div class="mt-4 space-y-2">
                            <div class="flex items-center justify-between p-3 bg-emerald-50 rounded-xl">
                                <span class="text-sm font-medium text-slate-700">Password terakhir diubah</span>
                                <span class="text-xs font-bold text-emerald-700">30 hari lalu</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-emerald-50 rounded-xl">
                                <span class="text-sm font-medium text-slate-700">Login terakhir</span>
                                <span class="text-xs font-bold text-emerald-700">Hari ini, 09:30</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-emerald-50 rounded-xl">
                                <span class="text-sm font-medium text-slate-700">Perangkat aktif</span>
                                <span class="text-xs font-bold text-emerald-700">1 perangkat</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Sesi Aktif</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-800">Chrome - Windows</p>
                                <p class="text-xs text-slate-500">192.168.1.100 • Saat ini</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-emerald-600 bg-emerald-100 px-2.5 py-1 rounded-full">Aktif</span>
                    </div>
                </div>
                <button class="mt-4 w-full py-2.5 border border-rose-200 text-rose-600 font-semibold rounded-xl hover:bg-rose-50 transition text-sm">
                    Keluar dari Semua Sesi
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Profil -->
<div id="editModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between sticky top-0 bg-white z-10 rounded-t-3xl">
            <h3 class="text-xl font-bold text-slate-800">Edit Profil</h3>
            <button onclick="closeEditModal()" class="p-2 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                <input type="text" value="{{ auth()->user()->nama ?? 'Salsabila Putri' }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Username</label>
                <input type="text" value="{{ auth()->user()->username ?? 'salsabilaputri' }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                <input type="email" value="{{ auth()->user()->email }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition">
            </div>
            <div class="pt-4 flex gap-3 sticky bottom-0 bg-white pb-1">
                <button type="button" onclick="closeEditModal()" class="flex-1 px-4 py-3 border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 transition">Batal</button>
                <button type="submit" class="flex-1 px-4 py-3 bg-purple-600 text-white font-semibold rounded-xl hover:bg-purple-700 shadow-lg shadow-purple-600/30 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function switchTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    // Show selected tab content
    document.getElementById('content-' + tabName).classList.remove('hidden');

    // Reset all tab buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('border-purple-600', 'text-purple-600');
        btn.classList.add('border-transparent', 'text-slate-500');
    });

    // Highlight active tab button
    const activeBtn = document.getElementById('tab-' + tabName);
    activeBtn.classList.remove('border-transparent', 'text-slate-500');
    activeBtn.classList.add('border-purple-600', 'text-purple-600');
}

function openEditModal() {
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
}
</script>
@endpush
