<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — Englify</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['Space Grotesk', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        navy: {
                            50: '#eef2f8',
                            100: '#d6e1f0',
                            200: '#9eb8d6',
                            500: '#3d5a80',
                            700: '#1e3a5f',
                            800: '#182B4B',
                            900: '#0f1c35',
                            950: '#070f1f',
                        },
                        sky: {
                            50: '#e8f4f8',
                            100: '#D6E8EE',
                            200: '#97CADB',
                            300: '#018ABE',
                            400: '#00a8e8',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-delayed': 'float 6s ease-in-out 2s infinite',
                        'float-slow': 'float 8s ease-in-out 1s infinite',
                        'blob': 'blob 7s infinite',
                        'spin-slow': 'spin 20s linear infinite',
                        'slide-up': 'slideUp 0.6s ease-out forwards',
                        'fade-in': 'fadeIn 0.8s ease-out forwards',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
                            '50%': { transform: 'translateY(-15px) rotate(2deg)' },
                        },
                        blob: {
                            '0%, 100%': { transform: 'translate(0, 0) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(30px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }

        /* Grid Pattern */
        .grid-pattern {
            background-image:
                linear-gradient(rgba(24, 43, 75, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(24, 43, 75, 0.04) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        /* Noise Texture */
        .noise-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.4'/%3E%3C/svg%3E");
            opacity: 0.03;
            pointer-events: none;
        }

        /* Glass Card */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        /* Input Focus Effect */
        .input-field {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .input-field:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px -10px rgba(24, 43, 75, 0.2);
        }

        /* Button Shine Effect */
        .btn-shine {
            position: relative;
            overflow: hidden;
        }
        .btn-shine::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        .btn-shine:hover::before {
            left: 100%;
        }

        /* Password Toggle */
        .password-toggle {
            cursor: pointer;
            transition: all 0.2s;
        }
        .password-toggle:hover {
            color: #182B4B;
        }

        /* Hide scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #64748b; }
    </style>
</head>
<body class="bg-white overflow-x-hidden">

    <div class="min-h-screen grid lg:grid-cols-2 relative">

        <!-- ============ LEFT SIDE: Branding ============ -->
        <div class="relative bg-gradient-to-br from-navy-800 via-navy-700 to-navy-900 text-white overflow-hidden hidden lg:flex flex-col justify-between p-12">
            <!-- Animated Blobs -->
            <div class="absolute top-10 left-10 w-72 h-72 bg-sky-300/20 rounded-full mix-blend-screen filter blur-3xl animate-blob"></div>
            <div class="absolute bottom-10 right-10 w-72 h-72 bg-sky-200/20 rounded-full mix-blend-screen filter blur-3xl animate-blob" style="animation-delay: 2s"></div>
            <div class="absolute top-1/2 left-1/2 w-96 h-96 bg-navy-500/20 rounded-full mix-blend-screen filter blur-3xl animate-blob" style="animation-delay: 4s"></div>

            <!-- Grid Pattern Overlay -->
            <div class="absolute inset-0 opacity-10" style="background-image: linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 40px 40px;"></div>

            <!-- Top: Logo -->
            <div class="relative z-10 animate-fade-in">
                <a href="/" class="inline-flex items-center gap-3 group">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-2xl group-hover:rotate-12 transition-transform duration-300">
                        <svg class="w-7 h-7 text-navy-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="font-display font-bold text-2xl">englify</span>
                </a>
            </div>

            <!-- Middle: Big Typography -->
            <div class="relative z-10 space-y-8">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur border border-white/20 rounded-full animate-fade-in">
                    <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                    <span class="text-xs font-bold uppercase tracking-wider">English Club WJLRC</span>
                </div>

                <h1 class="font-display font-bold text-6xl xl:text-7xl leading-[0.95] animate-slide-up">
                    Welcome<br>
                    <span class="italic text-sky-300">back</span>,<br>
                    learner.
                </h1>

                <p class="text-sky-100 text-lg max-w-md leading-relaxed animate-slide-up" style="animation-delay: 0.2s">
                    Lanjutkan perjalanan belajarmu. Setiap langkah kecil membawa kamu lebih dekat ke masa depan yang lebih cerah.
                </p>

                <!-- Floating Stats -->
                <div class="grid grid-cols-3 gap-4 max-w-md animate-slide-up" style="animation-delay: 0.4s">
                    <div class="bg-white/5 backdrop-blur border border-white/10 rounded-2xl p-4 hover:bg-white/10 transition group">
                        <div class="font-display font-bold text-2xl group-hover:text-sky-300 transition">100+</div>
                        <div class="text-xs text-sky-100/70">Members</div>
                    </div>
                    <div class="bg-white/5 backdrop-blur border border-white/10 rounded-2xl p-4 hover:bg-white/10 transition group">
                        <div class="font-display font-bold text-2xl group-hover:text-sky-300 transition">40+</div>
                        <div class="text-xs text-sky-100/70">Materials</div>
                    </div>
                    <div class="bg-white/5 backdrop-blur border border-white/10 rounded-2xl p-4 hover:bg-white/10 transition group">
                        <div class="font-display font-bold text-2xl group-hover:text-sky-300 transition">4</div>
                        <div class="text-xs text-sky-100/70">Divisions</div>
                    </div>
                </div>
            </div>

            <!-- Bottom: Floating Cards -->
            <div class="relative z-10 space-y-4">
                <!-- Floating Card 1 -->
                <div class="glass !bg-white/10 !border-white/20 rounded-2xl p-4 max-w-xs animate-float">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-sky-300 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <div class="text-xs font-bold">Quiz Completed!</div>
                            <div class="text-[10px] text-sky-100/70">Score: 90/100 • Speaking Bab 1</div>
                        </div>
                    </div>
                </div>

                <!-- Floating Card 2 -->
                <div class="glass !bg-white/10 !border-white/20 rounded-2xl p-4 max-w-xs animate-float-delayed ml-auto">
                    <div class="flex items-center gap-3">
                        <div class="flex -space-x-2">
                            <div class="w-8 h-8 rounded-full bg-sky-300 border-2 border-navy-800 flex items-center justify-center text-[10px] font-bold">NA</div>
                            <div class="w-8 h-8 rounded-full bg-white border-2 border-navy-800 flex items-center justify-center text-[10px] font-bold text-navy-800">RP</div>
                            <div class="w-8 h-8 rounded-full bg-sky-200 border-2 border-navy-800 flex items-center justify-center text-[10px] font-bold">+5</div>
                        </div>
                        <div>
                            <div class="text-xs font-bold">8 students online</div>
                            <div class="text-[10px] text-sky-100/70">Learning right now</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============ RIGHT SIDE: Login Form ============ -->
        <div class="relative flex items-center justify-center p-6 lg:p-12 bg-gradient-to-br from-sky-50 via-white to-sky-50 noise-bg">
            <!-- Grid Pattern -->
            <div class="absolute inset-0 grid-pattern"></div>

            <!-- Decorative Blobs -->
            <div class="absolute top-20 right-20 w-64 h-64 bg-sky-200/30 rounded-full blur-3xl animate-blob"></div>
            <div class="absolute bottom-20 left-20 w-64 h-64 bg-navy-100/30 rounded-full blur-3xl animate-blob" style="animation-delay: 2s"></div>

            <!-- Mobile Logo (only visible on small screens) -->
            <div class="absolute top-6 left-6 lg:hidden">
                <a href="/" class="inline-flex items-center gap-2">
                    <div class="w-10 h-10 bg-navy-800 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="font-display font-bold text-xl text-navy-900">englify</span>
                </a>
            </div>

            <!-- Back to Home (Desktop) -->
            <a href="/" class="absolute top-6 right-6 hidden lg:flex items-center gap-2 px-4 py-2 bg-white border border-navy-100 rounded-full text-sm font-medium text-navy-900 hover:border-navy-900 hover:shadow-lg transition group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to home
            </a>

            <!-- Login Card -->
            <div class="relative z-10 w-full max-w-md animate-slide-up">

                <!-- Header -->
                <div class="mb-8">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-navy-200 rounded-full mb-4 shadow-sm">
                        <span class="w-1.5 h-1.5 bg-sky-300 rounded-full"></span>
                        <span class="text-[10px] font-bold text-navy-900 uppercase tracking-wider">Sign in to your account</span>
                    </div>
                    <h2 class="font-display font-bold text-4xl lg:text-5xl text-navy-900 leading-tight mb-2">
                        Let's get you<br>
                        <span class="italic text-sky-300">back in.</span>
                    </h2>
                    <p class="text-slate-600 text-sm">Masuk untuk melanjutkan perjalanan belajarmu di Englify.</p>
                </div>

                <!-- Error Message -->
                @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl flex items-start gap-3 animate-slide-up">
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-red-900 mb-1">Oops, ada masalah!</p>
                        <ul class="text-xs text-red-700 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('login.proses') }}" class="space-y-5">
                    @csrf

                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label class="flex items-center justify-between">
                            <span class="text-xs font-bold text-navy-900 uppercase tracking-wider">Email Address</span>
                            <span class="text-[10px] text-slate-500">Required</span>
                        </label>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                            </div>
                            <input
                                type="email"
                                name="login"
                                value="{{ old('login') }}"
                                required
                                autofocus
                                placeholder="nama@englify.com"
                                class="input-field w-full pl-12 pr-4 py-4 bg-white border-2 border-navy-100 rounded-2xl text-sm font-medium text-navy-900 placeholder-slate-400 focus:outline-none focus:border-navy-800 focus:bg-white"
                            >
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label class="flex items-center justify-between">
                            <span class="text-xs font-bold text-navy-900 uppercase tracking-wider">Password</span>
                            <span class="text-[10px] text-slate-500">Required</span>
                        </label>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                required
                                placeholder="••••••••"
                                class="input-field w-full pl-12 pr-12 py-4 bg-white border-2 border-navy-100 rounded-2xl text-sm font-medium text-navy-900 placeholder-slate-400 focus:outline-none focus:border-navy-800 focus:bg-white"
                            >
                            <button
                                type="button"
                                onclick="togglePassword()"
                                class="password-toggle absolute right-4 top-1/2 -translate-y-1/2 text-slate-400"
                                id="toggleBtn"
                            >
                                <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <svg id="eyeOffIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" class="w-4 h-4 rounded border-navy-200 text-navy-800 focus:ring-navy-800 focus:ring-offset-0 cursor-pointer">
                            <span class="text-xs font-medium text-slate-600 group-hover:text-navy-900 transition">Ingat saya</span>
                        </label>
                        <a href="#" class="text-xs font-bold text-sky-300 hover:text-navy-800 transition">Lupa password?</a>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="btn-shine w-full py-4 bg-navy-800 text-white font-bold rounded-2xl hover:bg-navy-700 transition-all shadow-xl shadow-navy-800/20 hover:shadow-2xl hover:shadow-navy-800/30 hover:-translate-y-0.5 flex items-center justify-center gap-2 group"
                    >
                        <span>Masuk ke Englify</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </button>

                    <!-- Divider -->
                    <div class="relative py-4">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-navy-100"></div>
                        </div>
                        <div class="relative flex justify-center text-xs">
                            <span class="px-4 bg-gradient-to-br from-sky-50 via-white to-sky-50 text-slate-500 font-medium">Belum punya akun?</span>
                        </div>
                    </div>

                    <!-- Register Link -->
                    <a href="/" class="block w-full py-4 bg-white border-2 border-navy-900 text-navy-900 font-bold rounded-2xl hover:bg-navy-900 hover:text-white transition-all text-center shadow-[4px_4px_0_0_#182B4B] hover:shadow-[2px_2px_0_0_#182B4B] hover:translate-x-[2px] hover:translate-y-[2px]">
                        Daftar Sekarang →
                    </a>
                </form>

                <!-- Footer Note -->
                <div class="mt-8 text-center">
                    <p class="text-xs text-slate-500">
                        Dengan masuk, kamu menyetujui
                        <a href="#" class="font-bold text-navy-900 hover:text-sky-300 transition">Syarat & Ketentuan</a>
                        Englify.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- ============ JAVASCRIPT ============ -->
    <script>
        // Password Toggle
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeOffIcon = document.getElementById('eyeOffIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }

        // Input focus label effect
        document.querySelectorAll('.input-field').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('scale-[1.02]');
            });
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('scale-[1.02]');
            });
        });

        // Auto-hide error after 5 seconds
        const errorBox = document.querySelector('.bg-red-50');
        if (errorBox) {
            setTimeout(() => {
                errorBox.style.transition = 'all 0.5s ease';
                errorBox.style.opacity = '0';
                errorBox.style.transform = 'translateY(-10px)';
                setTimeout(() => errorBox.remove(), 500);
            }, 5000);
        }
    </script>
</body>
</html>w
