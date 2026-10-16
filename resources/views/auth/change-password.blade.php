<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password - Englify</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .bg-navy { background-color: #1e3a5f; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-blue-100 min-h-screen flex items-center justify-center p-4">

    <!-- Logo Pojok Kiri Atas -->
    <a href="/login" class="absolute top-6 left-6 flex items-center gap-2">
        <div class="w-10 h-10 bg-navy rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <span class="text-2xl font-bold text-navy">englify</span>
    </a>

    <!-- Card Ganti Password -->
    <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-md border border-gray-100 relative z-10">

        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Ganti Password Wajib</h2>
            <p class="text-sm text-gray-500 mt-2">Anda login menggunakan password default. Demi keamanan akun, silakan buat password baru Anda.</p>
        </div>

        <!-- Tampilkan Error jika ada -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('update.password') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password Lama (NIPD/NIS)</label>
                <input type="password" name="current_password" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Masukkan password lama">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password Baru</label>
                <input type="password" name="new_password" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Minimal 6 karakter">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Password Baru</label>
                <input type="password" name="new_password_confirmation" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Ulangi password baru">
            </div>

            <button type="submit" class="w-full bg-navy text-white py-3 rounded-lg font-bold hover:bg-blue-900 transition shadow-lg mt-2">
                Simpan Password Baru
            </button>
        </form>
    </div>

    <!-- Footer -->
    <footer class="absolute bottom-0 w-full bg-navy text-white py-4 text-center text-sm">
        <p>© 2026 Englify. Tim Lunar Way.</p>
    </footer>

</body>
</html>
