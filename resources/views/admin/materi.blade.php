@extends('layouts.admin')

@section('title', 'Kelola Materi')

@section('content')
<div class="space-y-6">

    <!-- ===================================================== -->
    <!-- HEADER                                                 -->
    <!-- ===================================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800">Kelola Materi</h1>
                <p class="text-slate-500 text-sm mt-0.5">Buat dan kelola konten pembelajaran per Kategori dan Bab.</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.bab') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-sm transition-all">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                Kelola Bab
            </a>
            <button type="button" onclick="checkAndOpenModal('add')" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-600/30 transition-all active:scale-95 text-sm cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Materi Baru
            </button>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- STATS CARDS                                            -->
    <!-- ===================================================== -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition">
            <div class="w-11 h-11 rounded-xl bg-slate-100 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-500">Total Materi</p>
            <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $totalMateri }}</p>
        </div>

        @foreach($statistikKategori as $stat)
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition">
            <div class="w-11 h-11 rounded-xl {{ $stat['bg'] }} flex items-center justify-center mb-3">
                <svg class="w-5 h-5 {{ $stat['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-500">{{ $stat['nama'] }}</p>
            <p class="text-3xl font-extrabold {{ $stat['text'] }} mt-1">{{ $stat['jumlah'] }}</p>
        </div>
        @endforeach
    </div>

    <!-- ===================================================== -->
    <!-- FILTER BAR                                             -->
    <!-- ===================================================== -->
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200">
        <form method="GET" action="{{ route('admin.materi') }}" class="flex flex-col lg:flex-row gap-3">
            <div class="relative flex-1">
                <svg class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" id="searchInput" name="q" value="{{ request('q') }}" placeholder="Cari judul materi..."
                       class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
            </div>
            <select id="kategoriFilter" name="kategori" class="w-full lg:w-auto px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 cursor-pointer">
                <option value="">Semua Kategori</option>
                @foreach($kategoriList as $kategori)
                    <option value="{{ $kategori->id_kategori }}" @selected(request('kategori') == $kategori->id_kategori)>{{ $kategori->nama_kategori }}</option>
                @endforeach
            </select>
            <select id="babFilter" name="bab" class="w-full lg:w-auto px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 cursor-pointer">
                <option value="">Semua Bab</option>
                @foreach($babList as $bab)
                    @php
                        $katPrefix = $bab->kategori?->nama_kategori ? '[' . $bab->kategori->nama_kategori . '] ' : '';
                        $labelBab  = $katPrefix . $bab->formatted_judul;
                    @endphp
                    <option value="{{ $bab->judul }}" @selected(request('bab') == $bab->judul || request('bab') == $bab->id)>{{ $labelBab }}</option>
                @endforeach
            </select>
            <button type="submit" class="w-full lg:w-auto px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition">
                Terapkan
            </button>
            @if(request()->hasAny(['q', 'kategori', 'bab']))
                <a href="{{ route('admin.materi') }}" class="w-full lg:w-auto px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold rounded-xl transition text-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- ===================================================== -->
    <!-- PENGELOMPOKAN MATERI BERDASARKAN BAB                   -->
    <!-- ===================================================== -->
    @php
        $catBadgeColors = [
            'Speaking'  => ['bg' => 'bg-rose-500', 'bg_light' => 'bg-rose-50', 'text' => 'text-rose-700', 'border' => 'border-rose-200', 'icon_bg' => 'bg-rose-100 text-rose-600'],
            'Writing'   => ['bg' => 'bg-blue-500', 'bg_light' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'icon_bg' => 'bg-blue-100 text-blue-600'],
            'Reading'   => ['bg' => 'bg-emerald-500', 'bg_light' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'icon_bg' => 'bg-emerald-100 text-emerald-600'],
            'Listening' => ['bg' => 'bg-purple-500', 'bg_light' => 'bg-purple-50', 'text' => 'text-purple-700', 'border' => 'border-purple-200', 'icon_bg' => 'bg-purple-100 text-purple-600'],
        ];
    @endphp

    <div class="space-y-5">
        @forelse($babsGrouped as $babGroup)
            @php
                $c = $catBadgeColors[$babGroup['nama_kategori']] ?? [
                    'bg' => 'bg-slate-500', 'bg_light' => 'bg-slate-50', 'text' => 'text-slate-700', 'border' => 'border-slate-200', 'icon_bg' => 'bg-slate-100 text-slate-600'
                ];
            @endphp
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/90 overflow-hidden transition hover:shadow-md">
                <!-- Bab Header -->
                <div class="px-5 sm:px-6 py-4 bg-slate-50/80 border-b border-slate-200/80 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center gap-3.5 min-w-0">
                        <div class="w-10 h-10 rounded-xl {{ $c['icon_bg'] }} flex items-center justify-center shrink-0 font-extrabold text-sm shadow-xs">
                            {{ $babGroup['urutan'] }}
                        </div>
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="font-extrabold text-slate-800 text-sm sm:text-base break-words">
                                    Bab {{ $babGroup['urutan'] }}: {{ $babGroup['judul'] }}
                                </h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-extrabold border {{ $c['bg_light'] }} {{ $c['text'] }} {{ $c['border'] }}">
                                    {{ $babGroup['nama_kategori'] }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">
                                {{ $babGroup['total'] }} Materi terdaftar di bab ini
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 self-start sm:self-auto shrink-0">
                        <button type="button" onclick="openModalWithBab({{ $babGroup['id_kategori'] }}, {{ $babGroup['id'] }})"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold rounded-xl text-xs transition active:scale-95 cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            <span>Materi ke Bab Ini</span>
                        </button>
                        <button type="button" onclick="toggleBabSection('bab-section-{{ $babGroup['id'] }}', this)"
                                class="p-1.5 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-200/60 transition cursor-pointer" title="Ciutkan / Rentangkan Bab">
                            <svg class="w-5 h-5 transition-transform duration-200 chevron-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Bab Content (List / Table of Materi) -->
                <div id="bab-section-{{ $babGroup['id'] }}" class="bab-content-area">
                    @if($babGroup['total'] > 0)
                        <!-- Desktop Table View -->
                        <div class="hidden md:block overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-white border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                                    <tr>
                                        <th class="px-6 py-3.5 text-left w-14">No</th>
                                        <th class="px-6 py-3.5 text-left">Judul Materi</th>
                                        <th class="px-6 py-3.5 text-center">Urutan</th>
                                        <th class="px-6 py-3.5 text-center">Lampiran</th>
                                        <th class="px-6 py-3.5 text-center">Status</th>
                                        <th class="px-6 py-3.5 text-left">Tanggal Dibuat</th>
                                        <th class="px-6 py-3.5 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($babGroup['materi'] as $mIndex => $item)
                                    <tr class="hover:bg-slate-50/80 transition group">
                                        <td class="px-6 py-4 text-sm font-semibold text-slate-500">{{ $mIndex + 1 }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-xs">
                                                    {{ substr($item['judul'], 0, 1) }}
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="font-bold text-slate-800 text-sm truncate max-w-xs sm:max-w-md">{{ $item['judul'] }}</p>
                                                    <p class="text-[11px] text-slate-400 mt-0.5">ID: #{{ $item['id'] }} • {{ $item['quiz_count'] }} Soal Kuis</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-bold bg-slate-100 text-slate-700">
                                                Urutan {{ $item['urutan'] ?: ($mIndex + 1) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="inline-flex items-center gap-1">
                                                @if(!empty($item['file']))
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 text-[10px] font-semibold" title="File dokumen">
                                                        📄 File
                                                    </span>
                                                @endif
                                                @if(!empty($item['gambar']))
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 text-[10px] font-semibold" title="Cover gambar">
                                                        🖼️ Gambar
                                                    </span>
                                                @endif
                                                @if(!empty($item['url']))
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-purple-50 text-purple-700 text-[10px] font-semibold" title="URL video/eksternal">
                                                        🔗 Link
                                                    </span>
                                                @endif
                                                @if(empty($item['file']) && empty($item['gambar']) && empty($item['url']))
                                                    <span class="text-xs text-slate-400">-</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if(strtolower($item['status']) === 'published')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    Published
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-50 text-amber-700 border border-amber-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                    Draft
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-xs text-slate-500 whitespace-nowrap">{{ $item['tanggal'] }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="inline-flex items-center justify-center gap-1.5">
                                                <button onclick="openPreviewPOV({{ json_encode($item) }})" class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition cursor-pointer flex items-center gap-1" title="Lihat POV Siswa">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                    <span class="text-xs font-bold">POV</span>
                                                </button>
                                                <button onclick="editMateri({{ $item['id'] }})" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition cursor-pointer" title="Edit Materi">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </button>
                                                <button onclick="deleteMateri({{ $item['id'] }})" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition cursor-pointer" title="Hapus Materi">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card View per Bab -->
                        <div class="md:hidden divide-y divide-slate-100 p-3.5 space-y-3">
                            @foreach($babGroup['materi'] as $mIndex => $item)
                            <div class="p-3 bg-slate-50/70 rounded-xl border border-slate-200/70 space-y-2">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <div class="w-8 h-8 rounded-lg bg-blue-600 text-white font-bold text-xs flex items-center justify-center shrink-0">
                                            {{ substr($item['judul'], 0, 1) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-bold text-slate-800 text-sm truncate">{{ $item['judul'] }}</p>
                                            <p class="text-[10px] text-slate-400">Urutan {{ $item['urutan'] ?: ($mIndex + 1) }} • {{ $item['quiz_count'] }} Kuis</p>
                                        </div>
                                    </div>
                                    @if(strtolower($item['status']) === 'published')
                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200 shrink-0">Published</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-amber-50 text-amber-700 border border-amber-200 shrink-0">Draft</span>
                                    @endif
                                </div>
                                <div class="flex items-center justify-between pt-2 border-t border-slate-200/60 text-xs">
                                    <span class="text-[10px] text-slate-400">{{ $item['tanggal'] }}</span>
                                    <div class="flex items-center gap-1.5">
                                        <button onclick="openPreviewPOV({{ json_encode($item) }})" class="px-2 py-1 bg-emerald-50 text-emerald-700 font-bold rounded-lg text-[11px] flex items-center gap-1">
                                            <span>POV</span>
                                        </button>
                                        <button onclick="editMateri({{ $item['id'] }})" class="px-2.5 py-1 bg-blue-50 text-blue-600 font-bold rounded-lg text-[11px]">Edit</button>
                                        <button onclick="deleteMateri({{ $item['id'] }})" class="px-2.5 py-1 bg-rose-50 text-rose-600 font-bold rounded-lg text-[11px]">Hapus</button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <!-- State jika bab belum ada materi -->
                        <div class="px-6 py-8 text-center text-slate-400 bg-white">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center mx-auto mb-2 text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                            <p class="text-xs font-semibold text-slate-500">Belum ada materi pembelajaran pada bab ini.</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">Materi yang ditambahkan ke bab ini akan tersusun rapi secara berurutan.</p>
                            <button type="button" onclick="openModalWithBab({{ $babGroup['id_kategori'] }}, {{ $babGroup['id'] }})"
                                    class="mt-3 inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-sm shadow-blue-600/30 transition cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                <span>Tambah Materi Pertama</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl p-10 text-center border border-slate-200">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <h4 class="text-base font-extrabold text-slate-800">Belum Ada Bab atau Materi</h4>
                <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto">
                    Materi harus memiliki Bab dan tidak bisa dibuat tanpa Bab. Silakan buat Bab kurikulum terlebih dahulu sebelum menambahkan materi.
                </p>
                <div class="mt-4 flex items-center justify-center gap-3">
                    <button type="button" onclick="openQuickAddBabModal()" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-md shadow-blue-600/20 transition cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        <span>Buat Bab Sekarang</span>
                    </button>
                    <a href="{{ route('admin.bab') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
                        Kelola Bab
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>

<!-- ===================================================== -->
<!-- MODAL TAMBAH/EDIT MATERI (KATEGORI -> BAB -> MATERI)   -->
<!-- ===================================================== -->
<div id="materiModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-3 sm:p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between sticky top-0 bg-white z-10 rounded-t-3xl">
            <div>
                <h3 id="modalTitle" class="text-xl font-bold text-slate-800">Tambah Materi Baru</h3>
                <p class="text-xs text-slate-500 mt-0.5">Isi detail materi pembelajaran</p>
            </div>
            <button onclick="closeModal()" class="p-2 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="materiForm" class="p-6 space-y-4" method="POST" action="{{ route('admin.materi.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="materiMethod" value="">
            <input type="hidden" id="materiId" name="id">

            @if($errors->any())
                <div class="rounded-xl bg-rose-50 border border-rose-200 p-4">
                    <p class="text-sm font-bold text-rose-700 mb-1">Periksa kembali isian berikut:</p>
                    <ul class="text-xs text-rose-600 list-disc pl-5 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Judul -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Materi <span class="text-rose-500">*</span></label>
                <input type="text" id="inputJudul" name="judul" required value="{{ old('judul') }}"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition"
                       placeholder="Contoh: Daily Greetings">
            </div>

            <!-- Kategori & Bab (Struktur Langsung) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori <span class="text-rose-500">*</span></label>
                    <select id="inputKategori" name="id_kategori" required onchange="onKategoriChanged(this.value)"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoriList as $kategori)
                            <option value="{{ $kategori->id_kategori }}" @selected(old('id_kategori') == $kategori->id_kategori)>{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-sm font-semibold text-slate-700">Bab <span class="text-rose-500">*</span></label>
                        <button type="button" onclick="openQuickAddBabModal()" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition">
                            + Buat Bab Baru
                        </button>
                    </div>
                    <select id="inputBab" name="id_bab" required onchange="onBabSelected(this.value)"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        <option value="">Pilih Kategori terlebih dahulu</option>
                    </select>
                </div>
            </div>

            <!-- Alert jika kategori belum memiliki bab -->
            <div id="noBabWarning" class="hidden p-3.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs flex items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <span class="text-base shrink-0">⚠️</span>
                    <span>Kategori ini belum memiliki Bab. Materi <strong>tidak bisa dibuat</strong> jika tidak memiliki Bab.</span>
                </div>
                <button type="button" onclick="openQuickAddBabModal()" class="px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-white rounded-lg font-bold text-xs shrink-0 cursor-pointer shadow-xs transition">
                    + Buat Bab Sekarang
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Urutan (Opsional)</label>
                    <input type="number" id="inputUrutan" name="urutan" min="1" value="{{ old('urutan') }}"
                           placeholder="Otomatis"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                    <select id="inputStatus" name="status"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        <option value="Draft">Draft</option>
                        <option value="Published">Published</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center justify-between">
                        <span>Batas Waktu Quiz <span class="text-rose-500">*</span></span>
                        <span class="text-[10px] text-amber-600 font-medium">Auto-submit</span>
                    </label>
                    <div class="relative">
                        <input type="number" id="inputDurasiMenit" name="durasi_menit" min="1" max="300" required value="15" placeholder="15"
                               class="w-full pl-9 pr-14 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition font-semibold text-slate-800">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="absolute right-3.5 top-2.5 text-xs font-bold text-slate-400">Menit</span>
                    </div>
                </div>
            </div>

            <!-- Multiple Sumber URL -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-sm font-semibold text-slate-700">
                        Sumber URL / Tautan Materi <span class="text-slate-400 font-normal">(Video YouTube / Tautan Referensi)</span>
                    </label>
                    <button type="button" onclick="addUrlInputRow()" class="inline-flex items-center gap-1 text-xs font-bold text-blue-600 hover:text-blue-800 transition cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Tambah URL Lain</span>
                    </button>
                </div>
                <div id="urlInputsContainer" class="space-y-2.5">
                    <!-- Dynamic URL Rows via JS -->
                </div>
                <p class="text-[11px] text-slate-400 mt-1.5">Mendukung input lebih dari 1 link (YouTube dan referensi belajar online).</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Singkat</label>
                <textarea id="inputDeskripsi" name="deskripsi" rows="2"
                          class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition resize-none"
                          placeholder="Ringkasan singkat isi materi...">{{ old('deskripsi') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Konten Materi <span class="text-rose-500">*</span></label>
                <textarea id="inputKonten" name="isi_materi" rows="6" required
                          class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition resize-none"
                          placeholder="Tulis konten teks lengkap materi di sini...">{{ old('isi_materi') }}</textarea>
            </div>

            <!-- Gambar Ilustrasi Materi -->
            <div class="border-t border-slate-200 pt-4 mt-2">
                <!-- UPLOAD GAMBAR -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Upload Gambar Ilustrasi <span class="text-slate-400 font-normal">(JPG, PNG, JPEG - Max 2MB)</span>
                    </label>
                    <div class="flex items-center gap-3">
                        <label class="flex-1 cursor-pointer group">
                            <div id="imageUploadArea" class="border-2 border-dashed border-slate-300 rounded-xl p-3 hover:border-blue-500 hover:bg-blue-50/50 transition text-center">
                                <svg class="w-8 h-8 text-slate-400 group-hover:text-blue-500 mx-auto mb-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-xs text-slate-500 font-medium">Klik untuk upload gambar</p>
                            </div>
                            <input type="file" id="inputGambar" name="gambar" accept="image/*" class="hidden" onchange="previewImage(this)">
                        </label>

                        <div id="imagePreview" class="hidden relative w-24 h-24 rounded-xl overflow-hidden border border-slate-200 shadow-sm">
                            <img src="" alt="Preview" class="w-full h-full object-cover">
                            <button type="button" onclick="removeImage()" class="absolute top-1 right-1 w-5 h-5 bg-rose-500 text-white rounded-full flex items-center justify-center hover:bg-rose-600 transition shadow-md">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="pt-4 flex gap-3 border-t border-slate-100">
                <button type="button" onclick="closeModal()" class="flex-1 px-4 py-2.5 border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 transition">
                    Batal
                </button>
                <button type="submit" id="btnSubmitMateri" class="flex-1 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-600/30 transition cursor-pointer">
                    Simpan Materi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-sm w-full p-6 text-center">
        <div class="w-14 h-14 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-slate-800 mb-1">Hapus Materi Ini?</h3>
        <p class="text-xs text-slate-500 mb-6">Tindakan ini permanen dan akan menghapus data materi dari database.</p>
        <form id="deleteForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex gap-3">
                <button type="button" onclick="closeDeleteModal()" class="flex-1 py-2.5 border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 transition text-sm">
                    Batal
                </button>
                <button type="submit" class="flex-1 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-semibold rounded-xl transition text-sm">
                    Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ===================================================== -->
<!-- MODAL CEPAT TAMBAH BAB                                -->
<!-- ===================================================== -->
<div id="quickAddBabModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[60] hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all animate-in fade-in zoom-in-95 duration-200">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/75">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                <h3 class="text-base font-extrabold text-slate-800">Tambah Bab Baru</h3>
            </div>
            <button type="button" onclick="closeQuickAddBabModal()" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-200 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="quickAddBabForm" onsubmit="submitQuickAddBab(event)" class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Kategori / Divisi <span class="text-rose-500">*</span></label>
                <select id="quickBabKategori" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoriList as $kategori)
                        <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Judul Bab <span class="text-rose-500">*</span></label>
                <input type="text" id="quickBabJudul" required placeholder="Contoh: Daily Small Talk, Simple Present"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Nomor Urutan (Opsional)</label>
                <input type="number" id="quickBabUrutan" min="1" placeholder="Otomatis nomor selanjutnya jika dikosongkan"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
            </div>
            <div id="quickBabAlert" class="hidden p-3 rounded-xl text-xs"></div>
            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeQuickAddBabModal()" class="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 text-xs font-bold hover:bg-slate-50 transition">
                    Batal
                </button>
                <button type="submit" id="btnSubmitQuickBab" class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-lg shadow-blue-600/30 transition">
                    Simpan Bab
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL PREVIEW POV SISWA                                        -->
<!-- ============================================================== -->
<div id="previewPovModal" class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm z-50 hidden items-center justify-center p-2 sm:p-4 overflow-y-auto">
    <div id="previewModalContainer" class="bg-slate-100 rounded-3xl shadow-2xl border-2 border-slate-300 w-full max-w-5xl overflow-hidden my-auto transform transition-all duration-300 flex flex-col max-h-[92vh]">
        
        <!-- Modal Top Bar -->
        <div class="bg-white border-b border-slate-200 px-5 py-3.5 flex items-center justify-between shrink-0 shadow-xs">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-300 flex items-center justify-center font-bold">
                    👁️
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-extrabold text-slate-800">Pratinjau Materi (POV Siswa)</span>
                        <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-300">Live Simulation</span>
                    </div>
                    <p class="text-[11px] text-slate-600 font-medium">Simulasi bagaimana siswa melihat konten materi ini di layar mereka.</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <!-- Device View Switcher -->
                <div class="flex items-center bg-slate-100 border border-slate-200 p-1 rounded-xl text-xs font-semibold">
                    <button type="button" onclick="setPreviewDevice('desktop')" id="btnDeviceDesktop" class="px-2.5 py-1 rounded-lg bg-white text-slate-800 font-bold shadow-xs transition flex items-center gap-1 cursor-pointer">
                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>Desktop</span>
                    </button>
                    <button type="button" onclick="setPreviewDevice('mobile')" id="btnDeviceMobile" class="px-2.5 py-1 rounded-lg text-slate-600 hover:text-slate-900 transition flex items-center gap-1 cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        <span>Mobile</span>
                    </button>
                </div>

                <button type="button" onclick="closePreviewPOV()" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition cursor-pointer" title="Tutup Pratinjau">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <!-- Scrollable POV Viewport -->
        <div class="p-4 sm:p-6 overflow-y-auto flex-1 flex justify-center bg-slate-200/60">
            <div id="previewDeviceFrame" class="w-full max-w-4xl transition-all duration-300">
                <div class="bg-white rounded-2xl border border-[#97CADB]/40 shadow-md overflow-hidden">
                    
                    <!-- Banner -->
                    <div class="w-full h-40 bg-gradient-to-br from-[#D6EBEE] via-[#97CADB]/20 to-[#97CADB]/40 flex items-center justify-center relative overflow-hidden">
                        <div class="text-center relative z-10">
                            <div class="w-16 h-16 mx-auto mb-2 rounded-2xl bg-white/80 backdrop-blur flex items-center justify-center shadow-md">
                                <svg class="w-8 h-8 text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <p class="font-cute text-xl text-[#018ABE]">Let's Learn! 📚</p>
                        </div>
                    </div>

                    <!-- Body Content -->
                    <div class="p-5 sm:p-7 space-y-5">
                        <!-- Badges -->
                        <div class="flex flex-wrap items-center gap-2 pb-4 border-b border-slate-100">
                            <span id="povKategoriBadge" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border">
                                Kategori
                            </span>
                            <span id="povBabBadge" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-[#D6EBEE] text-[#02457A] border border-[#97CADB]/40">
                                Bab
                            </span>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                ~10 menit baca
                            </span>
                        </div>

                        <!-- Title -->
                        <h2 id="povJudul" class="text-xl sm:text-2xl font-extrabold text-slate-800 tracking-tight break-words content-text-wrap" style="overflow-wrap: anywhere; word-break: break-word;">Judul Materi</h2>

                        <!-- Deskripsi -->
                        <div id="povDeskripsiWrapper" class="p-4 rounded-2xl bg-blue-50/70 border border-blue-100 flex items-start gap-3 max-w-full overflow-hidden">
                            <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 font-bold text-sm">💬</div>
                            <div class="min-w-0 flex-1">
                                <h4 class="text-[11px] font-bold uppercase tracking-wider text-blue-900 mb-0.5">Deskripsi & Pengantar</h4>
                                <p id="povDeskripsi" class="text-xs sm:text-sm text-slate-700 leading-relaxed font-normal break-words content-text-wrap" style="overflow-wrap: anywhere; word-break: break-word;"></p>
                            </div>
                        </div>

                        <!-- Gambar -->
                        <div id="povGambarWrapper" class="rounded-2xl overflow-hidden border border-slate-200 bg-slate-50">
                            <div class="px-4 py-2 bg-slate-100 border-b border-slate-200 text-xs font-semibold text-slate-600">
                                🖼️ Gambar Ilustrasi Materi
                            </div>
                            <div class="p-3 flex justify-center bg-slate-100/30">
                                <img id="povGambar" src="" alt="Ilustrasi" class="max-h-80 w-auto max-w-full rounded-xl object-contain shadow-xs">
                            </div>
                        </div>

                        <!-- Isi Materi -->
                        <div class="space-y-1.5">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Isi Materi Pembelajaran</h4>
                            <div id="povKonten" class="text-slate-800 leading-relaxed text-sm sm:text-base whitespace-pre-line break-words content-text-wrap bg-slate-50/70 rounded-2xl p-4 sm:p-5 border border-slate-200/80 max-w-full overflow-hidden" style="overflow-wrap: anywhere; word-break: break-word;"></div>
                        </div>

                        <!-- Video / Multiple URLs -->
                        <div id="povUrlWrapper" class="space-y-3"></div>

                        <!-- File Dokumen (Legacy) -->
                        <div id="povFileWrapper" class="hidden"></div>

                        <!-- Contoh -->
                        <div id="povContohWrapper" class="p-4 bg-[#D6EBEE] border-l-4 border-[#018ABE] rounded-r-2xl max-w-full overflow-hidden">
                            <p class="text-xs font-bold text-[#001B48] mb-1 flex items-center gap-1"><span>💡</span> Contoh:</p>
                            <div id="povContoh" class="text-xs sm:text-sm text-[#02457A] leading-relaxed whitespace-pre-line break-words content-text-wrap" style="overflow-wrap: anywhere; word-break: break-word;"></div>
                        </div>

                        <!-- Tips -->
                        <div id="povTipsWrapper" class="p-4 bg-amber-50 border-l-4 border-amber-500 rounded-r-2xl max-w-full overflow-hidden">
                            <p class="text-xs font-bold text-amber-800 mb-1 flex items-center gap-1"><span>⭐</span> Tips Belajar:</p>
                            <div id="povTips" class="text-xs sm:text-sm text-amber-800 leading-relaxed whitespace-pre-line break-words content-text-wrap" style="overflow-wrap: anywhere; word-break: break-word;"></div>
                        </div>

                        <!-- Kuis Mandiri -->
                        <div class="p-5 bg-gradient-to-br from-[#02457A] via-[#018ABE] to-[#45B69C] rounded-2xl text-white shadow-md flex items-center justify-between gap-4">
                            <div>
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[9px] font-extrabold uppercase tracking-wider bg-white/20 mb-1">
                                    🎯 Kuis Mandiri Siswa
                                </span>
                                <h4 class="text-base font-bold">Kuis Materi Ini</h4>
                                <p class="text-xs text-sky-100 mt-0.5">Siswa akan diarahkan untuk mengerjakan kuis setelah membaca materi ini.</p>
                            </div>
                            <span class="px-4 py-2 bg-white text-[#001B48] font-bold text-xs rounded-xl shadow shrink-0">Mulai Kuis</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function escapeHtml(text) {
    if (!text) return '';
    return text.toString()
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

const DAFTAR_MATERI = @json($materiList);
const URL_STORE     = @json(route('admin.materi.store'));
const URL_UPDATE    = @json(route('admin.materi.update', ['__ID__']));
let TOTAL_BABS      = {{ $babList->count() }};

// =============================================
// VALIDASI SEBELUM BUKA MODAL (BAB WAJIB ADA)
// =============================================
function checkAndOpenModal(type = 'add') {
    if (type === 'add' && TOTAL_BABS === 0) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: 'Bab Kurikulum Belum Ada',
                html: '<p class="text-sm text-slate-600">Materi harus memiliki Bab dan tidak bisa dibuat tanpa Bab.<br>Silakan buat Bab terlebih dahulu.</p>',
                showCancelButton: true,
                confirmButtonText: '+ Buat Bab Sekarang',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                customClass: {
                    popup: 'englify-swal',
                    confirmButton: 'englify-swal-confirm',
                    cancelButton: 'englify-swal-cancel'
                }
            }).then((res) => {
                if (res.isConfirmed) {
                    openQuickAddBabModal();
                }
            });
        } else {
            openQuickAddBabModal();
        }
        return;
    }
    openModal(type);
}

// =============================================
// DROPDOWN BAB DINAMIS DARI KATEGORI (AJAX)
// =============================================
function fetchBabs(kategoriId, selectedBabId = null) {
    const babSelect = document.getElementById('inputBab');
    const warningEl = document.getElementById('noBabWarning');
    const submitBtn = document.getElementById('btnSubmitMateri');

    babSelect.innerHTML = '<option value="">Memuat daftar bab...</option>';
    babSelect.disabled = true;

    if (!kategoriId) {
        babSelect.innerHTML = '<option value="">Pilih Kategori terlebih dahulu</option>';
        babSelect.disabled = false;
        if (warningEl) warningEl.classList.add('hidden');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            submitBtn.title = 'Pilih Kategori dan Bab terlebih dahulu';
        }
        return;
    }

    fetch(`/admin/api/babs-by-kategori/${kategoriId}`)
        .then(res => res.json())
        .then(data => {
            if (data.length === 0) {
                babSelect.innerHTML = '<option value="">-- Belum ada Bab di kategori ini --</option>';
                if (warningEl) warningEl.classList.remove('hidden');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    submitBtn.title = 'Materi tidak bisa dibuat jika belum memiliki Bab';
                }
            } else {
                babSelect.innerHTML = '<option value="">-- Pilih Bab --</option>';
                data.forEach(bab => {
                    const isSelected = selectedBabId && Number(bab.id) === Number(selectedBabId) ? 'selected' : '';
                    const cleanJudul = (bab.judul || '').replace(/^bab\s*(\d+)?\s*[:.-]?\s*/i, '').trim() || bab.judul;
                    babSelect.innerHTML += `<option value="${bab.id}" ${isSelected}>Bab ${bab.urutan}: ${cleanJudul}</option>`;
                });
                if (warningEl) warningEl.classList.add('hidden');
                if (selectedBabId) {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                        submitBtn.title = '';
                    }
                } else {
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                        submitBtn.title = 'Pilih Bab terlebih dahulu';
                    }
                }
            }
            babSelect.disabled = false;
        })
        .catch(err => {
            console.error('Error fetching babs:', err);
            babSelect.innerHTML = '<option value="">Gagal memuat bab</option>';
            babSelect.disabled = false;
        });
}

function onKategoriChanged(kategoriId) {
    fetchBabs(kategoriId);
}

function onBabSelected(babId) {
    const submitBtn = document.getElementById('btnSubmitMateri');
    if (submitBtn) {
        if (babId && babId !== '') {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            submitBtn.title = '';
        } else {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            submitBtn.title = 'Materi wajib memiliki Bab';
        }
    }
}

// =============================================
// MODAL FUNCTIONS
// =============================================
function openModal(type = 'add', materi = null) {
    const modal = document.getElementById('materiModal');
    const title = document.getElementById('modalTitle');
    const form  = document.getElementById('materiForm');
    const warningEl = document.getElementById('noBabWarning');
    const submitBtn = document.getElementById('btnSubmitMateri');

    removeImage();
    if (warningEl) warningEl.classList.add('hidden');

    if (type === 'edit' && materi) {
        title.textContent = 'Edit Materi';
        form.action = URL_UPDATE.replace('__ID__', materi.id);
        document.getElementById('materiMethod').value = 'PUT';
        document.getElementById('materiId').value     = materi.id;
        document.getElementById('inputJudul').value    = materi.judul || '';
        document.getElementById('inputKategori').value = materi.id_kategori || '';
        document.getElementById('inputStatus').value   = materi.status || 'Draft';
        if (document.getElementById('inputUrutan')) {
            document.getElementById('inputUrutan').value = materi.urutan || '';
        }
        if (document.getElementById('inputDurasiMenit')) {
            document.getElementById('inputDurasiMenit').value = materi.durasi_menit || 15;
        }
        document.getElementById('inputDeskripsi').value= materi.deskripsi || '';
        document.getElementById('inputKonten').value   = materi.konten || '';

        // Muat URL-URL materi
        const initialUrls = (Array.isArray(materi.urls) && materi.urls.length > 0)
            ? materi.urls
            : (materi.url ? [materi.url] : ['']);
        renderUrlInputs(initialUrls);

        // Muat bab dari kategori materi ini dan pilih id_bab
        fetchBabs(materi.id_kategori, materi.id_bab);

        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            submitBtn.title = '';
        }

        if (materi.gambar) {
            document.getElementById('imagePreview').querySelector('img').src = `/${materi.gambar}`;
            document.getElementById('imagePreview').classList.remove('hidden');
            document.getElementById('imageUploadArea').classList.add('hidden');
        }
    } else {
        title.textContent = 'Tambah Materi Baru';
        form.reset();
        form.action = URL_STORE;
        document.getElementById('materiMethod').value = '';
        document.getElementById('materiId').value     = '';
        if (document.getElementById('inputUrutan')) {
            document.getElementById('inputUrutan').value = '';
        }
        if (document.getElementById('inputDurasiMenit')) {
            document.getElementById('inputDurasiMenit').value = 15;
        }
        renderUrlInputs(['']);
        document.getElementById('inputBab').innerHTML = '<option value="">Pilih Kategori terlebih dahulu</option>';

        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            submitBtn.title = 'Pilih Kategori dan Bab terlebih dahulu';
        }
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function openModalWithBab(kategoriId, babId) {
    openModal('add');
    const katSelect = document.getElementById('inputKategori');
    if (katSelect) {
        katSelect.value = kategoriId;
        fetchBabs(kategoriId, babId);
    }
}

function toggleBabSection(sectionId, btn) {
    const el = document.getElementById(sectionId);
    if (!el) return;
    el.classList.toggle('hidden');
    const chevron = btn ? btn.querySelector('.chevron-icon') : null;
    if (chevron) {
        chevron.classList.toggle('rotate-180');
    }
}

function closeModal() {
    document.getElementById('materiModal').classList.add('hidden');
    document.getElementById('materiModal').classList.remove('flex');
    document.getElementById('materiForm').reset();
    removeImage();
}

function editMateri(id) {
    const materi = DAFTAR_MATERI.find(item => item.id == id);
    if (!materi) {
        if (typeof window.showAlert === 'function') {
            window.showAlert('Data Tidak Ditemukan', 'Data materi yang dipilih tidak ditemukan.', 'warning');
        } else if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: 'Data Tidak Ditemukan',
                html: '<p class="text-sm text-slate-600">Data materi yang dipilih tidak ditemukan.</p>',
                customClass: { popup: 'englify-swal', confirmButton: 'englify-swal-confirm' }
            });
        }
        return;
    }
    openModal('edit', materi);
}

function deleteMateri(id) {
    document.getElementById('deleteForm').action = `/admin/materi/${id}`;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
}

// =============================================
// MULTIPLE URLS MANAGEMENT
// =============================================
function renderUrlInputs(urls = []) {
    const container = document.getElementById('urlInputsContainer');
    if (!container) return;
    container.innerHTML = '';

    const list = Array.isArray(urls) && urls.length > 0 ? urls : [''];
    list.forEach(u => addUrlInputRow(u));
}

function addUrlInputRow(value = '') {
    const container = document.getElementById('urlInputsContainer');
    if (!container) return;

    const row = document.createElement('div');
    row.className = 'flex items-center gap-2 url-row';
    row.innerHTML = `
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
            </div>
            <input type="url" name="urls[]" value="${escapeHtml(value)}" placeholder="https://youtube.com/watch?v=... atau https://..."
                   class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
        </div>
        <button type="button" onclick="removeUrlInputRow(this)" class="p-2.5 rounded-xl border border-slate-200 text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer" title="Hapus URL ini">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        </button>
    `;
    container.appendChild(row);
}

function removeUrlInputRow(button) {
    const container = document.getElementById('urlInputsContainer');
    const rows = container.querySelectorAll('.url-row');
    if (rows.length > 1) {
        button.closest('.url-row').remove();
    } else {
        const input = button.closest('.url-row').querySelector('input');
        if (input) input.value = '';
    }
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// =============================================
// IMAGE UPLOAD PREVIEW
// =============================================
function previewImage(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const maxSize = 2 * 1024 * 1024;

        if (file.size > maxSize) {
            if (typeof window.showAlert === 'function') {
                window.showAlert('Ukuran Terlalu Besar', 'Ukuran gambar cover maksimal 2MB!', 'warning');
            } else if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Ukuran Terlalu Besar',
                    html: '<p class="text-sm text-slate-600">Ukuran gambar cover maksimal 2MB!</p>',
                    customClass: { popup: 'englify-swal', confirmButton: 'englify-swal-confirm' }
                });
            }
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').querySelector('img').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
            document.getElementById('imageUploadArea').classList.add('hidden');
        }
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    document.getElementById('inputGambar').value = '';
    document.getElementById('imagePreview').classList.add('hidden');
    document.getElementById('imagePreview').querySelector('img').src = '';
    document.getElementById('imageUploadArea').classList.remove('hidden');
}

