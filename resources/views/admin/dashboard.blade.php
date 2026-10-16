<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa — Englify</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['"Space Grotesk"', 'sans-serif'],
                        body: ['"Inter"', 'sans-serif']
                    },
                    colors: {
                        navy: { 900: '#001B48', 800: '#02457A', 700: '#018ABE', 300: '#97CADB', 100: '#D6EBEE' }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            font-weight: 400;
            -webkit-font-smoothing: antialiased;
        }
        .text-heading {
            font-family: 'Space Grotesk', sans-serif !important;
            font-weight: 700;
            letter-spacing: -0.02em;
        }
        .text-body {
            font-family: 'Inter', sans-serif !important;
        }
        .text-label {
            font-family: 'Inter', sans-serif !important;
            font-weight: 600;
        }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-3px); box-shadow: 0 20px 40px -15px rgba(0, 27, 72, 0.2); }
        .animate-fade-in { animation: fadeIn 0.6s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .progress-ring { transform: rotate(-90deg); }
    </style>
</head>
<body class="antialiased bg-[#D6EBEE]">

    <div class="flex min-h-screen">

        <!-- ============ SIDEBAR KIRI ============ -->
        <aside class="hidden lg:flex fixed left-0 top-0 h-full w-64 bg-[#001B48] text-white flex-col z-40">
            <div class="p-6 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 bg-gradient-to-br from-[#018ABE] to-[#97CADB] rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <span class="text-heading text-xl block tracking-tight text-white">englify</span>
                        <span class="text-[10px] text-[#97CADB] font-semibold">Admin Panel</span>
                    </div>
                </div>
            </div>

            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 py-3 px-4 bg-white/10 text-white rounded-2xl font-semibold text-sm border-l-4 border-[#018ABE]">
                    <svg class="w-5 h-5 text-[#97CADB]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.kategori') }}" class="flex items-center gap-3 py-3 px-4 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl font-medium text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    Kategori
                </a>
                <a href="{{ route('admin.materi') }}" class="flex items-center gap-3 py-3 px-4 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl font-medium text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Materi
                </a>
                <a href="{{ route('admin.quiz') }}" class="flex items-center gap-3 py-3 px-4 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl font-medium text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Quiz
                </a>
                <a href="{{ route('admin.hasil-quiz') }}" class="flex items-center gap-3 py-3 px-4 text-white/60 hover:text-white hover:bg-white/5 rounded-2xl font-medium text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Hasil Quiz
                </a>
            </nav>

            <div class="p-4 border-t border-white/10">
                <div class="bg-gradient-to-br from-[#02457A] to-[#018ABE] rounded-2xl p-4 shadow-lg">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-11 h-11 bg-white rounded-xl flex items-center justify-center text-[#001B48] font-bold text-sm shadow-md">
                            {{ strtoupper(substr(auth()->user()->nama ?? 'S', 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->nama }}</p>
                            <p class="text-[10px] text-white/70 truncate">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full py-2 bg-white/20 hover:bg-white/30 text-white rounded-xl text-xs font-semibold transition flex items-center justify-center gap-2 backdrop-blur">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- ============ MOBILE BOTTOM NAV ============ -->
        <nav class="lg:hidden fixed bottom-0 left-0 right-0 glass border-t border-[#97CADB]/30 z-50 flex justify-around py-2 px-1 shadow-[0_-10px_40px_-15px_rgba(0,27,72,0.15)]">
            <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center gap-1 p-2 text-[#001B48]">
                <div class="w-11 h-11 bg-[#001B48] rounded-2xl flex items-center justify-center shadow-lg"><svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg></div>
                <span class="text-[10px] font-semibold">Home</span>
            </a>
            <a href="{{ route('admin.materi') }}" class="flex flex-col items-center gap-1 p-2 text-slate-500">
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg></div>
                <span class="text-[10px] font-medium">Materi</span>
            </a>
            <a href="{{ route('admin.quiz') }}" class="flex flex-col items-center gap-1 p-2 text-slate-500">
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg></div>
                <span class="text-[10px] font-medium">Quiz</span>
            </a>
            <a href="{{ route('admin.hasil-quiz') }}" class="flex flex-col items-center gap-1 p-2 text-slate-500">
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg></div>
                <span class="text-[10px] font-medium">Hasil</span>
            </a>
        </nav>

        <!-- ============ MAIN CONTENT ============ -->
        <main class="flex-1 lg:ml-64 min-h-screen pb-24 lg:pb-8">

            <!-- ============ HEADER ============ -->
            <header class="bg-white/80 backdrop-blur-md border-b border-[#97CADB]/30 sticky top-0 z-30">
                <div class="max-w-7xl mx-auto px-4 lg:px-8 py-4 lg:py-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#018ABE] to-[#001B48] flex items-center justify-center shadow-lg shadow-[#018ABE]/20 flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <div>
                            <h1 class="text-heading text-xl lg:text-2xl text-[#001B48] leading-tight">Halo, {{ auth()->user()->nama }}! <span class="text-2xl"></span></h1>
                            <p class="text-body text-xs text-slate-500 font-medium mt-0.5">{{ now()->format('l, d F Y') }} • Ayo lanjutkan belajarmu!</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 w-full md:w-auto">
                        <div class="relative flex-1 md:flex-none group">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-[#018ABE] group-focus-within:text-[#001B48] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" class="block w-full md:w-64 pl-10 pr-3 py-2.5 border border-[#97CADB]/50 rounded-full leading-5 bg-[#D6EBEE]/30 text-body text-[#001B48] placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#018ABE] focus:ring-2 focus:ring-[#018ABE]/20 sm:text-sm transition shadow-sm" placeholder="Cari materi...">
                        </div>
                        <button class="relative p-2.5 bg-white border border-[#97CADB]/50 rounded-full text-[#001B48] hover:bg-[#D6EBEE] hover:border-[#018ABE] transition shadow-sm flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <span class="absolute top-2 right-2.5 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                        </button>
                    </div>
                </div>
            </header>

            <div class="p-4 lg:p-8 max-w-7xl mx-auto">

                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-3 animate-fade-in">
                        <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <p class="text-sm font-medium text-emerald-700 text-body">{{ session('success') }}</p>
                    </div>
                @endif

                <!-- Grid Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- KOLOM KIRI (2/3) -->
                    <div class="lg:col-span-2 space-y-6">

                        <!-- Welcome Card -->
                        <div class="bg-white rounded-3xl p-6 lg:p-8 shadow-lg border border-[#97CADB]/30 card-hover animate-fade-in">
                            <div class="flex flex-col md:flex-row items-center gap-6">
                                <div class="relative flex-shrink-0">
                                    <div class="w-28 h-28 lg:w-32 lg:h-32 bg-gradient-to-br from-[#018ABE] via-[#02457A] to-[#001B48] rounded-3xl flex items-center justify-center shadow-2xl">
                                        <span class="text-white text-heading text-5xl">{{ strtoupper(substr(auth()->user()->nama ?? 'S', 0, 1)) }}</span>
                                    </div>
                                    <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-emerald-400 rounded-xl border-4 border-white flex items-center justify-center shadow-lg">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    </div>
                                </div>

                                <div class="flex-1 text-center md:text-left">
                                    <div class="inline-block px-4 py-1.5 bg-[#D6EBEE] text-[#001B48] text-xs font-bold rounded-full mb-3 text-label tracking-wide">
                                        SISWA PANEL
                                    </div>
                                    <h2 class="text-heading text-3xl lg:text-4xl text-[#001B48] mb-2">{{ auth()->user()->nama }}</h2>
                                    <p class="text-body text-sm text-slate-500 mb-3 font-medium">{{ auth()->user()->email }}</p>
                                    <div class="flex flex-wrap justify-center md:justify-start gap-2">
                                        <span class="px-3 py-1 bg-[#018ABE]/10 text-[#018ABE] text-xs font-bold rounded-full text-label">Learner</span>
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full text-label">Active</span>
                                        <span class="px-3 py-1 bg-[#D6EBEE] text-[#02457A] text-xs font-bold rounded-full text-label">Member since {{ auth()->user()->created_at->format('M Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stats Cards -->
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="bg-white rounded-3xl p-5 border border-[#97CADB]/30 shadow-sm card-hover animate-fade-in">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-[#018ABE] to-[#97CADB] rounded-2xl flex items-center justify-center shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    </div>
                                </div>
                                <div class="text-heading text-3xl text-[#001B48]">{{ $materiDibaca ?? 0 }}</div>
                                <div class="text-xs text-slate-500 mt-1 font-medium text-body">Materi Dibaca</div>
                            </div>

                            <div class="bg-white rounded-3xl p-5 border border-[#97CADB]/30 shadow-sm card-hover animate-fade-in">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-[#02457A] to-[#018ABE] rounded-2xl flex items-center justify-center shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                    </div>
                                </div>
                                <div class="text-heading text-3xl text-[#001B48]">{{ $totalQuiz ?? 0 }}</div>
                                <div class="text-xs text-slate-500 mt-1 font-medium text-body">Quiz Selesai</div>
                            </div>

                            <div class="bg-white rounded-3xl p-5 border border-[#97CADB]/30 shadow-sm card-hover animate-fade-in">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                    </div>
                                </div>
                                <div class="text-heading text-3xl text-[#001B48]">{{ $rataSkor ?? 0 }}</div>
                                <div class="text-xs text-slate-500 mt-1 font-medium text-body">Rata-rata Skor</div>
                            </div>

                            <div class="bg-white rounded-3xl p-5 border border-[#97CADB]/30 shadow-sm card-hover animate-fade-in">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-[#001B48] to-[#02457A] rounded-2xl flex items-center justify-center shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                </div>
                                <div class="text-heading text-3xl text-[#001B48]">{{ $totalPoin ?? 0 }}</div>
                                <div class="text-xs text-slate-500 mt-1 font-medium text-body">Total Poin</div>
                            </div>
                        </div>

                        <!-- Continue Learning -->
                        <div class="bg-white rounded-3xl p-6 border border-[#97CADB]/30 shadow-sm card-hover">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-heading text-xl text-[#001B48]">Lanjutkan Belajar</h3>
                                    <p class="text-xs text-slate-500 mt-1 font-medium text-body">Materi yang belum kamu selesaikan</p>
                                </div>
                                <a href="{{ route('admin.materi') }}" class="text-xs font-bold text-[#018ABE] hover:text-[#001B48] transition text-label">Lihat Semua →</a>
                            </div>

                            <div class="space-y-3">
                                @forelse($materiBelumDibaca ?? [] as $materi)
                                <a href="{{ route('admin.materi') }}" class="flex items-center gap-4 p-4 bg-[#D6EBEE]/30 hover:bg-[#D6EBEE]/60 rounded-2xl transition group">
                                    <div class="w-12 h-12 bg-gradient-to-br from-[#018ABE] to-[#97CADB] rounded-xl flex items-center justify-center text-white font-bold shadow-md flex-shrink-0 group-hover:scale-110 transition">
                                        {{ strtoupper(substr($materi->judul ?? 'M', 0, 1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-[#001B48] truncate text-body">{{ $materi->judul ?? 'Materi' }}</p>
                                        <p class="text-xs text-slate-500 font-medium text-body">{{ $materi->kategori->nama_kategori ?? 'Umum' }} • {{ $materi->bab ?? 'Bab 1' }}</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-[#018ABE] group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </div>
                                </a>
                                @empty
                                <div class="text-center py-8">
                                    <div class="w-16 h-16 bg-[#D6EBEE] rounded-2xl flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-8 h-8 text-[#97CADB]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <p class="text-slate-500 font-medium text-body">Semua materi sudah dibaca! 🎉</p>
                                    <a href="{{ route('admin.quiz') }}" class="inline-block mt-3 px-4 py-2 bg-[#001B48] text-white rounded-xl text-xs font-bold hover:bg-[#02457A] transition">Kerjakan Quiz</a>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- KOLOM KANAN (1/3) -->
                    <div class="space-y-6">

                        <!-- Quick Actions Card -->
                        <div class="bg-gradient-to-br from-[#001B48] to-[#02457A] rounded-3xl p-6 shadow-xl text-white card-hover">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-heading text-lg text-white">Quick Actions</h3>
                                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                            </div>
                            <p class="text-xs text-white/70 mb-4 font-medium text-body">Aksi cepat untuk belajar</p>

                            <div class="space-y-2">
                                <a href="{{ route('admin.materi') }}" class="block w-full py-3 bg-white/10 hover:bg-white/20 backdrop-blur rounded-2xl text-sm font-semibold transition flex items-center gap-3 border border-white/10 text-body">
                                    <div class="w-8 h-8 bg-[#018ABE] rounded-xl flex items-center justify-center"><svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg></div>
                                    Baca Materi
                                </a>
                                <a href="{{ route('admin.quiz') }}" class="block w-full py-3 bg-white/10 hover:bg-white/20 backdrop-blur rounded-2xl text-sm font-semibold transition flex items-center gap-3 border border-white/10 text-body">
                                    <div class="w-8 h-8 bg-[#97CADB] rounded-xl flex items-center justify-center"><svg class="w-4 h-4 text-[#001B48]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg></div>
                                    Kerjakan Quiz
                                </a>
                                <a href="{{ route('admin.hasil-quiz') }}" class="block w-full py-3 bg-white/10 hover:bg-white/20 backdrop-blur rounded-2xl text-sm font-semibold transition flex items-center gap-3 border border-white/10 text-body">
                                    <div class="w-8 h-8 bg-emerald-400 rounded-xl flex items-center justify-center"><svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg></div>
                                    Lihat Progress
                                </a>
                            </div>
                        </div>

                        <!-- Achievement Card -->
                        <div class="bg-white rounded-3xl p-6 border border-[#97CADB]/30 shadow-sm card-hover">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-heading text-lg text-[#001B48]">Pencapaian</h3>
                                <span class="text-[10px] font-bold text-[#018ABE] bg-[#D6EBEE] px-2 py-1 rounded-full text-label">YOUR STATS</span>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 bg-[#D6EBEE]/30 rounded-xl">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 bg-gradient-to-br from-amber-400 to-amber-600 rounded-xl flex items-center justify-center text-white font-bold text-xs shadow-md">🏆</div>
                                        <div>
                                            <p class="text-sm font-semibold text-[#001B48] text-body">First Quiz</p>
                                            <p class="text-[10px] text-slate-500 font-medium text-body">Selesaikan quiz pertama</p>
                                        </div>
                                    </div>
                                    @if(($totalQuiz ?? 0) > 0)
                                        <span class="text-emerald-600 text-xs font-bold">✓</span>
                                    @else
                                        <span class="text-slate-400 text-xs font-bold">○</span>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between p-3 bg-[#D6EBEE]/30 rounded-xl">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 bg-gradient-to-br from-[#018ABE] to-[#97CADB] rounded-xl flex items-center justify-center text-white font-bold text-xs shadow-md">📖</div>
                                        <div>
                                            <p class="text-sm font-semibold text-[#001B48] text-body">Bookworm</p>
                                            <p class="text-[10px] text-slate-500 font-medium text-body">Baca 5 materi</p>
                                        </div>
                                    </div>
                                    @if(($materiDibaca ?? 0) >= 5)
                                        <span class="text-emerald-600 text-xs font-bold">✓</span>
                                    @else
                                        <span class="text-slate-400 text-xs font-bold">○</span>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between p-3 bg-[#D6EBEE]/30 rounded-xl">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl flex items-center justify-center text-white font-bold text-xs shadow-md">⭐</div>
                                        <div>
                                            <p class="text-sm font-semibold text-[#001B48] text-body">High Scorer</p>
                                            <p class="text-[10px] text-slate-500 font-medium text-body">Skor 100 di quiz</p>
                                        </div>
                                    </div>
                                    @if(($rataSkor ?? 0) >= 100)
                                        <span class="text-emerald-600 text-xs font-bold">✓</span>
                                    @else
                                        <span class="text-slate-400 text-xs font-bold">○</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Study Streak Card -->
                        <div class="bg-gradient-to-br from-[#97CADB] to-[#D6EBEE] rounded-3xl p-6 shadow-sm card-hover">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-md">
                                    <span class="text-xl">🔥</span>
                                </div>
                                <h3 class="text-heading text-lg text-[#001B48]">Study Streak</h3>
                            </div>
                            <div class="text-body">
                                <div class="flex items-baseline gap-2 mb-2">
                                    <span class="text-heading text-4xl text-[#001B48]">{{ $streak ?? 0 }}</span>
                                    <span class="text-sm font-medium text-[#02457A]">hari berturut-turut</span>
                                </div>
                                <p class="text-xs text-[#02457A] font-medium">Terus pertahankan semangat belajarmu! 💪</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
