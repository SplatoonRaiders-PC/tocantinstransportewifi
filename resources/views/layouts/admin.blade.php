<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Painel Administrativo') - WiFi Tocantins</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Admin Custom Styles -->
    <link href="{{ asset('css/admin-styles.css') }}?v={{ filemtime(public_path('css/admin-styles.css')) }}" rel="stylesheet">
    
    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            safelist: ['lg:ml-16', 'lg:flex'],
            theme: {
                extend: {
                    colors: {
                        surface: '#F8F9FA',
                        ink:    '#111111',
                        ink2:   '#333333',
                        muted:  '#888888',
                        border: '#E5E5E5',
                        green: {
                            DEFAULT: '#00A335',
                            light:   '#00C040',
                            dark:    '#007A28',
                            pale:    '#E8F5E9',
                        },
                        gold: {
                            DEFAULT: '#E6A817',
                            pale:    '#FFF8E1',
                        },
                        red: {
                            DEFAULT: '#D32F2F',
                            pale:    '#FFEBEE',
                        },
                        blue: {
                            DEFAULT: '#1565C0',
                            light:   '#1E88E5',
                            pale:    '#E3F2FD',
                        },
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    boxShadow: {
                        card:  '0 1px 3px rgba(0,0,0,0.08)',
                        hover: '0 4px 12px rgba(0,0,0,0.10)',
                        modal: '0 20px 60px rgba(0,0,0,0.20)',
                    },
                    keyframes: {
                        fadeUp: {
                            '0%':   { opacity: '0', transform: 'translateY(24px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                    },
                    animation: {
                        'fade-up': 'fadeUp .5s cubic-bezier(.22,1,.36,1) both',
                    },
                }
            }
        }
    </script>
    
    @stack('styles')
</head>
<body class="font-sans bg-[#F3F5F4] text-ink text-sm antialiased">

    <!-- Layout Principal -->
    <div class="min-h-screen bg-[#F3F5F4]">

        <!-- Sidebar Menu Component -->
        <x-sidebar-menu />

        <!-- Main Content Area -->
        <!-- lg:ml-16 used when sidebar collapsed -->
        <div class="lg:ml-64 min-h-screen flex flex-col transition-all duration-300">

            <!-- Top Header -->
            <header class="ui-modern sticky top-0 z-20 bg-white/80 backdrop-blur-xl border-b border-black/[0.06] px-4 sm:px-6 lg:px-8 h-16 flex items-center">
                <div class="flex w-full justify-between items-center gap-3">
                    <!-- Título e Breadcrumb -->
                    <div class="ml-12 lg:ml-0 min-w-0">
                        <nav class="flex items-center gap-1.5 text-[11px] font-medium text-muted leading-none mb-1">
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-green transition-colors flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                Início
                            </a>
                            @yield('breadcrumb')
                        </nav>
                        <div class="flex items-center gap-2">
                            <p class="text-lg font-extrabold text-ink tracking-tight leading-tight truncate">@yield('page-title', 'WiFi Tocantins Admin')</p>
                            <span class="hidden sm:inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200 px-2 py-0.5 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Starlink
                            </span>
                        </div>
                    </div>

                    <!-- Ações Rápidas -->
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <div class="hidden md:flex items-center text-xs font-medium text-ink2 bg-white ring-1 ring-black/[0.06] px-3 py-2 rounded-xl gap-1.5 shadow-sm">
                            <svg class="w-4 h-4 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ now()->format('d/m/Y H:i') }}
                        </div>

                        <div class="hidden lg:flex items-center gap-2">
                            @if(!request()->routeIs('admin.reports*'))
                            <a href="{{ route('admin.reports') }}" class="flex items-center px-3.5 py-2 text-xs font-bold text-emerald-700 bg-emerald-50 ring-1 ring-emerald-200 hover:bg-emerald-100 rounded-xl transition-colors gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                Relatórios
                            </a>
                            @endif
                            @if(!request()->routeIs('admin.vouchers*'))
                            <a href="{{ route('admin.vouchers.create') }}" class="flex items-center px-3.5 py-2 text-xs font-bold text-white bg-ink hover:bg-ink2 rounded-xl transition-colors gap-1.5 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Novo Voucher
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 pb-20 animate-fade-up">
                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="py-4 px-6 text-center text-xs text-muted border-t border-black/[0.06]">
                © {{ date('Y') }} Starlink · Tocantins Transporte · WiFi Tocantins. Todos os direitos reservados.
            </footer>
        </div>
    </div>

    <!-- Scripts Base -->
    <script>
        // Funções são definidas no componente sidebar-menu.blade.php
    </script>

    @stack('modals')
    @stack('scripts')
</body>
</html>