// =============================================
// FORM SUBMISSION
// =============================================
document.getElementById('materiForm').addEventListener('submit', function() {
    const button = this.querySelector('button[type="submit"]');
    button.disabled = true;
    button.innerHTML = 'Menyimpan...';
});

// =============================================
// QUICK ADD BAB (AJAX)
// =============================================
function openQuickAddBabModal() {
    const activeKat = document.getElementById('inputKategori') ? document.getElementById('inputKategori').value : '';
    if (activeKat) {
        document.getElementById('quickBabKategori').value = activeKat;
    }
    document.getElementById('quickBabJudul').value = '';
    document.getElementById('quickBabUrutan').value = '';
    document.getElementById('quickBabAlert').classList.add('hidden');
    document.getElementById('quickAddBabModal').classList.remove('hidden');
    document.getElementById('quickAddBabModal').classList.add('flex');
}

function closeQuickAddBabModal() {
    document.getElementById('quickAddBabModal').classList.add('hidden');
    document.getElementById('quickAddBabModal').classList.remove('flex');
}

function submitQuickAddBab(e) {
    e.preventDefault();
    const btn = document.getElementById('btnSubmitQuickBab');
    btn.disabled = true;
    btn.textContent = 'Menyimpan...';

    const kategoriId = document.getElementById('quickBabKategori').value;
    const judul = document.getElementById('quickBabJudul').value;
    const urutan = document.getElementById('quickBabUrutan').value;
    const durasi = document.getElementById('quickBabDurasi') ? document.getElementById('quickBabDurasi').value : 15;

    fetch("{{ route('admin.bab.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            id_kategori: kategoriId,
            judul: judul,
            urutan: urutan || null,
            durasi_menit: durasi || 15
        })
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled = false;
        btn.textContent = 'Simpan Bab';
        if (data.success) {
            TOTAL_BABS++;
            closeQuickAddBabModal();
            // Jika modal materi sedang terbuka, update dropdown kategori & bab
            const inputKategori = document.getElementById('inputKategori');
            const isMateriModalOpen = document.getElementById('materiModal') && document.getElementById('materiModal').classList.contains('flex');

            if (isMateriModalOpen) {
                if (inputKategori) {
                    inputKategori.value = kategoriId;
                    fetchBabs(kategoriId, data.data.id);
                }
                const submitBtn = document.getElementById('btnSubmitMateri');
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    submitBtn.title = '';
                }
                if (typeof window.showToast === 'function') {
                    window.showToast('Bab "' + data.data.judul + '" berhasil ditambahkan!', 'success');
                }
            } else {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Bab Berhasil Ditambahkan!',
                        html: `<p class="text-sm text-slate-600">Bab <strong class="text-navy-900 font-bold">"${data.data.judul}"</strong> telah berhasil ditambahkan ke kurikulum.</p>`,
                        confirmButtonText: 'Lanjutkan',
                        buttonsStyling: false,
                        customClass: {
                            popup: 'englify-swal',
                            confirmButton: 'englify-swal-confirm'
                        }
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    window.location.reload();
                }
            }
        } else {
            const alertBox = document.getElementById('quickBabAlert');
            alertBox.textContent = data.message || 'Gagal menambahkan bab';
            alertBox.className = 'p-3 rounded-xl text-xs bg-rose-50 text-rose-700 border border-rose-200';
            alertBox.classList.remove('hidden');
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.textContent = 'Simpan Bab';
        if (typeof window.showAlert === 'function') {
            window.showAlert('Koneksi Terganggu', 'Terjadi kesalahan koneksi saat menyimpan bab.', 'error');
        } else if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Koneksi Terganggu',
                html: '<p class="text-sm text-slate-600">Terjadi kesalahan koneksi saat menyimpan bab.</p>',
                customClass: { popup: 'englify-swal', confirmButton: 'englify-swal-confirm' }
            });
        }
    });
}

