@extends('layouts.siswa')

@section('title', 'Reminder')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
        <div class="flex items-center gap-3 sm:gap-4">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-[#97CADB] flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-800">Reminder</h1>
                <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Pengingat, instruksi, dan feedback dari admin.</p>
            </div>
        </div>
        <div class="flex items-center gap-2 self-start sm:self-auto">
            <div class="flex items-center gap-2 text-xs sm:text-sm bg-white px-3 sm:px-4 py-2 sm:py-2.5 rounded-xl border border-[#97CADB]/30 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-[#018ABE] animate-pulse"></span>
                <span class="font-semibold text-slate-700">{{ $pesanList->where('is_read', false)->count() }} Belum Dibaca</span>
            </div>
            @if($pesanList->count() > 0)
                <form action="{{ route('siswa.reminder.clearAll') }}" method="POST" onsubmit="return confirmClearAll(event)">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-xs font-bold text-slate-500 hover:text-rose-600 bg-white hover:bg-rose-50 border border-slate-200 hover:border-rose-200 px-3 py-2 rounded-xl transition flex items-center gap-1.5 shadow-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        <span>Bersihkan</span>
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- LIST REMINDER -->
    <div class="space-y-3 sm:space-y-4">
        @forelse($pesanList as $pesan)

            @if(!$pesan->is_read)
                <form id="readForm-{{ $pesan->id }}" action="{{ route('siswa.reminder.read', $pesan->id) }}" method="POST" class="hidden">
                    @csrf
                </form>
            @endif

            <div onclick="@if(!$pesan->is_read) document.getElementById('readForm-{{ $pesan->id }}').submit(); @endif"
                 class="bg-white rounded-2xl border {{ $pesan->is_read ? 'border-[#97CADB]/30' : 'border-[#97CADB]/40 ring-2 ring-[#018ABE]' }} shadow-sm p-4 sm:p-5 cursor-pointer hover:shadow-md transition group relative">

                @if(!$pesan->is_read)
                    <div class="absolute top-3.5 right-3.5 sm:top-4 sm:right-4 w-2.5 h-2.5 sm:w-3 sm:h-3 bg-[#018ABE] rounded-full animate-pulse"></div>
                @endif

                <div class="flex items-start gap-3 sm:gap-4">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-br from-[#018ABE] to-[#02457A] flex items-center justify-center text-white font-bold text-xs sm:text-sm shrink-0">
                        {{ substr($pesan->admin->nama ?? 'A', 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1 flex-wrap gap-1.5 sm:gap-2">
                            <h4 class="text-xs sm:text-sm font-bold text-slate-800">
                                {{ $pesan->admin->nama ?? 'Admin Divisi' }}
                            </h4>
                            <div class="flex items-center gap-1.5 sm:gap-2">
                                <span class="text-[9px] sm:text-[10px] text-slate-400">{{ $pesan->created_at->diffForHumans() }}</span>
                                <form action="{{ route('siswa.reminder.destroy', $pesan->id) }}" method="POST" onsubmit="return confirmDeletePesan(event)" onclick="event.stopPropagation()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg text-slate-300 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center transition" title="Hapus reminder ini">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed whitespace-pre-line break-words">{{ $pesan->pesan }}</p>

                        <div class="mt-2.5 sm:mt-3 flex items-center gap-2">
                            @if($pesan->is_read)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-slate-100 text-slate-500 text-[10px] font-bold rounded-full">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Sudah dibaca
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-[#97CADB] text-[#02457A] text-[10px] font-bold rounded-full">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    Belum dibaca
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="bg-white rounded-2xl border border-[#97CADB]/30 shadow-sm p-8 sm:p-12 text-center">
                <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto mb-4 rounded-full bg-slate-100 flex items-center justify-center">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <h3 class="text-base sm:text-lg font-bold text-slate-800 mb-1">Belum ada reminder</h3>
                <p class="text-xs sm:text-sm text-slate-500">Admin belum mengirimkan pengingat atau instruksi apapun untukmu.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection

@push('scripts')
<script>
function confirmClearAll(event) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    const form = event ? event.target.closest('form') : null;
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'warning',
            title: 'Bersihkan Semua Reminder?',
            html: '<p class="text-sm text-slate-600">Semua pesan reminder akan dihapus dari daftar akun Anda.</p>',
            showCancelButton: true,
            confirmButtonText: 'Ya, Bersihkan',
            cancelButtonText: 'Batal',
            buttonsStyling: false,
            customClass: {
                popup: 'englify-swal',
                confirmButton: 'englify-swal-danger',
                cancelButton: 'englify-swal-cancel'
            }
        }).then((res) => {
            if (res.isConfirmed && form) form.submit();
        });
        return false;
    }
    if (form) form.submit();
    return false;
}

function confirmDeletePesan(event) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    const form = event ? event.target.closest('form') : null;
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'warning',
            title: 'Hapus Pesan Reminder?',
            html: '<p class="text-sm text-slate-600">Pesan pengingat ini akan dihapus dari daftar Anda.</p>',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            buttonsStyling: false,
            customClass: {
                popup: 'englify-swal',
                confirmButton: 'englify-swal-danger',
                cancelButton: 'englify-swal-cancel'
            }
        }).then((res) => {
            if (res.isConfirmed && form) form.submit();
        });
        return false;
    }
    if (form) form.submit();
    return false;
}
</script>
@endpush
