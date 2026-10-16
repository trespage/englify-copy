<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Saya - Englify</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { display: ['Space Grotesk', 'sans-serif'], body: ['Inter', 'sans-serif'] },
                    colors: {
                        navy: { 50: '#f4f6f9', 100: '#e8ecf2', 200: '#d1d9e6', 500: '#3d5a80', 700: '#1e3a5f', 800: '#182B4B', 900: '#0f1c35' },
                        sky: { 50: '#f0f9fc', 100: '#D6E8EE', 200: '#97CADB', 300: '#018ABE' }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
    </style>
</head>
<body class="antialiased">

    <div class="flex min-h-screen">
        <!-- Desktop Sidebar -->
        <aside class="hidden lg:flex fixed left-0 top-0 h-full w-72 bg-navy-900 text-white flex-col z-40">
            <div class="p-6 border-b border-white/5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-navy-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <span class="font-display font-bold text-xl block">englify</span>
                        <span class="text-[10px] text-sky-300 font-bold uppercase">Siswa</span>
                    </div>
                </div>
            </div>
            <nav class="flex-1 p-4 space-y-1">
                <p class="px-4 py-2 text-[10px] font-bold text-white/30 uppercase">Menu Utama</p>
                <a href="/siswa/dashboard" class="flex items-center gap-3 py-3 px-4 text-white/50 hover:text-white hover:bg-white/5 rounded-xl font-medium text-sm transition">Dashboard</a>
                <a href="/siswa/materi" class="flex items-center gap-3 py-3 px-4 text-white/50 hover:text-white hover:bg-white/5 rounded-xl font-medium text-sm transition">Materi</a>
                <a href="/siswa/quiz" class="flex items-center gap-3 py-3 px-4 text-white/50 hover:text-white hover:bg-white/5 rounded-xl font-medium text-sm transition">Quiz</a>
                <a href="/siswa/progress" class="flex items-center gap-3 py-3 px-4 bg-white/10 text-white rounded-xl font-semibold text-sm border border-white/10 shadow-lg relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-sky-300"></div>
                    Progress Saya
                </a>
            </nav>
            <div class="p-4 border-t border-white/5">
                <div class="bg-white/5 rounded-2xl p-3 flex items-center gap-3 border border-white/10">
                    <div class="w-10 h-10 bg-gradient-to-br from-sky-300 to-sky-400 rounded-xl flex items-center justify-center text-navy-900 font-bold text-sm">
                        {{ strtoupper(substr(auth()->user()->nama ?? 'S', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-white truncate">{{ auth()->user()->nama ?? 'Siswa' }}</p>
                        <p class="text-[10px] text-white/40 truncate">{{ auth()->user()->email ?? 'siswa@englify.com' }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Mobile Bottom Navigation -->
        <nav class="lg:hidden fixed bottom-0 left-0 right-0 glass border-t border-slate-200 z-50 flex justify-around py-2 px-1 shadow-[0_-10px_40px_-15px_rgba(0,0,0,0.1)]">
            <a href="/siswa/dashboard" class="flex flex-col items-center gap-1 p-2 text-slate-400 hover:text-navy-800 transition">
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg></div>
                <span class="text-[10px] font-medium">Home</span>
            </a>
            <a href="/siswa/materi" class="flex flex-col items-center gap-1 p-2 text-slate-400 hover:text-navy-800 transition">
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg></div>
                <span class="text-[10px] font-medium">Materi</span>
            </a>
            <a href="/siswa/quiz" class="flex flex-col items-center gap-1 p-2 text-slate-400 hover:text-navy-800 transition">
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg></div>
                <span class="text-[10px] font-medium">Quiz</span>
            </a>
            <a href="/siswa/progress" class="flex flex-col items-center gap-1 p-2 text-navy-800">
                <div class="w-10 h-10 bg-navy-50 rounded-2xl flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg></div>
                <span class="text-[10px] font-bold">Progress</span>
            </a>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 lg:ml-72 min-h-screen pb-24 lg:pb-8 bg-gradient-to-br from-sky-50/30 via-white to-navy-50/30">
            <header class="sticky top-0 z-30 glass border-b border-slate-200/60 px-4 lg:px-8 py-4 flex items-center justify-between">
                <div>
                    <h1 class="font-display font-bold text-xl lg:text-2xl text-navy-900">Progress Saya</h1>
                    <p class="text-xs text-slate-500 hidden sm:block">Pantau perkembangan belajarmu</p>
                </div>
                <div class="text-right hidden sm:block">
                    <p class="text-[10px] text-slate-500 uppercase font-bold">Hari ini</p>
                    <p class="text-sm font-bold text-navy-900 font-display">{{ now()->format('d M Y') }}</p>
                </div>
            </header>

            <div class="p-4 lg:p-8 max-w-7xl mx-auto">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-3">
                        <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <p class="text-sm font-medium text-emerald-700">{{ session('success') }}</p>
                    </div>
                @endif

                <!-- Stats Cards -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-4 mb-6">
                    <div class="bg-white rounded-2xl lg:rounded-3xl p-4 lg:p-6 border border-slate-100 shadow-sm">
                        <div class="w-10 h-10 lg:w-12 lg:h-12 bg-sky-50 rounded-xl lg:rounded-2xl flex items-center justify-center mb-2 lg:mb-3">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-sky-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <div class="font-display font-bold text-2xl lg:text-3xl text-navy-900">{{ $materiDibaca }}/{{ $totalMateri }}</div>
                        <div class="text-[10px] lg:text-xs text-slate-500 mt-1">Materi Dibaca</div>
                    </div>

                    <div class="bg-white rounded-2xl lg:rounded-3xl p-4 lg:p-6 border border-slate-100 shadow-sm">
                        <div class="w-10 h-10 lg:w-12 lg:h-12 bg-navy-50 rounded-xl lg:rounded-2xl flex items-center justify-center mb-2 lg:mb-3">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-navy-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <div class="font-display font-bold text-2xl lg:text-3xl text-navy-900">{{ $totalQuiz }}</div>
                        <div class="text-[10px] lg:text-xs text-slate-500 mt-1">Quiz Dikerjakan</div>
                    </div>

                    <div class="bg-white rounded-2xl lg:rounded-3xl p-4 lg:p-6 border border-slate-100 shadow-sm">
                        <div class="w-10 h-10 lg:w-12 lg:h-12 bg-emerald-50 rounded-xl lg:rounded-2xl flex items-center justify-center mb-2 lg:mb-3">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <div class="font-display font-bold text-2xl lg:text-3xl text-navy-900">{{ round($riwayat->avg('skor_diperoleh') ?? 0) }}</div>
                        <div class="text-[10px] lg:text-xs text-slate-500 mt-1">Rata-rata Skor</div>
                    </div>

                    <div class="bg-gradient-to-br from-sky-300 to-sky-400 rounded-2xl lg:rounded-3xl p-4 lg:p-6 shadow-sm text-navy-900 col-span-2 lg:col-span-1">
                        <div class="w-10 h-10 lg:w-12 lg:h-12 bg-white/30 backdrop-blur rounded-xl lg:rounded-2xl flex items-center justify-center mb-2 lg:mb-3">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-navy-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="font-display font-bold text-2xl lg:text-3xl">{{ $totalSkor }}</div>
                        <div class="text-[10px] lg:text-xs text-navy-800/70 mt-1">Total Poin</div>
                    </div>
                </div>

                <!-- Timeline Riwayat Quiz -->
                <div class="bg-white rounded-2xl lg:rounded-3xl p-5 lg:p-6 border border-slate-100 shadow-sm">
                    <h3 class="font-display font-bold text-lg text-navy-900 mb-6">Riwayat Pengerjaan Quiz</h3>

                    <div class="space-y-4">
                        @forelse($riwayat as $attempt)
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-4 h-4 bg-sky-300 rounded-full border-4 border-white shadow flex-shrink-0"></div>
                                @if(!$loop->last)
                                    <div class="w-0.5 h-full bg-slate-200 my-1"></div>
                                @endif
                            </div>

                            <div class="flex-1 bg-sky-50/50 rounded-2xl p-4 border border-sky-100 mb-4">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-2 gap-2">
                                    <h4 class="font-bold text-navy-900">{{ $attempt->quiz->judul ?? 'Quiz' }}</h4>
                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full self-start">{{ $attempt->skor_diperoleh }}/{{ $attempt->quiz->poin ?? 0 }}</span>
                                </div>
                                <p class="text-xs text-slate-600 mb-2">Materi: {{ $attempt->quiz->materi->judul ?? '-' }}</p>
                                <div class="flex items-center gap-2 text-[10px] text-slate-500">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $attempt->created_at->format('d M Y, H:i') }}
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-sky-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            <p class="text-slate-500 font-medium">Kamu belum mengerjakan quiz apapun</p>
                            <a href="/siswa/quiz" class="inline-block mt-4 px-6 py-2.5 bg-navy-800 text-white rounded-xl text-sm font-bold hover:bg-navy-700 transition">Mulai Mengerjakan Quiz</a>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