// =============================================
// PREVIEW POV SISWA
// =============================================
function openPreviewPOV(data) {
    const modal = document.getElementById('previewPovModal');
    if (!modal) return;

    // Badges
    const badgeColors = {
        'Speaking': 'bg-rose-50 text-rose-700 border-rose-200',
        'Writing': 'bg-blue-50 text-blue-700 border-blue-200',
        'Reading': 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'Listening': 'bg-purple-50 text-purple-700 border-purple-200'
    };
    const badgeClass = badgeColors[data.kategori] || 'bg-slate-50 text-slate-700 border-slate-200';
    const katBadge = document.getElementById('povKategoriBadge');
    if (katBadge) {
        katBadge.className = `inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border ${badgeClass}`;
        katBadge.textContent = data.kategori || 'Materi';
    }

    const babBadge = document.getElementById('povBabBadge');
    if (babBadge) babBadge.textContent = data.bab || 'Bab';

    const judulEl = document.getElementById('povJudul');
    if (judulEl) judulEl.textContent = data.judul || 'Judul Materi';

    // Deskripsi
    const descWrap = document.getElementById('povDeskripsiWrapper');
    if (descWrap) {
        if (data.deskripsi && data.deskripsi.trim() !== '') {
            descWrap.classList.remove('hidden');
            document.getElementById('povDeskripsi').textContent = data.deskripsi;
        } else {
            descWrap.classList.add('hidden');
        }
    }

    // Gambar
    const imgWrap = document.getElementById('povGambarWrapper');
    if (imgWrap) {
        if (data.gambar && data.gambar.trim() !== '') {
            imgWrap.classList.remove('hidden');
            const imgEl = document.getElementById('povGambar');
            imgEl.src = data.gambar.startsWith('/') ? data.gambar : `/${data.gambar}`;
        } else {
            imgWrap.classList.add('hidden');
        }
    }

    // Konten
    const kontenEl = document.getElementById('povKonten');
    if (kontenEl) kontenEl.textContent = data.konten || 'Belum ada konten tertulis untuk materi ini.';

    // Multiple URLs / YouTube
    const urlWrap = document.getElementById('povUrlWrapper');
    if (urlWrap) {
        urlWrap.innerHTML = '';
        let urlList = [];
        if (Array.isArray(data.urls) && data.urls.length > 0) {
            urlList = data.urls;
        } else if (data.url && typeof data.url === 'string' && data.url.trim() !== '') {
            try {
                const parsed = JSON.parse(data.url);
                urlList = Array.isArray(parsed) ? parsed : [data.url];
            } catch(e) {
                urlList = [data.url];
            }
        }

        if (urlList.length > 0) {
            urlWrap.classList.remove('hidden');
            urlList.forEach((u, i) => {
                const ytMatch = u.match(/(?:youtube(?:-nocookie)?\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i);
                const isYt = Boolean(ytMatch && ytMatch[1]);
                const card = document.createElement('div');
                card.className = 'rounded-2xl border border-blue-200 p-4 bg-gradient-to-r from-blue-50/50 to-white';
                card.innerHTML = `
                    <div class="flex items-center justify-between gap-3 mb-2">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-8 h-8 rounded-lg ${isYt ? 'bg-red-600' : 'bg-blue-600'} text-white flex items-center justify-center shrink-0">
                                ${isYt ? '▶' : '🔗'}
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-800">${isYt ? 'Video YouTube #' + (i + 1) : 'Tautan Sumber #' + (i + 1)}</p>
                                <p class="text-[11px] text-slate-500 truncate max-w-xs sm:max-w-md">${escapeHtml(u)}</p>
                            </div>
                        </div>
                        <a href="${escapeHtml(u)}" target="_blank" rel="noopener noreferrer" class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition shrink-0">Buka Link</a>
                    </div>
                    ${isYt ? `
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden shadow-sm mt-2 bg-black">
                            <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/${ytMatch[1]}" frameborder="0" allowfullscreen></iframe>
                        </div>
                    ` : ''}
                `;
                urlWrap.appendChild(card);
            });
        } else {
            urlWrap.classList.add('hidden');
        }
    }

    // File (Legacy)
    const fileWrap = document.getElementById('povFileWrapper');
    if (fileWrap) {
        fileWrap.classList.add('hidden');
    }

    // Contoh
    const contohWrap = document.getElementById('povContohWrapper');
    if (contohWrap) {
        if (data.contoh && data.contoh.trim() !== '') {
            contohWrap.classList.remove('hidden');
            document.getElementById('povContoh').textContent = data.contoh;
        } else {
            contohWrap.classList.add('hidden');
        }
    }

    // Tips
    const tipsWrap = document.getElementById('povTipsWrapper');
    if (tipsWrap) {
        if (data.tips && data.tips.trim() !== '') {
            tipsWrap.classList.remove('hidden');
            document.getElementById('povTips').textContent = data.tips;
        } else {
            tipsWrap.classList.add('hidden');
        }
    }

    // Default to Desktop frame
    setPreviewDevice('desktop');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.classList.add('overflow-hidden');
}

function closePreviewPOV() {
    const modal = document.getElementById('previewPovModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
        const urlWrap = document.getElementById('povUrlWrapper');
        if (urlWrap) urlWrap.innerHTML = '';
    }
}

function setPreviewDevice(device) {
    const frame = document.getElementById('previewDeviceFrame');
    const btnDesktop = document.getElementById('btnDeviceDesktop');
    const btnMobile = document.getElementById('btnDeviceMobile');
    if (!frame) return;

    if (device === 'mobile') {
        frame.className = 'w-full max-w-sm transition-all duration-300';
        if (btnMobile) btnMobile.className = 'px-2.5 py-1 rounded-lg bg-white text-slate-800 font-bold shadow-xs transition flex items-center gap-1 cursor-pointer';
        if (btnDesktop) btnDesktop.className = 'px-2.5 py-1 rounded-lg text-slate-600 hover:text-slate-900 transition flex items-center gap-1 cursor-pointer';
    } else {
        frame.className = 'w-full max-w-4xl transition-all duration-300';
        if (btnDesktop) btnDesktop.className = 'px-2.5 py-1 rounded-lg bg-white text-slate-800 font-bold shadow-xs transition flex items-center gap-1 cursor-pointer';
        if (btnMobile) btnMobile.className = 'px-2.5 py-1 rounded-lg text-slate-600 hover:text-slate-900 transition flex items-center gap-1 cursor-pointer';
    }
}

// Close on Escape or backdrop click
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closePreviewPOV();
});

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('previewPovModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) closePreviewPOV();
        });
    }
});
</script>
@endpush
