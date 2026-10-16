<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - Englify</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-slate-200 flex flex-col fixed h-full z-10">
        <div class="p-6 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/30">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-slate-900">Englify</h1>
                    <p class="text-[10px] text-slate-500 font-medium uppercase tracking-wider">Siswa Panel</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 p-4 space-y-1">
            <a href="/siswa/dashboard" class="flex items-center gap-3 py-2.5 px-3 bg-emerald-50 text-emerald-700 rounded-lg font-semibold text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Materi Belajar
            </a>
            <a href="#" class="flex items-center gap-3 py-2.5 px-3 text-slate-600 hover:bg-slate-50 rounded-lg font-medium text-sm transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                Quiz Saya
            </a>
        </nav>

        <div class="p-4 border-t border-slate-100">
            <div class="flex items-center gap-3 p-2 rounded-lg bg-slate-50 mb-3">
                <div class="w-9 h-9 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-full flex items-center justify-center text-white font-bold text-sm">
                    {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-800 truncate">{{ auth()->user()->nama }}</p>
                    <p class="text-[10px] text-slate-500 truncate">Siswa</p>
                </div>
            </div>
            <form action="/logout" method="POST">
                @csrf
                <button class="w-full flex items-center justify-center gap-2 py-2 px-4 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg font-medium text-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-64 p-8">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-900">Materi Pembelajaran</h1>
            <p class="text-slate-500 mt-1">Pilih materi di bawah ini untuk mulai belajar.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($materis as $item)
            <a href="{{ route('siswa.materi.baca', $item->id_materi) }}" class="group bg-white rounded-xl border border-slate-200 p-6 hover:shadow-lg hover:border-emerald-300 transition-all duration-300">
                <div class="flex items-start justify-between mb-4">
                    <span class="px-3 py-1 text-xs font-bold bg-emerald-50 text-emerald-700 rounded-full border border-emerald-100">
                        {{ $item->kategori->nama_kategori ?? 'Umum' }}
                    </span>
                    <span class="text-xs text-slate-400 font-medium">Bab {{ $item->bab }}</span>
                </div>

                <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-emerald-700 transition line-clamp-2">
                    {{ $item->judul }}
                </h3>

                <p class="text-sm text-slate-500 mb-4 line-clamp-3">
                    {{ $item->deskripsi ?: Str::limit($item->isi_materi, 100) }}
                </p>

                <div class="flex items-center text-emerald-600 text-sm font-semibold group-hover:translate-x-1 transition-transform">
                    Baca Materi
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </a>
            @empty
            <div class="col-span-full text-center py-16 bg-white rounded-xl border border-slate-200 border-dashed">
                <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <h3 class="text-lg font-semibold text-slate-700">Belum Ada Materi</h3>
                <p class="text-slate-500 mt-1">Tunggu Admin Divisi mempublikasikan materi untukmu.</p>
            </div>
            @endforelse
        </div>
    </main>
</body>
</html>
