<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mengerjakan Quiz - Englify</title>
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
        .option-radio:checked + div {
            background: linear-gradient(135deg, #D6E8EE 0%, #97CADB 100%);
            border-color: #182B4B;
        }
        .option-radio:checked + div .option-letter {
            background: #182B4B;
            color: white;
        }
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
                <a href="/siswa/quiz" class="flex items-center gap-3 py-3 px-4 bg-white/10 text-white rounded-xl font-semibold text-sm border border-white/10 shadow-lg relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-sky-300"></div>
                    <svg class="w-5 h-5 text-sky-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Daftar Quiz
                </a>
                <a href="/siswa/progress" class="flex items-center gap-3 py-3 px-4 text-white/50 hover:text-white hover:bg-white/5 rounded-xl font-medium text-sm transition">Progress Saya</a>
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
            <a href="/siswa/quiz" class="flex flex-col items-center gap-1 p-2 text-navy-800">
                <div class="w-10 h-10 bg-navy-50 rounded-2xl flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg></div>
                <span class="text-[10px] font-bold">Quiz</span>
            </a>
            <a href="/siswa/progress" class="flex flex-col items-center gap-1 p-2 text-slate-400 hover:text-navy-800 transition">
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg></div>
                <span class="text-[10px] font-medium">Progress</span>
            </a>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 lg:ml-72 min-h-screen pb-24 lg:pb-8 bg-gradient-to-br from-sky-50/30 via-white to-navy-50/30">
            <header class="sticky top-0 z-30 glass border-b border-slate-200/60 px-4 lg:px-8 py-4 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="/siswa/quiz" class="p-2 hover:bg-sky-50 rounded-lg transition">
                        <svg class="w-5 h-5 text-navy-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <div>
                        <h1 class="font-display font-bold text-xl lg:text-2xl text-navy-900">Mengerjakan Quiz</h1>
                        <p class="text-xs text-slate-500 hidden sm:block">Pilih jawaban yang paling tepat</p>
                    </div>
                </div>
            </header>

            <div class="p-4 lg:p-8 max-w-4xl mx-auto">
                @if($existingAttempt)
                    <!-- Sudah Mengerjakan -->
                    <div class="bg-white rounded-2xl lg:rounded-3xl p-8 lg:p-12 border border-slate-100 shadow-sm text-center">
                        <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h2 class="font-display font-bold text-2xl lg:text-3xl text-navy-900 mb-2">Kamu Sudah Mengerjakan Quiz Ini!</h2>
                        <p class="text-slate-600 mb-6">Skor kamu: <span class="font-bold text-emerald-600 text-xl">{{ $existingAttempt->skor_diperoleh }}/{{ $existingAttempt->quiz->poin ?? 0 }}</span></p>
                        <a href="/siswa/progress" class="inline-block px-6 py-3 bg-navy-800 text-white rounded-xl font-bold hover:bg-navy-700 transition shadow-lg">Lihat Progress</a>
                    </div>
                @else
                    <!-- Form Quiz -->
                    <form method="POST" action="{{ route('siswa.quiz.submit', $quiz->id_quiz) }}" class="space-y-6">
                        @csrf

                        <!-- Info Quiz -->
                        <div class="bg-white rounded-2xl lg:rounded-3xl p-6 lg:p-8 border border-slate-100 shadow-sm">
                            <div class="flex flex-wrap items-center gap-2 mb-4">
                                <span class="px-3 py-1 bg-sky-100 text-navy-800 text-xs font-bold rounded-full">{{ $quiz->materi->kategori->nama_kategori ?? 'Umum' }}</span>
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full">{{ $quiz->poin }} Poin</span>
                            </div>
                            <h2 class="font-display font-bold text-2xl lg:text-3xl text-navy-900 mb-2">{{ $quiz->judul }}</h2>
                            <p class="text-sm text-slate-500">Materi: {{ $quiz->materi->judul }}</p>
                        </div>

                        <!-- Pertanyaan -->
                        <div class="bg-white rounded-2xl lg:rounded-3xl p-6 lg:p-8 border border-slate-100 shadow-sm">
                            <label class="block text-xs font-bold text-navy-900 mb-3 uppercase tracking-wider">Pertanyaan:</label>
                            <div class="p-4 lg:p-6 bg-sky-50/50 rounded-2xl border border-sky-100">
                                <p class="text-slate-800 text-base lg:text-lg font-medium">{{ $quiz->pertanyaan }}</p>
                            </div>
                        </div>

                        <!-- Pilihan Jawaban -->
                        <div class="bg-white rounded-2xl lg:rounded-3xl p-6 lg:p-8 border border-slate-100 shadow-sm">
                            <label class="block text-xs font-bold text-navy-900 mb-4 uppercase tracking-wider">Pilih Jawaban:</label>

                            <div class="space-y-3">
                                <label class="block cursor-pointer">
                                    <input type="radio" name="jawaban" value="A" required class="option-radio hidden">
                                    <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border-2 border-slate-200 hover:border-sky-300 transition">
                                        <div class="option-letter w-10 h-10 bg-white rounded-xl flex items-center justify-center font-bold text-navy-900 border-2 border-slate-200 transition">A</div>
                                        <span class="text-slate-800 font-medium">{{ $quiz->pilihan_a }}</span>
                                    </div>
                                </label>

                                <label class="block cursor-pointer">
                                    <input type="radio" name="jawaban" value="B" required class="option-radio hidden">
                                    <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border-2 border-slate-200 hover:border-sky-300 transition">
                                        <div class="option-letter w-10 h-10 bg-white rounded-xl flex items-center justify-center font-bold text-navy-900 border-2 border-slate-200 transition">B</div>
                                        <span class="text-slate-800 font-medium">{{ $quiz->pilihan_b }}</span>
                                    </div>
                                </label>

                                <label class="block cursor-pointer">
                                    <input type="radio" name="jawaban" value="C" required class="option-radio hidden">
                                    <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border-2 border-slate-200 hover:border-sky-300 transition">
                                        <div class="option-letter w-10 h-10 bg-white rounded-xl flex items-center justify-center font-bold text-navy-900 border-2 border-slate-200 transition">C</div>
                                        <span class="text-slate-800 font-medium">{{ $quiz->pilihan_c }}</span>
                                    </div>
                                </label>

                                <label class="block cursor-pointer">
                                    <input type="radio" name="jawaban" value="D" required class="option-radio hidden">
                                    <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border-2 border-slate-200 hover:border-sky-300 transition">
                                        <div class="option-letter w-10 h-10 bg-white rounded-xl flex items-center justify-center font-bold text-navy-900 border-2 border-slate-200 transition">D</div>
                                        <span class="text-slate-800 font-medium">{{ $quiz->pilihan_d }}</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="/siswa/quiz" class="flex-1 px-6 py-3.5 bg-slate-100 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-200 transition text-center">Batal</a>
                            <button type="submit" class="flex-1 px-6 py-3.5 bg-navy-800 text-white rounded-xl text-sm font-bold hover:bg-navy-700 transition shadow-lg flex items-center justify-center gap-2 group">
                                Submit Jawaban
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </main>
    </div>

</body>
</html>
