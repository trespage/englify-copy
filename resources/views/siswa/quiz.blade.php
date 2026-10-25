@extends('layouts.siswa')

@section('title', 'Kerjakan Quiz')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- ===================================================== -->
    <!-- HEADER + PROGRESS                                      -->
    <!-- ===================================================== -->
    <div class="bg-white rounded-2xl p-6 border border-[#97CADB]/30 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#97CADB] flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#02457A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-extrabold text-slate-800">Quiz - Bab 1: Basic Grammar</h1>
                    <p class="text-xs text-slate-500 mt-0.5">Pilih jawaban yang paling tepat!</p>
                </div>
            </div>
            <div class="flex items-center gap-2 px-4 py-2 bg-rose-50 border border-rose-200 rounded-xl">
                <svg class="w-5 h-5 text-rose-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-lg font-bold text-rose-600 tabular-nums" id="timer">00:42</span>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold text-slate-600">Soal 3 dari 10</span>
            <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-[#018ABE] to-[#02457A] rounded-full transition-all" style="width: 30%"></div>
            </div>
            <span class="text-xs font-bold text-slate-600">30%</span>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- PERTANYAAN                                             -->
    <!-- ===================================================== -->
    <div class="bg-white rounded-2xl border border-[#97CADB]/30 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-[#97CADB]/20 bg-gradient-to-r from-[#D6EBEE] to-[#97CADB]/30">
            <h3 class="font-bold text-slate-800 text-lg">
                3. Which sentence is correct in the simple present tense?
            </h3>
        </div>

        <div class="p-6 space-y-3">
            <!-- Opsi A -->
            <label class="flex items-center gap-4 p-4 border-2 border-[#97CADB]/30 rounded-xl cursor-pointer hover:border-[#97CADB] hover:bg-[#D6EBEE] transition group">
                <input type="radio" name="jawaban" value="A" class="w-5 h-5 text-[#018ABE] border-slate-300 focus:ring-[#018ABE]">
                <span class="flex-1 text-sm font-medium text-slate-700 group-hover:text-slate-900">She go to school every day.</span>
            </label>

            <!-- Opsi B (Selected) -->
            <label class="flex items-center gap-4 p-4 border-2 border-[#018ABE] bg-[#D6EBEE] rounded-xl cursor-pointer transition group">
                <input type="radio" name="jawaban" value="B" checked class="w-5 h-5 text-[#018ABE] border-slate-300 focus:ring-[#018ABE]">
                <span class="flex-1 text-sm font-medium text-slate-700">She goes to school every day.</span>
                <svg class="w-5 h-5 text-[#018ABE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </label>

            <!-- Opsi C -->
            <label class="flex items-center gap-4 p-4 border-2 border-[#97CADB]/30 rounded-xl cursor-pointer hover:border-[#97CADB] hover:bg-[#D6EBEE] transition group">
                <input type="radio" name="jawaban" value="C" class="w-5 h-5 text-[#018ABE] border-slate-300 focus:ring-[#018ABE]">
                <span class="flex-1 text-sm font-medium text-slate-700 group-hover:text-slate-900">She going to school every day.</span>
            </label>

            <!-- Opsi D -->
            <label class="flex items-center gap-4 p-4 border-2 border-[#97CADB]/30 rounded-xl cursor-pointer hover:border-[#97CADB] hover:bg-[#D6EBEE] transition group">
                <input type="radio" name="jawaban" value="D" class="w-5 h-5 text-[#018ABE] border-slate-300 focus:ring-[#018ABE]">
                <span class="flex-1 text-sm font-medium text-slate-700 group-hover:text-slate-900">She goes to school yesterday.</span>
            </label>
        </div>

        <!-- Navigation Buttons -->
        <div class="px-6 py-4 bg-slate-50 border-t border-[#97CADB]/20 flex items-center justify-between">
            <button class="px-6 py-2.5 bg-white border-2 border-[#97CADB]/30 text-slate-700 font-semibold rounded-xl hover:border-slate-300 hover:bg-slate-50 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Sebelumnya
            </button>
            <button class="px-6 py-2.5 bg-[#018ABE] hover:bg-[#02457A] text-white font-semibold rounded-xl transition flex items-center gap-2 shadow-lg shadow-[#018ABE]/30">
                <span>Selanjutnya</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- CAT MASCOT                                             -->
    <!-- ===================================================== -->
    <div class="bg-gradient-to-br from-[#D6EBEE] to-[#97CADB]/30 rounded-2xl p-6 border border-[#97CADB]/40 flex items-center gap-4">
        <img src="{{ asset('images/cat-welcome.png') }}" alt="Cat" class="w-20 h-auto">
        <div>
            <p class="font-cute text-lg text-[#018ABE] leading-tight">Sedikit demi sedikit,</p>
            <p class="font-cute text-lg text-[#018ABE] leading-tight">lama-lama jadi bisa! ✨</p>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
// Timer countdown
let timeLeft = 42; // detik
const timerElement = document.getElementById('timer');

const timerInterval = setInterval(() => {
    timeLeft--;
    const minutes = Math.floor(timeLeft / 60);
    const seconds = timeLeft % 60;
    timerElement.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

    if (timeLeft <= 0) {
        clearInterval(timerInterval);
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: 'Waktu Telah Habis!',
                html: '<p class="text-sm text-slate-600">Waktu kuis telah berakhir.</p>',
                showConfirmButton: false,
                timer: 1800,
                customClass: {
                    popup: 'englify-swal'
                }
            });
        }
        // Auto submit logic here
    }
}, 1000);

// Auto save jawaban
document.querySelectorAll('input[name="jawaban"]').forEach(radio => {
    radio.addEventListener('change', function() {
        console.log('Jawaban disimpan:', this.value);
        // Auto save ke database via AJAX
    });
});
</script>
@endpush
