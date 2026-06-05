{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'ThreatWatch Nigeria — Real-time security incident tracking and reporting platform.')">
    <title>@yield('title', 'ThreatWatch Nigeria') — Securing the Nation</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ng: {
                            green:   '#009A44',
                            dark:    '#006B2F',
                            light:   '#00C453',
                            muted:   '#E8F7EE',
                            50:      '#f0fdf6',
                            100:     '#dcfce9',
                        }
                    },
                    fontFamily: {
                        display: ['"Space Grotesk"', 'sans-serif'],
                        body:    ['"Inter"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    {{-- Alpine.js --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('head_styles')

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1,h2,h3,h4,h5,h6,.font-display { font-family: 'Space Grotesk', sans-serif; }

        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #009A44; border-radius: 10px; }

        /* Severity pill system */
        .severity-low      { @apply bg-emerald-100 text-emerald-800 border border-emerald-200; }
        .severity-medium   { @apply bg-amber-100   text-amber-800   border border-amber-200; }
        .severity-high     { @apply bg-orange-100  text-orange-800  border border-orange-200; }
        .severity-critical { @apply bg-red-100     text-red-800     border border-red-200; }

        /* Status pills */
        .status-pending  { @apply bg-yellow-100 text-yellow-800 border border-yellow-200; }
        .status-approved { @apply bg-green-100  text-green-800  border border-green-200; }
        .status-rejected { @apply bg-red-100    text-red-800    border border-red-200; }

        /* Nav animated underline */
        .nav-link { position: relative; }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px; left: 0;
            width: 0; height: 2px;
            background: #009A44;
            transition: width .25s ease;
        }
        .nav-link:hover::after,
        .nav-link.active::after { width: 100%; }

        /* Live pulse */
        @keyframes pulse-ring {
            0%   { box-shadow: 0 0 0 0 rgba(0,154,68,0.5); }
            70%  { box-shadow: 0 0 0 8px rgba(0,154,68,0); }
            100% { box-shadow: 0 0 0 0 rgba(0,154,68,0); }
        }
        .pulse-live { animation: pulse-ring 2s infinite; }

        /* Card hover */
        .card-hover {
            transition: transform .18s ease, box-shadow .18s ease;
        }
        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(0,154,68,.1);
        }

        /* Smooth flash dismissal */
        .flash-msg { animation: slideIn .3s ease; }
        @keyframes slideIn {
            from { transform: translateY(-8px); opacity: 0; }
            to   { transform: translateY(0);    opacity: 1; }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased min-h-screen flex flex-col">

{{-- ================================================================
     NAVBAR
     ================================================================ --}}
<nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Brand --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                <div class="w-9 h-9 bg-ng-green rounded-xl flex items-center justify-center
                            shadow-sm group-hover:bg-ng-dark transition-colors">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div class="leading-none">
                    <span class="font-display font-bold text-gray-900 text-[1.05rem]">ThreatWatch</span>
                    <span class="block text-[0.6rem] text-ng-green font-semibold tracking-[0.15em] uppercase">Nigeria</span>
                </div>
            </a>

            {{-- Desktop Nav --}}
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ route('incidents.index') }}"
                   class="nav-link text-sm font-medium text-gray-600 hover:text-ng-green transition-colors
                          {{ request()->routeIs('incidents.*') ? 'text-ng-green active' : '' }}">
                    Incidents
                </a>
                <a href="{{ route('heatmap') }}"
                   class="nav-link text-sm font-medium text-gray-600 hover:text-ng-green transition-colors
                          {{ request()->routeIs('heatmap') ? 'text-ng-green active' : '' }}">
                    Heatmap
                </a>
                <a href="{{ route('helplines') }}"
                   class="nav-link text-sm font-medium text-gray-600 hover:text-ng-green transition-colors
                          {{ request()->routeIs('helplines') ? 'text-ng-green active' : '' }}">
                    Emergency Lines
                </a>
                @auth
                <a href="{{ route('reports.my') }}"
                   class="nav-link text-sm font-medium text-gray-600 hover:text-ng-green transition-colors">
                    My Reports
                </a>
                @endauth
            </div>

            {{-- Right actions --}}
            <div class="flex items-center gap-2.5">
                {{-- Live indicator --}}
                <div class="hidden sm:flex items-center gap-1.5 text-xs text-gray-500 mr-1">
                    <span class="w-2 h-2 bg-ng-green rounded-full pulse-live inline-block"></span>
                    <span class="font-medium">Live</span>
                </div>

                @auth
                    {{-- Report CTA --}}
                    <a href="{{ route('reports.create') }}"
                       class="hidden sm:flex items-center gap-1.5 bg-ng-green hover:bg-ng-dark text-white
                              text-xs font-bold px-3.5 py-2 rounded-lg transition-colors shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Report Threat
                    </a>

                    {{-- User dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false"
                                class="flex items-center gap-2 rounded-xl px-2 py-1.5
                                       hover:bg-ng-muted transition-colors focus:outline-none">
                            <img src="{{ auth()->user()->avatar_url }}"
                                 class="w-7 h-7 rounded-full border-2 border-ng-100 object-cover"
                                 alt="{{ auth()->user()->full_name }}">
                            <span class="hidden sm:block text-sm font-medium text-gray-700 max-w-[100px] truncate">
                                {{ auth()->user()->firstname }}
                            </span>
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl
                                    border border-gray-100 overflow-hidden z-50">
                            <div class="px-4 py-3 border-b border-gray-50">
                                <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->full_name }}</p>
                                <p class="text-xs text-gray-400 mt-0.5 capitalize">{{ auth()->user()->role_label }}</p>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('reports.my') }}"
                                   class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700
                                          hover:bg-ng-muted hover:text-ng-green transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    My Reports
                                </a>
                                @if(auth()->user()->isModerator())
                                <a href="{{ route('admin.dashboard') }}"
                                   class="flex items-center gap-2.5 px-4 py-2.5 text-sm font-semibold
                                          text-ng-green hover:bg-ng-muted transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                    Admin Panel ↗
                                </a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm
                                                   text-red-600 hover:bg-red-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                @else
                    <a href="{{ route('login') }}"
                       class="text-sm font-medium text-gray-600 hover:text-ng-green transition-colors">
                        Sign in
                    </a>
                    <a href="{{ route('register') }}"
                       class="bg-ng-green hover:bg-ng-dark text-white text-sm font-bold
                              px-4 py-2 rounded-xl transition-colors shadow-sm">
                        Register
                    </a>
                @endauth

                {{-- Mobile hamburger --}}
                <button @click="mobileOpen = !mobileOpen"
                        class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors">
                    <svg x-show="!mobileOpen" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileOpen" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div x-show="mobileOpen"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="md:hidden border-t border-gray-100 py-3 space-y-0.5">
            <a href="{{ route('incidents.index') }}" class="block px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-ng-muted hover:text-ng-green rounded-xl transition-colors">Incidents</a>
            <a href="{{ route('heatmap') }}" class="block px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-ng-muted hover:text-ng-green rounded-xl transition-colors">Heatmap</a>
            <a href="{{ route('helplines') }}" class="block px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-ng-muted hover:text-ng-green rounded-xl transition-colors">Emergency Lines</a>
            @auth
            <a href="{{ route('reports.create') }}" class="block px-3 py-2.5 text-sm font-bold text-ng-green hover:bg-ng-muted rounded-xl transition-colors">+ Report a Threat</a>
            <a href="{{ route('reports.my') }}" class="block px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-ng-muted rounded-xl transition-colors">My Reports</a>
            @endauth
        </div>
    </div>
