@extends('layouts.superadmin')

@section('title', 'Profil Super Admin')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                Profil Super Admin
            </h1>
            <p class="text-slate-500 mt-1 ml-1">Kelola profil dan informasi keamanan akun Anda.</p>
        </div>
    </div>

    <!-- Profile Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-32 sm:h-40"></div>
        <div class="px-6 sm:px-8 pb-6">
            <div class="relative flex flex-col sm:flex-row items-center sm:items-end -mt-12 sm:-mt-16 mb-6 gap-4">
                <!-- Avatar -->
                <div class="relative">
                    <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-2xl bg-white p-2 shadow-lg">
                        <div class="w-full h-full rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white">
                            <svg class="w-16 h-16 sm:w-20 sm:h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-emerald-500 rounded-full border-4 border-white flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>

                <!-- Name & Badge -->
                <div class="text-center sm:text-left sm:flex-1 sm:mb-2">
                    <h2 class="text-2xl font-bold text-slate-800">{{ auth()->user()->nama ?? auth()->user()->name }}</h2>
                    <div class="flex items-center justify-center sm:justify-start gap-2 mt-1">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Super Admin
                        </span>
                        <span class="text-slate-400 text-sm">•</span>
                        <span class="text-slate-500 text-sm">{{ auth()->user()->email }}</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <button onclick="openEditModal()" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition shadow-lg shadow-blue-600/30">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Profil
                    </button>
                    <button onclick="openPasswordModal()" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Ubah Password
                    </button>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 pt-6 border-t border-slate-100">
                <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium">Email</p>
                        <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50">
                    <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium">Telepon</p>
                        <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->telepon ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50">
                    <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium">Lokasi</p>
                        <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->lokasi ?? 'Indonesia' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informasi Akun -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-slate-800">Informasi Akun</h3>
                <button onclick="openEditModal()" class="text-blue-600 hover:text-blue-700 text-sm font-semibold">
                    Edit
                </button>
            </div>

            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 rounded-xl bg-slate-50 hover:bg-slate-100 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-medium">Nama Lengkap</p>
                            <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->nama ?? auth()->user()->name }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between p-4 rounded-xl bg-slate-50 hover:bg-slate-100 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-medium">Email</p>
                            <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between p-4 rounded-xl bg-slate-50 hover:bg-slate-100 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-medium">Role</p>
                            <p class="text-sm font-semibold text-slate-800">Super Admin</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between p-4 rounded-xl bg-slate-50 hover:bg-slate-100 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

                <div class="flex items-center justify-between p-4 rounded-xl bg-slate-50 hover:bg-slate-100 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-rose-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-medium">Terdaftar Sejak</p>
                            <p class="text-sm font-semibold text-slate-800">{{ \Carbon\Carbon::parse(auth()->user()->created_at)->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Tambahan & Activity -->
        <div class="space-y-6">
            <!-- Activity Log -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-6">Aktivitas Terakhir</h3>
                <div class="space-y-4">
                    <div class="flex gap-3">
                        <div class="w-2 h-2 rounded-full bg-blue-500 mt-2 shrink-0"></div>
                        <div class="flex-1 pb-4 border-b border-slate-100">
                            <p class="text-sm font-semibold text-slate-800">Login berhasil</p>
                            <p class="text-xs text-slate-500 mt-1">{{ \Carbon\Carbon::now()->format('d M Y, H:i') }}</p>
                            <p class="text-xs text-slate-400 mt-1">IP: 192.168.1.100</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 mt-2 shrink-0"></div>
                        <div class="flex-1 pb-4 border-b border-slate-100">
                            <p class="text-sm font-semibold text-slate-800">Menambahkan akun siswa</p>
                            <p class="text-xs text-slate-500 mt-1">{{ \Carbon\Carbon::now()->subDays(1)->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="w-2 h-2 rounded-full bg-purple-500 mt-2 shrink-0"></div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-slate-800">Update profil</p>
                            <p class="text-xs text-slate-500 mt-1">{{ \Carbon\Carbon::now()->subDays(3)->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Info -->
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-lg p-6 text-white">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold">Keamanan Akun</p>
                        <p class="text-xs text-blue-100">Terlindungi</p>
                    </div>
                </div>
                <p class="text-sm text-blue-50 mb-4">Akun Anda dilindungi dengan enkripsi tingkat tinggi.</p>
                <button onclick="openPasswordModal()" class="w-full py-2.5 bg-white text-blue-600 font-semibold rounded-xl text-sm hover:bg-blue-50 transition">
                    Ubah Password
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div id="editModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
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
                <input type="text" value="{{ auth()->user()->nama ?? auth()->user()->name }}"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                <input type="email" value="{{ auth()->user()->email }}"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Telepon</label>
                <input type="text" value="{{ auth()->user()->telepon ?? '' }}" placeholder="08123456789"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Lokasi</label>
                <input type="text" value="{{ auth()->user()->lokasi ?? 'Indonesia' }}"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
            </div>
            <div class="pt-4 flex gap-3">
                <button type="button" onclick="closeEditModal()"
                        class="flex-1 px-4 py-2.5 border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 transition">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-600/30 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Change Password Modal -->
<div id="passwordModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-xl font-bold text-slate-800">Ubah Password</h3>
            <button onclick="closePasswordModal()" class="p-2 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Password Lama</label>
                <input type="password" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition" placeholder="••••••••">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Password Baru</label>
                <input type="password" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition" placeholder="••••••••">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password Baru</label>
                <input type="password" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition" placeholder="••••••••">
            </div>
            <div class="pt-4 flex gap-3">
                <button type="button" onclick="closePasswordModal()"
                        class="flex-1 px-4 py-2.5 border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 transition">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-600/30 transition">
                    Ubah Password
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openEditModal() {
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
}

function openPasswordModal() {
    document.getElementById('passwordModal').classList.remove('hidden');
    document.getElementById('passwordModal').classList.add('flex');
}

function closePasswordModal() {
    document.getElementById('passwordModal').classList.add('hidden');
    document.getElementById('passwordModal').classList.remove('flex');
}
</script>
@endpush
