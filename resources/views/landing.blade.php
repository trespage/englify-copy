<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Englify — Learn English, Grow Your Future</title>
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
                        'marquee': 'marquee 30s linear infinite',
                        'spin-slow': 'spin 20s linear infinite',
                        'blob': 'blob 7s infinite',
                        'slide-up': 'slideUp 0.8s ease-out forwards',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
                            '50%': { transform: 'translateY(-20px) rotate(2deg)' },
                        },
                        marquee: {
                            '0%': { transform: 'translateX(0%)' },
                            '100%': { transform: 'translateX(-50%)' },
                        },
                        blob: {
                            '0%, 100%': { transform: 'translate(0, 0) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(40px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }

        /* Custom Cursor Effect */
        .cursor-dot {
            width: 8px; height: 8px;
            background: #182B4B;
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            transition: transform 0.1s;
        }

        /* Noise Texture Overlay */
        .noise-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.4'/%3E%3C/svg%3E");
            opacity: 0.03;
            pointer-events: none;
        }

        /* Bento Card Hover */
        .bento-card {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .bento-card:hover {
            transform: translateY(-8px) rotate(-1deg);
            box-shadow: 0 30px 60px -15px rgba(24, 43, 75, 0.3);
        }

        /* Marquee */
        .marquee-track {
            display: flex;
            width: max-content;
        }

        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, #182B4B 0%, #018ABE 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Diagonal Section */
        .diagonal-section {
            clip-path: polygon(0 5%, 100% 0, 100% 95%, 0 100%);
        }

        /* Grid Pattern */
        .grid-pattern {
            background-image:
                linear-gradient(rgba(24, 43, 75, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(24, 43, 75, 0.05) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        /* Scroll Reveal */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Ticker Tape */
        .ticker-tape {
            overflow: hidden;
            white-space: nowrap;
        }

        /* Glass Card */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Hide scrollbar for marquee */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-white text-navy-900 overflow-x-hidden">

    <!-- ============ NAVBAR (Floating, Glass) ============ -->
    <nav class="fixed top-6 left-1/2 -translate-x-1/2 w-[95%] max-w-6xl z-50">
        <div class="glass rounded-full px-6 py-3 shadow-xl shadow-navy-900/5 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-9 h-9 bg-navy-800 rounded-full flex items-center justify-center relative">
                    <div class="absolute inset-0 bg-navy-800 rounded-full animate-ping opacity-20"></div>
                    <svg class="w-5 h-5 text-white relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="font-display font-bold text-lg text-navy-900">englify</span>
                <span class="hidden sm:inline text-[10px] font-bold text-sky-300 bg-sky-50 px-2 py-0.5 rounded-full ml-1">WJLRC</span>
            </div>

            <div class="hidden md:flex items-center gap-1">
                <a href="#beranda" class="px-4 py-2 text-sm font-medium text-navy-900 hover:bg-navy-50 rounded-full transition">Beranda</a>
                <a href="#fitur" class="px-4 py-2 text-sm font-medium text-slate-600 hover:bg-navy-50 rounded-full transition">Fitur</a>
                <a href="#tentang" class="px-4 py-2 text-sm font-medium text-slate-600 hover:bg-navy-50 rounded-full transition">Tentang</a>
                <a href="#faq" class="px-4 py-2 text-sm font-medium text-slate-600 hover:bg-navy-50 rounded-full transition">FAQ</a>
            </div>

            <div class="flex items-center gap-2">
                <a href="/login" class="hidden sm:inline-flex px-4 py-2 text-sm font-semibold text-navy-900 hover:bg-navy-50 rounded-full transition">Masuk</a>
                <a href="/login" class="px-5 py-2 text-sm font-bold text-white bg-navy-800 rounded-full hover:bg-navy-700 transition shadow-lg shadow-navy-800/20">Mulai →</a>
            </div>
        </div>
    </nav>

    <!-- ============ HERO SECTION (Asymmetric + Big Type) ============ -->
    <section id="beranda" class="relative min-h-screen pt-32 pb-20 overflow-hidden noise-bg">
        <!-- Animated Blobs -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-sky-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-navy-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob" style="animation-delay: 2s"></div>
        <div class="absolute bottom-20 left-1/2 w-72 h-72 bg-sky-200 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob" style="animation-delay: 4s"></div>

        <!-- Grid Pattern Background -->
        <div class="absolute inset-0 grid-pattern opacity-50"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-12 gap-8 items-center">

                <!-- Left: Typography -->
                <div class="lg:col-span-7 space-y-8">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white border-2 border-navy-900 rounded-full shadow-[4px_4px_0_0_#182B4B] hover:shadow-[2px_2px_0_0_#182B4B] hover:translate-x-[2px] hover:translate-y-[2px] transition-all cursor-pointer group">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        <span class="text-xs font-bold text-navy-900">English Club WJLRC • 2025</span>
                        <svg class="w-4 h-4 text-navy-900 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </div>

                    <h1 class="font-display font-bold text-6xl lg:text-8xl leading-[0.9] tracking-tight">
                        Learn <span class="italic text-sky-300">English</span>,<br>
                        <span class="relative inline-block">
                            Grow Your
                            <svg class="absolute -bottom-2 left-0 w-full h-4 text-sky-300" viewBox="0 0 200 8" preserveAspectRatio="none">
                                <path d="M0,4 Q50,0 100,4 T200,4" stroke="currentColor" stroke-width="3" fill="none"/>
                            </svg>
                        </span>
                        <br><span class="gradient-text">Future.</span>
                    </h1>

                    <p class="text-lg text-slate-600 max-w-lg leading-relaxed">
                        Platform pembelajaran bahasa Inggris yang <span class="font-bold text-navy-900">terstruktur</span>, <span class="font-bold text-navy-900">interaktif</span>, dan <span class="font-bold text-navy-900">menyenangkan</span> untuk anggota English Club WJLRC.
                    </p>

                    <div class="flex flex-wrap gap-4 items-center">
                        <a href="/login" class="group relative px-8 py-4 bg-navy-800 text-white font-bold rounded-full overflow-hidden shadow-2xl shadow-navy-800/30 hover:shadow-navy-800/50 transition-all">
                            <span class="relative z-10 flex items-center gap-2">
                                Mulai Belajar
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </span>
                            <div class="absolute inset-0 bg-sky-300 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                        </a>

                        <a href="#fitur" class="group flex items-center gap-3 px-6 py-4 font-semibold text-navy-900 hover:text-sky-300 transition">
                            <div class="w-12 h-12 rounded-full border-2 border-navy-900 flex items-center justify-center group-hover:border-sky-300 group-hover:rotate-90 transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                            </div>
                            Tonton Video
                        </a>
                    </div>

                    <!-- Mini Stats -->
                    <div class="flex flex-wrap gap-8 pt-8 border-t border-navy-900/10">
                        <div>
                            <div class="font-display font-bold text-3xl text-navy-900">100+</div>
                            <div class="text-xs text-slate-500 uppercase tracking-wider">Member Aktif</div>
                        </div>
                        <div>
                            <div class="font-display font-bold text-3xl text-navy-900">40+</div>
                            <div class="text-xs text-slate-500 uppercase tracking-wider">Materi</div>
                        </div>
                        <div>
                            <div class="font-display font-bold text-3xl text-navy-900">4</div>
                            <div class="text-xs text-slate-500 uppercase tracking-wider">Divisi</div>
                        </div>
                    </div>
                </div>

                <!-- Right: Floating Cards Composition -->
                <div class="lg:col-span-5 relative h-[500px] hidden lg:block">
                    <!-- Main Card -->
                    <div class="absolute top-10 right-0 w-72 bg-white rounded-3xl p-6 shadow-2xl shadow-navy-900/20 border border-navy-100 animate-float">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-sky-200 to-sky-300 rounded-2xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-navy-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <div>
                                <div class="font-display font-bold text-navy-900">Speaking</div>
                                <div class="text-xs text-slate-500">Bab 1 • 12 Materi</div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="h-2 bg-navy-50 rounded-full overflow-hidden">
                                <div class="h-full w-3/4 bg-gradient-to-r from-navy-800 to-sky-300 rounded-full"></div>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-slate-500">Progress</span>
                                <span class="font-bold text-navy-900">75%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Badge 1 -->
                    <div class="absolute top-0 left-0 bg-navy-800 text-white rounded-2xl p-4 shadow-xl animate-float-delayed">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            </div>
                            <div>
                                <div class="text-xs font-bold">Quiz Selesai!</div>
                                <div class="text-[10px] text-sky-200">Skor: 90/100</div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Badge 2 -->
                    <div class="absolute bottom-20 right-10 bg-white rounded-2xl p-4 shadow-xl border border-navy-100 animate-float">
                        <div class="flex items-center gap-3">
                            <div class="flex -space-x-2">
                                <div class="w-8 h-8 rounded-full bg-sky-200 border-2 border-white flex items-center justify-center text-[10px] font-bold text-navy-900">NA</div>
                                <div class="w-8 h-8 rounded-full bg-navy-200 border-2 border-white flex items-center justify-center text-[10px] font-bold text-navy-900">RP</div>
                                <div class="w-8 h-8 rounded-full bg-sky-300 border-2 border-white flex items-center justify-center text-[10px] font-bold text-white">+5</div>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-navy-900">Online Now</div>
                                <div class="text-[10px] text-slate-500">8 siswa belajar</div>
                            </div>
                        </div>
                    </div>

                    <!-- Rotating Badge -->
                    <div class="absolute bottom-0 left-10">
                        <div class="relative w-24 h-24 animate-spin-slow">
                            <svg viewBox="0 0 100 100" class="w-full h-full">
                                <defs>
                                    <path id="circle" d="M 50,50 m -37,0 a 37,37 0 1,1 74,0 a 37,37 0 1,1 -74,0" />
                                </defs>
                                <text class="font-display font-bold text-[11px] fill-navy-800">
                                    <textPath href="#circle">ENGLISH • CLUB • WJLRC • 2025 • </textPath>
                                </text>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-12 h-12 bg-sky-300 rounded-full flex items-center justify-center text-navy-900 font-bold text-lg">🐱</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-navy-900/40">
            <span class="text-[10px] font-bold uppercase tracking-widest">Scroll</span>
            <div class="w-6 h-10 border-2 border-navy-900/30 rounded-full flex justify-center pt-2">
                <div class="w-1 h-2 bg-navy-900 rounded-full animate-bounce"></div>
            </div>
        </div>
    </section>

    <!-- ============ TICKER TAPE ============ -->
    <div class="bg-navy-800 text-white py-4 overflow-hidden border-y-4 border-navy-900">
        <div class="ticker-tape">
            <div class="marquee-track animate-marquee">
                <div class="flex items-center gap-8 px-4 font-display font-bold text-lg">
                    <span> SPEAKING</span>
                    <span class="text-sky-300"> WRITING</span>
                    <span>✦ LISTENING</span>
                    <span class="text-sky-300">✦ READING</span>
                    <span>✦ GRAMMAR</span>
                    <span class="text-sky-300"> VOCABULARY</span>
                    <span>✦ PRONUNCIATION</span>
                    <span class="text-sky-300">✦ CONVERSATION</span>
                </div>
                <div class="flex items-center gap-8 px-4 font-display font-bold text-lg">
                    <span>✦ SPEAKING</span>
                    <span class="text-sky-300">✦ WRITING</span>
                    <span>✦ LISTENING</span>
                    <span class="text-sky-300">✦ READING</span>
                    <span>✦ GRAMMAR</span>
                    <span class="text-sky-300">✦ VOCABULARY</span>
                    <span>✦ PRONUNCIATION</span>
                    <span class="text-sky-300">✦ CONVERSATION</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ============ BENTO GRID FEATURES ============ -->
    <section id="fitur" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="mb-16 reveal">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-sky-50 border border-sky-200 rounded-full mb-4">
                    <span class="w-2 h-2 bg-sky-300 rounded-full"></span>
                    <span class="text-xs font-bold text-navy-900 uppercase tracking-wider">Kenapa Englify?</span>
                </div>
                <h2 class="font-display font-bold text-5xl lg:text-6xl leading-tight text-navy-900 max-w-3xl">
                    Bukan cuma belajar.<br>
                    <span class="italic text-sky-300">Tapi berkembang.</span>
                </h2>
            </div>

            <!-- Bento Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 auto-rows-[200px]">

                <!-- Card 1: Large -->
                <div class="bento-card md:col-span-2 md:row-span-2 bg-gradient-to-br from-navy-800 to-navy-900 rounded-3xl p-8 text-white relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-sky-300/20 rounded-full blur-3xl group-hover:bg-sky-300/30 transition"></div>
                    <div class="relative z-10 h-full flex flex-col justify-between">
                        <div class="w-14 h-14 bg-white/10 backdrop-blur rounded-2xl flex items-center justify-center border border-white/20">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-display font-bold text-3xl mb-2">Materi Terstruktur</h3>
                            <p class="text-sky-100 text-sm leading-relaxed">Materi dikelompokkan berdasarkan 4 divisi: Speaking, Writing, Listening, dan Reading. Belajar jadi lebih terarah.</p>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bento-card bg-sky-50 rounded-3xl p-6 relative overflow-hidden group">
                    <div class="absolute -bottom-8 -right-8 w-32 h-32 bg-sky-200 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="text-5xl mb-4">🎯</div>
                        <h3 class="font-display font-bold text-xl text-navy-900 mb-1">Belajar Terarah</h3>
                        <p class="text-xs text-slate-600">Fokus pada level kemampuanmu</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bento-card bg-navy-50 rounded-3xl p-6 relative overflow-hidden group">
                    <div class="absolute top-4 right-4 font-display font-bold text-6xl text-navy-900/10 group-hover:text-navy-900/20 transition">01</div>
                    <div class="relative z-10 h-full flex flex-col justify-between">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-navy-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-display font-bold text-lg text-navy-900">Quiz Interaktif</h3>
                            <p class="text-xs text-slate-600 mt-1">Uji pemahaman setiap bab</p>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="bento-card md:col-span-2 bg-gradient-to-br from-sky-100 to-white rounded-3xl p-6 relative overflow-hidden group border border-sky-200">
                    <div class="grid grid-cols-2 gap-4 h-full items-center">
                        <div>
                            <div class="text-4xl mb-3">📊</div>
                            <h3 class="font-display font-bold text-xl text-navy-900 mb-1">Progress Tracking</h3>
                            <p class="text-xs text-slate-600">Pantau perkembangan belajarmu secara real-time</p>
                        </div>
                        <div class="bg-white rounded-2xl p-4 shadow-lg border border-sky-100">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-bold text-navy-900">Minggu Ini</span>
                                <span class="text-xs font-bold text-emerald-600">+23%</span>
                            </div>
                            <div class="flex items-end gap-1 h-16">
                                <div class="flex-1 bg-sky-100 rounded-t" style="height: 40%"></div>
                                <div class="flex-1 bg-sky-200 rounded-t" style="height: 60%"></div>
                                <div class="flex-1 bg-sky-300 rounded-t" style="height: 45%"></div>
                                <div class="flex-1 bg-navy-800 rounded-t" style="height: 85%"></div>
                                <div class="flex-1 bg-sky-300 rounded-t" style="height: 70%"></div>
                                <div class="flex-1 bg-sky-200 rounded-t" style="height: 90%"></div>
                                <div class="flex-1 bg-sky-100 rounded-t" style="height: 55%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="bento-card bg-white border-2 border-navy-900 rounded-3xl p-6 relative overflow-hidden group hover:bg-navy-900 hover:text-white transition-colors">
                    <div class="h-full flex flex-col justify-between">
                        <div class="w-12 h-12 bg-navy-50 group-hover:bg-white/10 rounded-xl flex items-center justify-center transition">
                            <svg class="w-6 h-6 text-navy-900 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-display font-bold text-lg">Gratis untuk Member</h3>
                            <p class="text-xs text-slate-600 group-hover:text-slate-300 transition">Semua fitur tanpa biaya tambahan</p>
                        </div>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="bento-card bg-gradient-to-br from-navy-100 to-sky-50 rounded-3xl p-6 relative overflow-hidden group">
                    <div class="h-full flex flex-col justify-between">
                        <div class="flex items-center gap-2">
                            <div class="flex -space-x-2">
                                <div class="w-8 h-8 rounded-full bg-sky-300 border-2 border-white"></div>
                                <div class="w-8 h-8 rounded-full bg-navy-800 border-2 border-white"></div>
                                <div class="w-8 h-8 rounded-full bg-sky-200 border-2 border-white"></div>
                            </div>
                            <span class="text-xs font-bold text-navy-900">100+ users</span>
                        </div>
                        <div>
                            <h3 class="font-display font-bold text-lg text-navy-900">Komunitas Aktif</h3>
                            <p class="text-xs text-slate-600 mt-1">Belajar bareng teman-teman</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ DIVISI SHOWCASE (Horizontal Scroll) ============ -->
    <section class="py-24 bg-navy-50 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 mb-12 reveal">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-navy-200 rounded-full mb-4">
                        <span class="text-xs font-bold text-navy-900 uppercase tracking-wider">4 Divisi Pembelajaran</span>
                    </div>
                    <h2 class="font-display font-bold text-5xl lg:text-6xl text-navy-900 leading-tight">
                        Pilih jalur<br>belajarmu.
                    </h2>
                </div>
                <p class="text-slate-600 max-w-md">Setiap divisi punya materi, latihan, dan quiz yang disesuaikan dengan skill yang ingin kamu kuasai.</p>
            </div>
        </div>

        <!-- Horizontal Scroll Cards -->
        <div class="no-scrollbar overflow-x-auto pb-8">
            <div class="flex gap-6 px-6 lg:px-8 min-w-max">

                <!-- Divisi 1 -->
                <div class="w-80 bg-white rounded-3xl p-8 border border-navy-100 hover:border-navy-900 transition-all group hover:-translate-y-2 duration-300">
                    <div class="flex items-center justify-between mb-8">
                        <div class="w-16 h-16 bg-gradient-to-br from-sky-200 to-sky-300 rounded-2xl flex items-center justify-center text-3xl group-hover:rotate-12 transition-transform">🎤</div>
                        <span class="font-display font-bold text-5xl text-navy-100 group-hover:text-navy-200 transition">01</span>
                    </div>
                    <h3 class="font-display font-bold text-2xl text-navy-900 mb-2">Speaking</h3>
                    <p class="text-sm text-slate-600 mb-6">Latih kemampuan berbicaramu dengan materi pronunciation dan conversation.</p>
                    <div class="flex items-center justify-between pt-4 border-t border-navy-50">
                        <span class="text-xs font-bold text-navy-900">12 Materi</span>
                        <div class="w-10 h-10 rounded-full bg-navy-50 group-hover:bg-navy-900 flex items-center justify-center transition">
                            <svg class="w-4 h-4 text-navy-900 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Divisi 2 -->
                <div class="w-80 bg-navy-800 rounded-3xl p-8 text-white hover:-translate-y-2 transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-8">
                        <div class="w-16 h-16 bg-white/10 backdrop-blur rounded-2xl flex items-center justify-center text-3xl group-hover:rotate-12 transition-transform border border-white/20">✍️</div>
                        <span class="font-display font-bold text-5xl text-white/10 group-hover:text-white/20 transition">02</span>
                    </div>
                    <h3 class="font-display font-bold text-2xl mb-2">Writing</h3>
                    <p class="text-sm text-sky-100 mb-6">Tingkatkan kemampuan menulis dari paragraph hingga essay.</p>
                    <div class="flex items-center justify-between pt-4 border-t border-white/10">
                        <span class="text-xs font-bold">10 Materi</span>
                        <div class="w-10 h-10 rounded-full bg-white/10 group-hover:bg-white group-hover:text-navy-900 flex items-center justify-center transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Divisi 3 -->
                <div class="w-80 bg-white rounded-3xl p-8 border border-navy-100 hover:border-navy-900 transition-all group hover:-translate-y-2 duration-300">
                    <div class="flex items-center justify-between mb-8">
                        <div class="w-16 h-16 bg-gradient-to-br from-navy-100 to-navy-200 rounded-2xl flex items-center justify-center text-3xl group-hover:rotate-12 transition-transform">🎧</div>
                        <span class="font-display font-bold text-5xl text-navy-100 group-hover:text-navy-200 transition">03</span>
                    </div>
                    <h3 class="font-display font-bold text-2xl text-navy-900 mb-2">Listening</h3>
                    <p class="text-sm text-slate-600 mb-6">Asah pendengaran dengan audio native speaker dan transcript.</p>
                    <div class="flex items-center justify-between pt-4 border-t border-navy-50">
                        <span class="text-xs font-bold text-navy-900">8 Materi</span>
                        <div class="w-10 h-10 rounded-full bg-navy-50 group-hover:bg-navy-900 flex items-center justify-center transition">
                            <svg class="w-4 h-4 text-navy-900 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Divisi 4 -->
                <div class="w-80 bg-gradient-to-br from-sky-200 to-sky-100 rounded-3xl p-8 hover:-translate-y-2 transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-8">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-3xl group-hover:rotate-12 transition-transform shadow-lg"></div>
                        <span class="font-display font-bold text-5xl text-navy-900/10 group-hover:text-navy-900/20 transition">04</span>
                    </div>
                    <h3 class="font-display font-bold text-2xl text-navy-900 mb-2">Reading</h3>
                    <p class="text-sm text-navy-700 mb-6">Baca teks berbagai genre dan tingkatkan comprehension skill.</p>
                    <div class="flex items-center justify-between pt-4 border-t border-navy-900/10">
                        <span class="text-xs font-bold text-navy-900">10 Materi</span>
                        <div class="w-10 h-10 rounded-full bg-white group-hover:bg-navy-900 flex items-center justify-center transition shadow-lg">
                            <svg class="w-4 h-4 text-navy-900 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ============ TESTIMONIALS (Marquee) ============ -->
    <section class="py-24 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 mb-12 reveal">
            <div class="text-center">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-sky-50 border border-sky-200 rounded-full mb-4">
                    <span class="text-xs font-bold text-navy-900 uppercase tracking-wider">Apa Kata Mereka</span>
                </div>
                <h2 class="font-display font-bold text-5xl lg:text-6xl text-navy-900 leading-tight">
                    Loved by <span class="italic text-sky-300">100+ students</span>
                </h2>
            </div>
        </div>

        <!-- Marquee Row 1 -->
        <div class="relative mb-6">
            <div class="absolute left-0 top-0 bottom-0 w-32 bg-gradient-to-r from-white to-transparent z-10"></div>
            <div class="absolute right-0 top-0 bottom-0 w-32 bg-gradient-to-l from-white to-transparent z-10"></div>
            <div class="ticker-tape">
                <div class="marquee-track animate-marquee">
                    <!-- Testimoni Cards (duplikat untuk seamless loop) -->
                    <div class="flex gap-6 px-3">
                        <div class="w-80 bg-navy-50 rounded-3xl p-6 border border-navy-100 flex-shrink-0">
                            <div class="flex items-center gap-1 mb-3 text-amber-400">★★★★★</div>
                            <p class="text-sm text-navy-900 mb-4 leading-relaxed">"Englify sangat membantu aku dalam belajar bahasa Inggris. Materinya lebih mudah dipahami karena sudah dikelompokkan berdasarkan divisi."</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-sky-200 to-sky-300 flex items-center justify-center text-navy-900 font-bold text-sm">NA</div>
                                <div>
                                    <div class="font-bold text-sm text-navy-900">Nur Aprilia</div>
                                    <div class="text-xs text-slate-500">Siswa English Club</div>
                                </div>
                            </div>
                        </div>

                        <div class="w-80 bg-sky-50 rounded-3xl p-6 border border-sky-100 flex-shrink-0">
                            <div class="flex items-center gap-1 mb-3 text-amber-400">★★★★★</div>
                            <p class="text-sm text-navy-900 mb-4 leading-relaxed">"Platform yang sangat membantu untuk meningkatkan kemampuan bahasa Inggris. Fitur-fiturnya lengkap dan mudah digunakan."</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-navy-200 to-navy-300 flex items-center justify-center text-navy-900 font-bold text-sm">RP</div>
                                <div>
                                    <div class="font-bold text-sm text-navy-900">Ricky Pratama</div>
                                    <div class="text-xs text-slate-500">Siswa English Club</div>
                                </div>
                            </div>
                        </div>

                        <div class="w-80 bg-navy-50 rounded-3xl p-6 border border-navy-100 flex-shrink-0">
                            <div class="flex items-center gap-1 mb-3 text-amber-400">★★★★★</div>
                            <p class="text-sm text-navy-900 mb-4 leading-relaxed">"Saya jadi lebih percaya diri dalam menggunakan bahasa Inggris, terutama untuk speaking. Terima kasih Englify!"</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-sky-300 to-sky-400 flex items-center justify-center text-white font-bold text-sm">SR</div>
                                <div>
                                    <div class="font-bold text-sm text-navy-900">Siti Rahma</div>
                                    <div class="text-xs text-slate-500">Siswa English Club</div>
                                </div>
                            </div>
                        </div>

                        <div class="w-80 bg-sky-50 rounded-3xl p-6 border border-sky-100 flex-shrink-0">
                            <div class="flex items-center gap-1 mb-3 text-amber-400">★★★★★</div>
                            <p class="text-sm text-navy-900 mb-4 leading-relaxed">"Quiz-quiznya seru dan menantang. Bikin belajar jadi nggak bosen sama sekali!"</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-navy-800 to-navy-900 flex items-center justify-center text-white font-bold text-sm">AF</div>
                                <div>
                                    <div class="font-bold text-sm text-navy-900">Andi Firmansyah</div>
                                    <div class="text-xs text-slate-500">Siswa English Club</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Duplicate for seamless loop -->
                    <div class="flex gap-6 px-3">
                        <div class="w-80 bg-navy-50 rounded-3xl p-6 border border-navy-100 flex-shrink-0">
                            <div class="flex items-center gap-1 mb-3 text-amber-400">★★★★★</div>
                            <p class="text-sm text-navy-900 mb-4 leading-relaxed">"Englify sangat membantu aku dalam belajar bahasa Inggris. Materinya lebih mudah dipahami karena sudah dikelompokkan berdasarkan divisi."</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-sky-200 to-sky-300 flex items-center justify-center text-navy-900 font-bold text-sm">NA</div>
                                <div>
                                    <div class="font-bold text-sm text-navy-900">Nur Aprilia</div>
                                    <div class="text-xs text-slate-500">Siswa English Club</div>
                                </div>
                            </div>
                        </div>

                        <div class="w-80 bg-sky-50 rounded-3xl p-6 border border-sky-100 flex-shrink-0">
                            <div class="flex items-center gap-1 mb-3 text-amber-400">★★★★★</div>
                            <p class="text-sm text-navy-900 mb-4 leading-relaxed">"Platform yang sangat membantu untuk meningkatkan kemampuan bahasa Inggris. Fitur-fiturnya lengkap dan mudah digunakan."</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-navy-200 to-navy-300 flex items-center justify-center text-navy-900 font-bold text-sm">RP</div>
                                <div>
                                    <div class="font-bold text-sm text-navy-900">Ricky Pratama</div>
                                    <div class="text-xs text-slate-500">Siswa English Club</div>
                                </div>
                            </div>
                        </div>

                        <div class="w-80 bg-navy-50 rounded-3xl p-6 border border-navy-100 flex-shrink-0">
                            <div class="flex items-center gap-1 mb-3 text-amber-400">★★★★★</div>
                            <p class="text-sm text-navy-900 mb-4 leading-relaxed">"Saya jadi lebih percaya diri dalam menggunakan bahasa Inggris, terutama untuk speaking. Terima kasih Englify!"</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-sky-300 to-sky-400 flex items-center justify-center text-white font-bold text-sm">SR</div>
                                <div>
                                    <div class="font-bold text-sm text-navy-900">Siti Rahma</div>
                                    <div class="text-xs text-slate-500">Siswa English Club</div>
                                </div>
                            </div>
                        </div>

                        <div class="w-80 bg-sky-50 rounded-3xl p-6 border border-sky-100 flex-shrink-0">
                            <div class="flex items-center gap-1 mb-3 text-amber-400">★★★★★</div>
                            <p class="text-sm text-navy-900 mb-4 leading-relaxed">"Quiz-quiznya seru dan menantang. Bikin belajar jadi nggak bosen sama sekali!"</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-navy-800 to-navy-900 flex items-center justify-center text-white font-bold text-sm">AF</div>
                                <div>
                                    <div class="font-bold text-sm text-navy-900">Andi Firmansyah</div>
                                    <div class="text-xs text-slate-500">Siswa English Club</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Marquee Row 2 (Reverse) -->
        <div class="relative">
            <div class="absolute left-0 top-0 bottom-0 w-32 bg-gradient-to-r from-white to-transparent z-10"></div>
            <div class="absolute right-0 top-0 bottom-0 w-32 bg-gradient-to-l from-white to-transparent z-10"></div>
            <div class="ticker-tape">
                <div class="marquee-track" style="animation: marquee 35s linear infinite reverse;">
                    <div class="flex gap-6 px-3">
                        <div class="w-80 bg-white rounded-3xl p-6 border-2 border-navy-900 flex-shrink-0 shadow-[6px_6px_0_0_#182B4B]">
                            <div class="flex items-center gap-1 mb-3 text-amber-400">★★★★★</div>
                            <p class="text-sm text-navy-900 mb-4 leading-relaxed">"Materinya lengkap dan up-to-date. Recommended banget buat yang mau improve English skill!"</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-sky-200 to-navy-200 flex items-center justify-center text-navy-900 font-bold text-sm">DF</div>
                                <div>
                                    <div class="font-bold text-sm text-navy-900">Dewi Fitriani</div>
                                    <div class="text-xs text-slate-500">Siswa English Club</div>
                                </div>
                            </div>
                        </div>

                        <div class="w-80 bg-white rounded-3xl p-6 border-2 border-navy-900 flex-shrink-0 shadow-[6px_6px_0_0_#182B4B]">
                            <div class="flex items-center gap-1 mb-3 text-amber-400">★★★★★</div>
                            <p class="text-sm text-navy-900 mb-4 leading-relaxed">"Progress tracking-nya bikin aku termotivasi buat terus belajar setiap hari!"</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-navy-300 to-sky-300 flex items-center justify-center text-white font-bold text-sm">BH</div>
                                <div>
                                    <div class="font-bold text-sm text-navy-900">Budi Hartono</div>
                                    <div class="text-xs text-slate-500">Siswa English Club</div>
                                </div>
                            </div>
                        </div>

                        <div class="w-80 bg-white rounded-3xl p-6 border-2 border-navy-900 flex-shrink-0 shadow-[6px_6px_0_0_#182B4B]">
                            <div class="flex items-center gap-1 mb-3 text-amber-400">★★★★★</div>
                            <p class="text-sm text-navy-900 mb-4 leading-relaxed">"UI-nya clean dan mudah dipakai. Nggak ribet buat navigate antar materi."</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-sky-300 to-navy-800 flex items-center justify-center text-white font-bold text-sm">LM</div>
                                <div>
                                    <div class="font-bold text-sm text-navy-900">Lina Marlina</div>
                                    <div class="text-xs text-slate-500">Siswa English Club</div>
                                </div>
                            </div>
                        </div>

                        <div class="w-80 bg-white rounded-3xl p-6 border-2 border-navy-900 flex-shrink-0 shadow-[6px_6px_0_0_#182B4B]">
                            <div class="flex items-center gap-1 mb-3 text-amber-400">★★★★★</div>
                            <p class="text-sm text-navy-900 mb-4 leading-relaxed">"Referensi pembelajarannya lengkap banget. Jadi gampang buat deep dive ke topik tertentu."</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-navy-200 to-sky-200 flex items-center justify-center text-navy-900 font-bold text-sm">RS</div>
                                <div>
                                    <div class="font-bold text-sm text-navy-900">Rudi Santoso</div>
                                    <div class="text-xs text-slate-500">Siswa English Club</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-6 px-3">
                        <div class="w-80 bg-white rounded-3xl p-6 border-2 border-navy-900 flex-shrink-0 shadow-[6px_6px_0_0_#182B4B]">
                            <div class="flex items-center gap-1 mb-3 text-amber-400">★★★★★</div>
                            <p class="text-sm text-navy-900 mb-4 leading-relaxed">"Materinya lengkap dan up-to-date. Recommended banget buat yang mau improve English skill!"</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-sky-200 to-navy-200 flex items-center justify-center text-navy-900 font-bold text-sm">DF</div>
                                <div>
                                    <div class="font-bold text-sm text-navy-900">Dewi Fitriani</div>
                                    <div class="text-xs text-slate-500">Siswa English Club</div>
                                </div>
                            </div>
                        </div>

                        <div class="w-80 bg-white rounded-3xl p-6 border-2 border-navy-900 flex-shrink-0 shadow-[6px_6px_0_0_#182B4B]">
                            <div class="flex items-center gap-1 mb-3 text-amber-400">★★★★★</div>
                            <p class="text-sm text-navy-900 mb-4 leading-relaxed">"Progress tracking-nya bikin aku termotivasi buat terus belajar setiap hari!"</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-navy-300 to-sky-300 flex items-center justify-center text-white font-bold text-sm">BH</div>
                                <div>
                                    <div class="font-bold text-sm text-navy-900">Budi Hartono</div>
                                    <div class="text-xs text-slate-500">Siswa English Club</div>
                                </div>
                            </div>
                        </div>

                        <div class="w-80 bg-white rounded-3xl p-6 border-2 border-navy-900 flex-shrink-0 shadow-[6px_6px_0_0_#182B4B]">
                            <div class="flex items-center gap-1 mb-3 text-amber-400">★★★★★</div>
                            <p class="text-sm text-navy-900 mb-4 leading-relaxed">"UI-nya clean dan mudah dipakai. Nggak ribet buat navigate antar materi."</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-sky-300 to-navy-800 flex items-center justify-center text-white font-bold text-sm">LM</div>
                                <div>
                                    <div class="font-bold text-sm text-navy-900">Lina Marlina</div>
                                    <div class="text-xs text-slate-500">Siswa English Club</div>
                                </div>
                            </div>
                        </div>

                        <div class="w-80 bg-white rounded-3xl p-6 border-2 border-navy-900 flex-shrink-0 shadow-[6px_6px_0_0_#182B4B]">
                            <div class="flex items-center gap-1 mb-3 text-amber-400">★★★★★</div>
                            <p class="text-sm text-navy-900 mb-4 leading-relaxed">"Referensi pembelajarannya lengkap banget. Jadi gampang buat deep dive ke topik tertentu."</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-navy-200 to-sky-200 flex items-center justify-center text-navy-900 font-bold text-sm">RS</div>
                                <div>
                                    <div class="font-bold text-sm text-navy-900">Rudi Santoso</div>
                                    <div class="text-xs text-slate-500">Siswa English Club</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ BIG STATS SECTION ============ -->
    <section class="py-24 bg-navy-900 text-white relative overflow-hidden">
        <div class="absolute inset-0 grid-pattern opacity-10"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-sky-300/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-navy-700/30 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center mb-16">
                <div>
                    <h2 class="font-display font-bold text-5xl lg:text-7xl leading-[0.9] mb-6">
                        Built for<br>
                        <span class="italic text-sky-300">learners</span>,<br>
                        by learners.
                    </h2>
                    <p class="text-sky-100 text-lg max-w-md">Englify dibuat oleh dan untuk anggota English Club WJLRC yang pengen belajar English dengan cara yang lebih fun.</p>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-white/5 backdrop-blur border border-white/10 rounded-3xl p-8 hover:bg-white/10 transition group">
                        <div class="font-display font-bold text-6xl mb-2 group-hover:text-sky-300 transition">100+</div>
                        <div class="text-sm text-sky-100">Member Aktif</div>
                    </div>
                    <div class="bg-white/5 backdrop-blur border border-white/10 rounded-3xl p-8 hover:bg-white/10 transition group mt-8">
                        <div class="font-display font-bold text-6xl mb-2 group-hover:text-sky-300 transition">4</div>
                        <div class="text-sm text-sky-100">Divisi Belajar</div>
                    </div>
                    <div class="bg-white/5 backdrop-blur border border-white/10 rounded-3xl p-8 hover:bg-white/10 transition group">
                        <div class="font-display font-bold text-6xl mb-2 group-hover:text-sky-300 transition">40+</div>
                        <div class="text-sm text-sky-100">Materi Lengkap</div>
                    </div>
                    <div class="bg-white/5 backdrop-blur border border-white/10 rounded-3xl p-8 hover:bg-white/10 transition group mt-8">
                        <div class="font-display font-bold text-6xl mb-2 group-hover:text-sky-300 transition">10</div>
                        <div class="text-sm text-sky-100">Quiz per Bab</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ CTA SECTION (Bold) ============ -->
    <section class="py-32 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="bg-gradient-to-br from-navy-800 via-navy-700 to-navy-900 rounded-[3rem] p-12 lg:p-20 relative overflow-hidden">
                <!-- Decorative -->
                <div class="absolute top-0 right-0 w-96 h-96 bg-sky-300/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-72 h-72 bg-white/5 rounded-full blur-3xl"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] border border-white/5 rounded-full"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] border border-white/5 rounded-full"></div>

                <div class="relative z-10 text-center max-w-3xl mx-auto">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur border border-white/20 rounded-full mb-8">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                        <span class="text-xs font-bold text-white uppercase tracking-wider">Ready to start?</span>
                    </div>

                    <h2 class="font-display font-bold text-5xl lg:text-7xl text-white leading-[0.95] mb-6">
                        Siap mulai<br>
                        <span class="italic text-sky-300">perjalanan</span><br>
                        belajarmu?
                    </h2>

                    <p class="text-sky-100 text-lg mb-10 max-w-xl mx-auto">Jangan cuma tahu. Yuk mulai belajar dan tingkatkan kemampuan Bahasa Inggrismu bersama Englify.</p>

                    <div class="flex flex-wrap gap-4 justify-center">
                        <a href="/login" class="group relative px-8 py-4 bg-white text-navy-900 font-bold rounded-full overflow-hidden shadow-2xl hover:shadow-white/20 transition-all">
                            <span class="relative z-10 flex items-center gap-2">
                                Masuk & Mulai Belajar
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </span>
                        </a>
                        <a href="#fitur" class="px-8 py-4 bg-white/10 backdrop-blur text-white font-bold rounded-full border border-white/20 hover:bg-white/20 transition">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ FOOTER (Asymmetric) ============ -->
    <footer class="bg-navy-950 text-white pt-20 pb-8 relative overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-sky-300/5 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-12 gap-12 mb-16">
                <!-- Big Logo -->
                <div class="lg:col-span-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-navy-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="font-display font-bold text-3xl">englify</span>
                    </div>
                    <p class="text-slate-400 max-w-md leading-relaxed mb-8">Platform pembelajaran bahasa Inggris untuk English Club WJLRC. Belajar lebih mudah, terstruktur, dan menyenangkan.</p>
                    <div class="flex gap-3">
                        <a href="#" class="w-12 h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center hover:bg-white hover:text-navy-900 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="w-12 h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center hover:bg-white hover:text-navy-900 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                        <a href="#" class="w-12 h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center hover:bg-white hover:text-navy-900 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Links -->
                <div class="lg:col-span-2">
                    <h4 class="font-display font-bold mb-6 text-sm uppercase tracking-wider text-sky-300">Product</h4>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li><a href="#fitur" class="hover:text-white transition">Features</a></li>
                        <li><a href="#" class="hover:text-white transition">Materi</a></li>
                        <li><a href="#" class="hover:text-white transition">Quiz</a></li>
                        <li><a href="#" class="hover:text-white transition">Progress</a></li>
                    </ul>
                </div>

                <div class="lg:col-span-2">
                    <h4 class="font-display font-bold mb-6 text-sm uppercase tracking-wider text-sky-300">Company</h4>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li><a href="#tentang" class="hover:text-white transition">About</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Careers</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                    </ul>
                </div>

                <div class="lg:col-span-2">
                    <h4 class="font-display font-bold mb-6 text-sm uppercase tracking-wider text-sky-300">Legal</h4>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li><a href="#" class="hover:text-white transition">Privacy</a></li>
                        <li><a href="#" class="hover:text-white transition">Terms</a></li>
                        <li><a href="#" class="hover:text-white transition">Security</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-slate-500">© 2025 Englify. Made with 💙 for English Club WJLRC.</p>
                <div class="flex items-center gap-6 text-sm text-slate-500">
                    <a href="#" class="hover:text-white transition">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- ============ JAVASCRIPT ============ -->
    <script>
        // Scroll Reveal Animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Navbar scroll effect
        const nav = document.querySelector('nav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                nav.classList.add('shadow-2xl');
            } else {
                nav.classList.remove('shadow-2xl');
            }
        });
    </script>
</body>
</html>
