<script>
/**
 * Universal Password Eye Toggle for Englify
 * Menjamin semua input password di halaman apapun memiliki ikon mata untuk melihat/menyembunyikan password
 */
(function() {
    function createEyeToggle(input) {
        if (!input || input.dataset.eyeToggleAttached === 'true') return;
        
        // Cek apakah input sudah memiliki tombol toggle di dalam parent terdekat
        const parent = input.parentElement;
        if (parent && parent.querySelector('.password-toggle, .eye-toggle-btn, button[onclick*="togglePassword"], button[onclick*="togglePwd"]')) {
            input.dataset.eyeToggleAttached = 'true';
            return;
        }

        input.dataset.eyeToggleAttached = 'true';

        // Pastikan container relative
        if (parent && !parent.classList.contains('relative')) {
            parent.classList.add('relative');
        }

        // Tambahkan padding kanan agar teks tidak bertabrakan dengan ikon mata
        if (!input.classList.contains('pr-10') && !input.classList.contains('pr-11') && !input.classList.contains('pr-12')) {
            input.classList.add('pr-10');
        }

        // Buat tombol toggle
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'eye-toggle-btn absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition p-1 focus:outline-none z-10 cursor-pointer';
        btn.title = 'Lihat password';
        btn.setAttribute('aria-label', 'Lihat password');
        btn.innerHTML = `
            <svg class="w-4 h-4 eye-icon-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            <svg class="w-4 h-4 eye-icon-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
            </svg>
        `;

        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const isText = input.type === 'text';
            input.type = isText ? 'password' : 'text';
            
            const iconOpen = btn.querySelector('.eye-icon-open');
            const iconClosed = btn.querySelector('.eye-icon-closed');
            if (iconOpen && iconClosed) {
                iconOpen.classList.toggle('hidden', !isText);
                iconClosed.classList.toggle('hidden', isText);
            }
            btn.title = isText ? 'Lihat password' : 'Sembunyikan password';
            btn.setAttribute('aria-label', isText ? 'Lihat password' : 'Sembunyikan password');
            input.focus();
        });

        if (parent) {
            parent.appendChild(btn);
        }
    }

    function initAllPasswordToggles() {
        document.querySelectorAll('input[type="password"], input[data-has-eye-toggle="true"]').forEach(createEyeToggle);
    }

    // Jalankan saat DOM siap
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAllPasswordToggles);
    } else {
        initAllPasswordToggles();
    }

    // Observer untuk modal / form dinamis yang baru dimuat
    if (window.MutationObserver) {
        const observer = new MutationObserver(function() {
            initAllPasswordToggles();
        });
        document.addEventListener('DOMContentLoaded', function() {
            observer.observe(document.body, { childList: true, subtree: true });
        });
        if (document.body) {
            observer.observe(document.body, { childList: true, subtree: true });
        }
    }
})();
</script>