</nav>

{{-- Flash messages --}}
@if(session('success') || session('error'))
<div class="max-w-7xl mx-auto px-4 pt-3">
    @if(session('success'))
    <div class="flash-msg bg-ng-muted border border-ng-green/30 text-ng-dark rounded-xl px-4 py-3
                flex items-center gap-3 text-sm font-medium shadow-sm">
        <svg class="w-4 h-4 text-ng-green flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="flash-msg bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3
                flex items-center gap-3 text-sm font-medium shadow-sm">
        <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif
</div>
@endif

{{-- Main --}}
<main class="flex-1">
    @yield('content')
</main>

{{-- ================================================================
     FOOTER
     ================================================================ --}}
<footer class="bg-gray-900 text-gray-400 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">

            {{-- Brand column --}}
            <div class="lg:col-span-2">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-9 h-9 bg-ng-green rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-display font-bold text-white text-base leading-none">ThreatWatch Nigeria</p>
                        <p class="text-xs text-ng-green font-medium tracking-widest uppercase mt-0.5">Securing the Nation</p>
                    </div>
                </div>
                <p class="text-sm leading-relaxed max-w-sm">
                    A civic-tech security awareness platform helping Nigerians monitor and report security incidents across all 36 states and the FCT.
                </p>
                <div class="flex items-center gap-2 mt-4 text-xs">
                    <span class="w-2 h-2 bg-ng-green rounded-full pulse-live inline-block"></span>
                    <span class="text-ng-green font-semibold">Live incident monitoring active</span>
                </div>
            </div>

            {{-- Platform links --}}
            <div>
                <h4 class="font-display font-semibold text-white text-sm mb-4 uppercase tracking-wider">Platform</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('incidents.index') }}" class="hover:text-ng-green transition-colors">Browse Incidents</a></li>
                    <li><a href="{{ route('heatmap') }}" class="hover:text-ng-green transition-colors">Attack Heatmap</a></li>
                    <li><a href="{{ route('helplines') }}" class="hover:text-ng-green transition-colors">Emergency Helplines</a></li>
                    <li><a href="{{ route('reports.create') }}" class="hover:text-ng-green transition-colors">Report a Threat</a></li>
                    @guest
                    <li><a href="{{ route('register') }}" class="hover:text-ng-green transition-colors">Create Account</a></li>
                    @endguest
                </ul>
            </div>

            {{-- Emergency numbers --}}
            <div>
                <h4 class="font-display font-semibold text-white text-sm mb-4 uppercase tracking-wider">Emergency Lines</h4>
                <ul class="space-y-2 text-sm">
                    @foreach(['🚔 Police' => '199 / 112', '🚑 Ambulance' => '0700-2625226', '🔥 Fire Service' => '01-272-0892', '🛡️ DSS Tip-off' => '08057000001', '🚗 FRSC' => '122'] as $name => $num)
                    <li class="flex items-center justify-between gap-2">
                        <span>{{ $name }}</span>
                        <strong class="text-white font-mono text-xs">{{ $num }}</strong>
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('helplines') }}"
                   class="inline-flex items-center gap-1 mt-4 text-xs text-ng-green hover:text-ng-light font-semibold transition-colors">
                    View all helplines →
                </a>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
            <p>© {{ date('Y') }} ThreatWatch Nigeria. A civic-tech initiative 🇳🇬</p>
            <p class="text-gray-600">Misuse of this platform is a criminal offense under Nigerian law.</p>
        </div>
    </div>
</footer>

@stack('scripts')
</body>
</html>
