<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Super Admin') - Englify</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Chart.js CDN for statistics chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                        handwritten: ['"Caveat"', 'cursive']
                    },
                    colors: {
                        navy: {
                            800: '#152442',
                            850: '#111d35',
                            900: '#0c1628',
                        },
                        brand: {
                            50: '#eef6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8'
                        }
                    },
                    boxShadow: {
                        card: '0 4px 20px -2px rgba(21, 36, 66, 0.05), 0 2px 6px -1px rgba(21, 36, 66, 0.03)',
                        hover: '0 10px 25px -4px rgba(21, 36, 66, 0.08), 0 4px 10px -2px rgba(21, 36, 66, 0.04)',
                        bottomNav: '0 -4px 20px rgba(0, 0, 0, 0.06)'
                    }
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; }
        .font-cute { font-family: 'Caveat', cursive; }
        body { background-color: #EEF4FB; }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Sidebar link active state */
        .sidebar-item-active {
            background-color: #3B82F6;
            color: #FFFFFF !important;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.35);
        }
        .sidebar-item-active svg {
            color: #FFFFFF !important;
        }

        /* Sidebar collapsed style for desktop toggle */
        #sidebar.collapsed { width: 4.75rem; }
        #sidebar.collapsed .sidebar-text,
        #sidebar.collapsed .sidebar-cat-quote,
        #sidebar.collapsed .sidebar-subitems { display: none; }
        #sidebar.collapsed .sidebar-link { justify-content: center; padding-left: 0.5rem; padding-right: 0.5rem; }
    </style>
</head>
<body class="bg-[#EEF4FB] text-slate-800 antialiased min-h-screen flex flex-col">

<div class="flex h-screen overflow-hidden">

    <!-- ============================================================== -->
    <!-- DESKTOP LEFT SIDEBAR                                           -->
    <!-- ============================================================== -->
    <aside id="sidebar" class="w-64 shrink-0 bg-[#152442] hidden lg:flex flex-col shadow-2xl transition-all duration-300 z-30 select-none relative">

        <!-- Sidebar Brand / Logo -->
        <div class="p-6 pb-5 flex items-center justify-between border-b border-white/10">
            <a href="{{ route('superadmin.dashboard') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-[#E0ECFC] flex items-center justify-center shadow-md p-1.5 transition-transform group-hover:scale-105 shrink-0">
                    <svg viewBox="0 0 36 36" class="w-full h-full text-[#152442]" fill="currentColor">
                        <polygon points="6,15 11,3 17,9" fill="#152442"/>
                        <polygon points="30,15 25,3 19,9" fill="#152442"/>
                        <polygon points="8,13 11,6 15,10" fill="#93C5FD"/>
                        <polygon points="28,13 25,6 21,10" fill="#93C5FD"/>
                        <circle cx="18" cy="19" r="13" fill="#152442"/>
                        <path d="M10 20 C10 13, 26 13, 26 20 C26 27, 10 27, 10 20 Z" fill="#FFFFFF"/>
                        <ellipse cx="14" cy="19" rx="1.8" ry="2.2" fill="#152442"/>
                        <ellipse cx="22" cy="19" rx="1.8" ry="2.2" fill="#152442"/>
                        <circle cx="13.4" cy="18.2" r="0.6" fill="#FFFFFF"/>
                        <circle cx="21.4" cy="18.2" r="0.6" fill="#FFFFFF"/>
                        <polygon points="17,22 19,22 18,23" fill="#152442"/>
                        <path d="M18 23 L18 24.5 M16.5 24.5 C17.2 25, 18 24.5, 18 24.5 C18 24.5, 18.8 25, 19.5 24.5" stroke="#152442" stroke-width="0.8" fill="none" stroke-linecap="round"/>
                    </svg>
                </div>
                <div class="sidebar-text">
                    <span class="text-2xl font-extrabold text-white tracking-tight leading-none">englify</span>
                </div>
            </a>
            <button onclick="toggleSidebarCollapse()" class="text-slate-400 hover:text-white p-1 rounded-lg hover:bg-white/5 transition" title="Toggle Sidebar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/></svg>
            </button>
        </div>

        <!-- Sidebar Navigation List -->
        <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto overflow-x-hidden">
            <!-- 1. Dashboard -->
            <a href="{{ route('superadmin.dashboard') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('superadmin.dashboard') ? 'sidebar-item-active' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="sidebar-text">Dashboard</span>
            </a>

            <!-- 2. Kelola Akun (With dropdown sub-menu) -->
            <div class="space-y-1">
                @php
                    $isUserRoute = request()->routeIs('superadmin.siswa') || request()->routeIs('superadmin.adminDivisi');
                @endphp
                <button type="button" onclick="toggleSubmenu('sub-users')"
                        class="w-full sidebar-link flex items-center justify-between px-4 py-3 rounded-xl text-sm font-semibold transition {{ $isUserRoute ? 'text-white bg-white/10' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                    <div class="flex items-center gap-3 min-w-0">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span class="sidebar-text truncate">Kelola Akun</span>
                    </div>
                    <svg id="arrow-sub-users" class="w-4 h-4 sidebar-text transition-transform duration-200 text-slate-400 {{ $isUserRoute ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <!-- Submenu Items (SUDAH DIPERBAIKI KE ROUTE YANG BENAR) -->
                <div id="sub-users" class="sidebar-subitems space-y-1 pl-10 pr-2 {{ $isUserRoute ? '' : 'hidden' }}">
                    <a href="{{ route('superadmin.siswa') }}" class="block py-1.5 px-3 rounded-lg text-xs font-medium transition {{ request()->routeIs('superadmin.siswa') ? 'text-white bg-white/10 font-bold' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                        • Akun Siswa
                    </a>
                    <a href="{{ route('superadmin.adminDivisi') }}" class="block py-1.5 px-3 rounded-lg text-xs font-medium transition {{ request()->routeIs('superadmin.adminDivisi') ? 'text-white bg-white/10 font-bold' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                        • Akun Admin Divisi
                    </a>
                </div>
            </div>

            <!-- 3. Data Sistem -->
            <a href="{{ route('superadmin.settings') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('superadmin.settings') ? 'sidebar-item-active' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="sidebar-text">Data Sistem</span>
            </a>

            <!-- 4. Profil -->
            <a href="{{ route('superadmin.profile') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition {{ request()->routeIs('superadmin.profile') ? 'sidebar-item-active' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span class="sidebar-text">Profil</span>
            </a>
        </nav>

        <!-- Sidebar Bottom -->
        <div class="p-5 pt-0 border-t border-white/10 space-y-3 relative overflow-hidden">
            <div class="sidebar-cat-quote pt-3 text-left pl-1">
                <p class="font-cute text-xl text-sky-200 leading-tight">Better</p>
                <p class="font-cute text-xl text-sky-200 leading-tight">English</p>
                <p class="font-cute text-xl text-sky-200 leading-tight">Brighter</p>
                <p class="font-cute text-xl text-sky-200 leading-tight">Future <span class="text-amber-300">✦</span></p>
            </div>

            <div class="relative flex justify-end -mt-8 pr-1">
                <img src="{{ asset('images/cat-welcome.png') }}" alt="Englify Cat Peeking" class="w-20 h-auto object-contain transform translate-y-2 opacity-90 drop-shadow-md">
            </div>

            <form method="POST" action="{{ route('logout') }}" class="pt-1">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-rose-500/20 text-slate-200 hover:text-white border border-white/15 transition text-sm font-medium">
                    <svg class="w-5 h-5 shrink-0 text-sky-300" viewBox="0 0 24 24" fill="currentColor">
                        <circle cx="7" cy="8" r="2"/>
                        <circle cx="12" cy="5" r="2"/>
                        <circle cx="17" cy="8" r="2"/>
                        <path d="M12 11c-3 0-5 2-5 5 0 2.5 2 4 5 4s5-1.5 5-4c0-3-2-5-5-5z"/>
                    </svg>
                    <span class="sidebar-text">Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Mobile Backdrop -->
    <div id="mobile-backdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 hidden lg:hidden" onclick="toggleMobileSidebar()"></div>

    <!-- Mobile Drawer (Offcanvas Menu) -->
    <div id="mobile-sidebar" class="fixed inset-y-0 left-0 w-72 bg-[#152442] z-50 transform -translate-x-full transition-transform duration-300 lg:hidden flex flex-col shadow-2xl">
        <div class="p-5 border-b border-white/10 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-[#E0ECFC] flex items-center justify-center p-1.5">
                    <svg viewBox="0 0 36 36" class="w-full h-full text-[#152442]" fill="currentColor">
                        <polygon points="6,15 11,3 17,9" fill="#152442"/>
                        <polygon points="30,15 25,3 19,9" fill="#152442"/>
                        <circle cx="18" cy="19" r="13" fill="#152442"/>
                        <circle cx="14" cy="19" r="1.8" fill="#FFFFFF"/>
                        <circle cx="22" cy="19" r="1.8" fill="#FFFFFF"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-white leading-none">englify</p>
                    <p class="text-[10px] text-sky-200 uppercase tracking-wider mt-1 font-semibold">Super Admin Panel</p>
                </div>
            </div>
            <button onclick="toggleMobileSidebar()" class="text-slate-400 hover:text-white p-2 rounded-lg" aria-label="Tutup">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto text-sm font-semibold text-slate-200">
            <a href="{{ route('superadmin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('superadmin.dashboard') ? 'bg-blue-600 text-white' : 'hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <!-- Link Mobile Sidebar diperbaiki -->
            <a href="{{ route('superadmin.siswa') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('superadmin.siswa') ? 'bg-blue-600 text-white' : 'hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Kelola Akun Siswa
            </a>

            <!-- Link Mobile Sidebar untuk Admin Divisi (DITAMBAHKAN) -->
            <a href="{{ route('superadmin.adminDivisi') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('superadmin.adminDivisi') ? 'bg-blue-600 text-white' : 'hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                Admin Divisi
            </a>

            <a href="{{ route('superadmin.settings') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('superadmin.settings') ? 'bg-blue-600 text-white' : 'hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                Data Sistem
            </a>
            <a href="{{ route('superadmin.profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('superadmin.profile') ? 'bg-blue-600 text-white' : 'hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Profil
            </a>
        </nav>
        <div class="p-5 border-t border-white/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full py-2.5 rounded-xl bg-white/10 text-white text-sm font-semibold hover:bg-rose-500/20 transition">Keluar</button>
            </form>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- MAIN COLUMN                                                    -->
    <!-- ============================================================== -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden relative">

        <!-- TOP NAVIGATION BAR -->
        <header class="bg-[#EEF4FB] px-4 sm:px-8 py-3.5 flex items-center justify-between gap-4 sticky top-0 z-20">
            <div class="flex items-center gap-3 lg:hidden">
                <button onclick="toggleMobileSidebar()" class="p-2 text-slate-700 hover:bg-white rounded-xl shadow-xs transition" aria-label="Toggle Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-[#E0ECFC] flex items-center justify-center p-1 shadow-xs">
                        <svg viewBox="0 0 36 36" class="w-full h-full text-[#152442]" fill="currentColor">
                            <polygon points="6,15 11,3 17,9" fill="#152442"/>
                            <polygon points="30,15 25,3 19,9" fill="#152442"/>
                            <circle cx="18" cy="19" r="13" fill="#152442"/>
                        </svg>
                    </div>
                    <span class="font-extrabold text-xl text-[#152442]">englify</span>
                </div>
            </div>

            <form action="{{ route('superadmin.dashboard') }}" method="GET" class="relative max-w-md w-full hidden md:block">
                <div class="relative">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari di sistem..."
                           class="w-full pl-11 pr-4 py-2.5 bg-white border border-slate-200/90 rounded-full text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 shadow-xs transition">
                    <svg class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </form>

            <div class="flex items-center gap-3 sm:gap-4 ml-auto">
                <button onclick="toggleGuideModal()" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white border border-indigo-200 text-indigo-700 hover:bg-indigo-50 text-xs font-bold shadow-xs transition" title="Lihat Tugas & Hak Akses Super Admin">
                    <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                    <span>Panduan Hak Akses</span>
                </button>

                <div class="relative">
                    <button onclick="toggleNotifDropdown()" class="w-10 h-10 rounded-full bg-white border border-slate-200/80 flex items-center justify-center text-slate-600 hover:text-slate-900 hover:bg-slate-50 shadow-xs transition relative" aria-label="Notifikasi">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
                    </button>
                    <div id="notif-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-slate-200 py-3 z-50">
                        <div class="px-4 pb-2 border-b border-slate-100 flex items-center justify-between">
                            <p class="text-xs font-bold text-slate-800 uppercase tracking-wider">Notifikasi Sistem</p>
                            <span class="text-[10px] bg-blue-50 text-blue-600 font-bold px-2 py-0.5 rounded-full">Baru</span>
                        </div>
                        <div class="divide-y divide-slate-100 max-h-64 overflow-y-auto">
                            <div class="p-3.5 hover:bg-slate-50 transition flex gap-3 items-start">
                                <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 text-xs font-bold">✓</div>
                                <div class="text-xs">
                                    <p class="font-bold text-slate-700">Akun Siswa Baru Ditambahkan</p>
                                    <p class="text-slate-400 text-[11px]">Rani Putri berhasil terdaftar di sistem.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <button onclick="toggleProfileDropdown()" class="flex items-center gap-2.5 bg-white border border-slate-200/90 rounded-full py-1.5 pl-1.5 pr-3 shadow-xs hover:bg-slate-50 transition">
                        <div class="w-8 h-8 rounded-full bg-[#E0ECFC] border border-blue-200 flex items-center justify-center overflow-hidden shrink-0">
                            <img src="{{ asset('images/cat-welcome.png') }}" alt="User Avatar" class="w-7 h-7 object-cover">
                        </div>
                        <div class="text-left hidden sm:block">
                            <p class="text-xs font-bold text-slate-800 leading-tight">Satpam & HRD</p>
                            <p class="text-[10px] font-semibold text-slate-400 leading-none">Super Admin</p>
                        </div>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-200 py-2 z-50">
                        <div class="px-4 py-2.5 border-b border-slate-100">
                            <p class="text-xs font-bold text-slate-800">Satpam & HRD</p>
                            <p class="text-[11px] text-slate-400 truncate">{{ auth()->user()->email ?? 'admin@englify.com' }}</p>
                            <span class="inline-block mt-1 text-[9px] font-bold uppercase tracking-wider bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">Super Admin</span>
                        </div>
                        <a href="{{ route('superadmin.profile') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Profil Saya
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="border-t border-slate-100 mt-1 pt-1">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-xs font-bold text-rose-600 hover:bg-rose-50">
                                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- MAIN SCROLLABLE CONTENT -->
        <main class="flex-1 overflow-y-auto px-4 sm:px-8 pb-24 lg:pb-12">
            <div class="max-w-[1400px] mx-auto py-3">
                @if(session('success'))
                <div class="mb-5 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold px-4 py-3 rounded-2xl flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs">✓</span>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">&times;</button>
                </div>
                @endif

                @yield('content')
            </div>

            <footer class="mt-8 text-center text-xs font-semibold text-slate-400 py-4 border-t border-slate-200/60">
                Englify &nbsp;—&nbsp; Learn &nbsp;•&nbsp; Grow &nbsp;•&nbsp; Achieve <span class="text-amber-400">✧</span>
            </footer>
        </main>

        <!-- MOBILE BOTTOM NAVIGATION BAR -->
        <nav class="lg:hidden fixed bottom-0 inset-x-0 bg-white/95 backdrop-blur-md border-t border-slate-200/90 shadow-bottomNav z-30 px-3 py-2 flex items-center justify-around">
            <!-- 1. Beranda -->
            <a href="{{ route('superadmin.dashboard') }}" class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl {{ request()->routeIs('superadmin.dashboard') ? 'text-blue-600 font-bold' : 'text-slate-500' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="text-[10px]">Beranda</span>
            </a>

            <!-- 2. Akun Siswa -->
            <a href="{{ route('superadmin.siswa') }}" class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl {{ request()->routeIs('superadmin.siswa') ? 'text-blue-600 font-bold' : 'text-slate-500 hover:text-blue-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <span class="text-[10px]">Siswa</span>
            </a>

            <!-- 3. Sistem -->
            <a href="{{ route('superadmin.settings') }}" class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl {{ request()->routeIs('superadmin.settings') ? 'text-blue-600 font-bold' : 'text-slate-500 hover:text-blue-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                <span class="text-[10px]">Sistem</span>
            </a>

            <!-- 4. Profil -->
            <a href="{{ route('superadmin.profile') }}" class="flex flex-col items-center gap-1 py-1 px-3 rounded-xl {{ request()->routeIs('superadmin.profile') ? 'text-blue-600 font-bold' : 'text-slate-500 hover:text-blue-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span class="text-[10px]">Profil</span>
            </a>
        </nav>
    </div>
</div>

<!-- PANDUAN HAK AKSES MODAL -->
<div id="guide-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-xl w-full max-h-[90vh] overflow-y-auto p-6 sm:p-8 relative">
        <button onclick="toggleGuideModal()" class="absolute top-5 right-5 text-slate-400 hover:text-slate-700 p-1 rounded-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <div class="flex items-center gap-3.5 mb-5">
            <div class="w-12 h-12 rounded-2xl bg-indigo-600 text-white flex items-center justify-center shadow-lg shadow-indigo-600/30">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5zm14 3c0 .6-.4 1-1 1H6c-.6 0-1-.4-1-1v-1h14v1z"/></svg>
            </div>
            <div>
                <h3 class="text-xl font-extrabold text-slate-800">Super Admin</h3>
                <p class="text-sm font-bold text-indigo-600">(Satpam & HRD)</p>
            </div>
        </div>
        <div class="bg-indigo-50/60 rounded-2xl p-5 border border-indigo-100 mb-6">
            <h4 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider mb-3">Tugas &amp; Hak Akses:</h4>
            <ul class="space-y-2.5 text-sm text-slate-700">
                <li class="flex items-center gap-2.5"><span class="text-indigo-600 font-bold">✓</span> Login &amp; logout</li>
                <li class="flex items-center gap-2.5"><span class="text-indigo-600 font-bold">✓</span> Membuat akun Admin Divisi</li>
                <li class="flex items-center gap-2.5"><span class="text-indigo-600 font-bold">✓</span> Mengelola akun Siswa</li>
                <li class="flex items-center gap-2.5"><span class="text-indigo-600 font-bold">✓</span> Melihat data sistem</li>
                <li class="flex items-center gap-2.5"><span class="text-indigo-600 font-bold">✓</span> Mengelola profil &amp; password</li>
                <li class="flex items-center gap-2.5 text-rose-600 font-medium"><span class="font-bold">⊘</span> Tidak menyentuh materi pembelajaran.</li>
            </ul>
        </div>
    </div>
</div>

<script>
function toggleSidebarCollapse() {
    document.getElementById('sidebar').classList.toggle('collapsed');
}
function toggleMobileSidebar() {
    const sb = document.getElementById('mobile-sidebar');
    const bd = document.getElementById('mobile-backdrop');
    const open = sb.classList.contains('-translate-x-full');
    sb.classList.toggle('-translate-x-full', !open);
    bd.classList.toggle('hidden', !open);
}
function toggleSubmenu(id) {
    const menu = document.getElementById(id);
    const arrow = document.getElementById('arrow-' + id);
    if (menu) {
        menu.classList.toggle('hidden');
        if (arrow) arrow.classList.toggle('rotate-180');
    }
}
function toggleNotifDropdown() {
    document.getElementById('notif-dropdown').classList.toggle('hidden');
}
function toggleProfileDropdown() {
    document.getElementById('profile-dropdown').classList.toggle('hidden');
}
function toggleGuideModal() {
    const m = document.getElementById('guide-modal');
    m.classList.toggle('hidden');
    m.classList.toggle('flex');
}
document.addEventListener('click', function(e) {
    ['notif-dropdown', 'profile-dropdown'].forEach(function(id) {
        const el = document.getElementById(id);
        if (el && !el.classList.contains('hidden') && !el.parentElement.contains(e.target)) {
            el.classList.add('hidden');
        }
    });
});
</script>

@stack('scripts')
</body>
</html>
