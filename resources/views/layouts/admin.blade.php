<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin') - Englify</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F1F5F9; }
    </style>
</head>
<body class="antialiased">
<div class="flex min-h-screen">

    <!-- Sidebar Desktop -->
    <aside class="hidden lg:flex w-64 bg-slate-900 text-white flex-col fixed h-full z-40">
        <div class="p-6 border-b border-white/10">
            <p class="text-xl font-extrabold">Englify</p>
            <p class="text-[11px] text-slate-400 font-medium uppercase tracking-wider mt-0.5">Admin Divisi Panel</p>
        </div>
        <nav class="flex-1 p-4 space-y-1.5 text-sm">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white font-bold' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                Dashboard
            </a>
            <a href="{{ route('admin.kategori') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.kategori*') ? 'bg-indigo-600 text-white font-bold' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                Kategori
            </a>
            <a href="{{ route('admin.materi') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.materi*') ? 'bg-indigo-600 text-white font-bold' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                Materi
            </a>
            <a href="{{ route('admin.quiz') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.quiz*') ? 'bg-indigo-600 text-white font-bold' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                Quiz
            </a>
            <a href="{{ route('admin.hasil-quiz') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.hasil-quiz*') ? 'bg-indigo-600 text-white font-bold' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                Hasil Quiz
            </a>
        </nav>
        <div class="p-4 border-t border-white/10">
            <p class="px-4 text-xs text-slate-400 truncate">{{ auth()->user()->nama ?? '' }}</p>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button class="w-full px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-300 hover:text-white hover:bg-white/10 text-left">Keluar</button>
            </form>
        </div>
    </aside>

    <!-- Konten -->
    <div class="flex-1 lg:ml-64 flex flex-col min-h-screen">
        <!-- Topbar Mobile -->
        <header class="lg:hidden bg-white border-b border-slate-200 px-4 py-3 flex items-center justify-between sticky top-0 z-30">
            <p class="font-extrabold text-slate-800">Englify Admin</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-xs font-bold text-rose-600">Keluar</button>
            </form>
        </header>
        <!-- Nav Mobile -->
        <nav class="lg:hidden bg-slate-900 text-white flex gap-1 p-2 overflow-x-auto text-xs font-semibold sticky top-[52px] z-30">
            <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-lg whitespace-nowrap {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600' : '' }}">Dashboard</a>
            <a href="{{ route('admin.kategori') }}" class="px-3 py-2 rounded-lg whitespace-nowrap {{ request()->routeIs('admin.kategori*') ? 'bg-indigo-600' : '' }}">Kategori</a>
            <a href="{{ route('admin.materi') }}" class="px-3 py-2 rounded-lg whitespace-nowrap {{ request()->routeIs('admin.materi*') ? 'bg-indigo-600' : '' }}">Materi</a>
            <a href="{{ route('admin.quiz') }}" class="px-3 py-2 rounded-lg whitespace-nowrap {{ request()->routeIs('admin.quiz*') ? 'bg-indigo-600' : '' }}">Quiz</a>
            <a href="{{ route('admin.hasil-quiz') }}" class="px-3 py-2 rounded-lg whitespace-nowrap {{ request()->routeIs('admin.hasil-quiz*') ? 'bg-indigo-600' : '' }}">Hasil Quiz</a>
        </nav>

        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            <div class="max-w-6xl mx-auto">
                @if(session('success'))
                <div class="mb-5 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold px-4 py-3 rounded-2xl flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">&times;</button>
                </div>
                @endif
                @if($errors->any())
                <div class="mb-5 bg-rose-50 border border-rose-200 text-rose-800 text-sm px-4 py-3 rounded-2xl">
                    <p class="font-bold mb-1">Terjadi kesalahan:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</div>
@stack('scripts')
</body>
</html>
