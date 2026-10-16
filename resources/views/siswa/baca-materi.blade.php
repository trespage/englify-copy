<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $materi->judul }} - Englify</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen flex">

    <!-- Sidebar (Sama seperti dashboard siswa) -->
    <aside class="w-64 bg-white border-r border-slate-200 flex flex-col fixed h-full z-10">
        <div class="p-6 border-b border-slate-100">
            <a href="/siswa/dashboard" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/30">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-slate-900">Kembali</h1>
                    <p class="text-[10px] text-slate-500 font-medium uppercase tracking-wider">Ke Dashboard</p>
                </div>
            </a>
        </div>
        <div class="flex-1 p-4">
            <div class="p-4 bg-emerald-50 rounded-xl border border-emerald-100">
                <p class="text-xs font-bold text-emerald-800 uppercase tracking-wider mb-1">Sedang Mempelajari</p>
                <p class="text-sm font-semibold text-emerald-900 line-clamp-3">{{ $materi->judul }}</p>
                <p class="text-xs text-emerald-600 mt-2">Bab {{ $materi->bab }} • {{ $materi->kategori->nama_kategori }}</p>
            </div>
        </div>
        <div class="p-4 border-t border-slate-100">
            <form action="/logout" method="POST">
                @csrf
                <button class="w-full flex items-center justify-center gap-2 py-2 px-4 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg font-medium text-sm transition">Logout</button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-64 p-8 lg:p-12">
        <div class="max-w-4xl mx-auto bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <!-- Header Materi -->
            <div class="p-8 border-b border-slate-100 bg-slate-50/50">
                <div class="flex items-center gap-3 mb-4">
                    <span class="px-3 py-1 text-xs font-bold bg-emerald-100 text-emerald-700 rounded-full">
                        {{ $materi->kategori->nama_kategori }}
                    </span>
                    <span class="text-sm text-slate-500 font-medium">Bab {{ $materi->bab }}</span>
                </div>
                <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-900 mb-4">{{ $materi->judul }}</h1>
                @if($materi->deskripsi)
                    <p class="text-lg text-slate-600 leading-relaxed">{{ $materi->deskripsi }}</p>
                @endif
            </div>

            <!-- Isi Materi -->
            <div class="p-8 lg:p-12">
                <div class="prose prose-slate max-w-none prose-headings:font-bold prose-headings:text-slate-900 prose-p:text-slate-700 prose-p:leading-relaxed">
                    <!-- Menggunakan nl2br agar enter dari textarea menjadi baris baru -->
                    {!! nl2br(e($materi->isi_materi)) !!}
                </div>

                @if($materi->audio_url || $materi->transcript)
                <div class="mt-12 p-6 bg-slate-50 rounded-xl border border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                        Audio & Transcript
                    </h3>
                    @if($materi->audio_url)
                        <audio controls class="w-full mb-4">
                            <source src="{{ $materi->audio_url }}" type="audio/mpeg">
                            Browser Anda tidak mendukung elemen audio.
                        </audio>
                    @endif
                    @if($materi->transcript)
                        <div class="bg-white p-4 rounded-lg border border-slate-200">
                            <p class="text-xs font-bold text-slate-500 uppercase mb-2">Transcript</p>
                            <p class="text-sm text-slate-700 italic">{{ $materi->transcript }}</p>
                        </div>
                    @endif
                </div>
                @endif

                <!-- Tombol Selesai -->
                <div class="mt-12 pt-8 border-t border-slate-100 flex justify-between items-center">
                    <a href="/siswa/dashboard" class="text-slate-600 hover:text-slate-900 font-medium flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Daftar Materi
                    </a>
                    <button class="px-6 py-3 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition shadow-lg shadow-emerald-500/30 flex items-center gap-2">
                        Tandai Selesai
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
