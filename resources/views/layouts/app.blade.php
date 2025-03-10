<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        /* Page Transition */
        .page-transition {
            opacity: 1;
            transition: opacity 300ms ease-in-out;
        }

        .page-transition.loading {
            opacity: 0.6;
        }
    </style>
</head>
<body class="font-sans antialiased overflow-hidden">
    <div
        x-data="{ loading: false }"
        @navigate.window="loading = true"
        @load.window="loading = false"
        class="drawer lg:drawer-open h-screen"
    >
        <input id="my-drawer" type="checkbox" class="drawer-toggle" />

        <div class="drawer-content flex flex-col h-screen">
            <!-- Fixed Navbar -->
            <div class="sticky top-0 z-30 w-full navbar bg-base-100 shadow-lg border-b border-base-200 backdrop-blur-sm bg-opacity-90">
                <!-- Mobile Menu -->
                <div class="flex-none lg:hidden">
                    <label for="my-drawer" class="btn btn-square btn-ghost drawer-button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </label>
                </div>

                <!-- Brand -->
                <div class="flex-1 px-2 mx-2">
                    <div class="flex items-center gap-2">
                        <!-- App Logo -->
                        <div class="avatar">
                            <div class="w-8 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                                <img src="https://api.dicebear.com/7.x/bottts/svg?seed={{ config('app.name') }}" alt="Logo" />
                            </div>
                        </div>
                        <span class="text-lg font-bold text-base-content">{{ config('app.name', 'Laravel') }}</span>
                    </div>
                </div>

                <!-- Right Side Navigation -->
                <div class="flex-none gap-2">
                    <!-- Search -->
                    <div class="form-control hidden lg:block">
                        <input type="text" placeholder="Search..." class="input input-bordered input-sm w-48 bg-base-200" />
                    </div>

                    <!-- Notifications -->
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="btn btn-ghost btn-circle text-base-content">
                            <div class="indicator">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span class="badge badge-sm badge-primary indicator-item">7</span>
                            </div>
                        </label>
                        <div tabindex="0" class="dropdown-content card card-compact w-64 p-2 shadow-lg bg-base-100 text-base-content">
                            <div class="card-body">
                                <h3 class="font-bold text-lg">Notifications</h3>
                                <div class="divider my-0"></div>
                                <p class="text-sm">No new notifications</p>
                            </div>
                        </div>
                    </div>

                    <!-- Theme Toggle -->
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="btn btn-ghost btn-circle text-base-content">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </label>
                        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow-lg bg-base-100 rounded-box w-52">
                            <li><button onclick="setTheme('light')" class="gap-2">🌞 Light</button></li>
                            <li><button onclick="setTheme('dark')" class="gap-2">🌚 Dark</button></li>
                            <li><button onclick="setTheme('system')" class="gap-2">💻 System</button></li>
                        </ul>
                    </div>

                    <!-- User Menu -->
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                            <div class="w-8 rounded-full ring ring-primary ring-offset-base-100 ring-offset-1">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" />
                            </div>
                        </label>
                        <ul tabindex="0" class="mt-3 z-[1] p-2 shadow-lg menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                            <div class="px-4 py-3">
                                <span class="block text-sm font-semibold">{{ auth()->user()->name }}</span>
                                <span class="block text-xs opacity-70">{{ auth()->user()->email }}</span>
                            </div>
                            <div class="divider my-0"></div>
                            <li>
                                <a href="{{ route('profile.edit') }}" class="text-base-content">Profile</a>
                            </li>
                            <li><a class="text-base-content">Settings</a></li>
                            <div class="divider my-0"></div>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full text-left text-error hover:text-error-content">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content with transitions -->
            <main
                class="flex-1 pt-2 overflow-y-auto scroll-smooth page-transition"
                :class="{ 'loading': loading }"
                style="scroll-behavior: smooth;"
            >
                {{ $slot }}
            </main>
        </div>

        <!-- Sidebar -->
        <x-sidebar />
    </div>
    @stack('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Theme management
        function setTheme(theme) {
            if (theme === 'system') {
                const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                document.documentElement.setAttribute('data-theme', systemTheme);
                localStorage.setItem('theme', 'system');
            } else {
                document.documentElement.setAttribute('data-theme', theme);
                localStorage.setItem('theme', theme);
            }
        }

        // Initialize theme
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme') || 'system';
            if (savedTheme === 'system') {
                const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                document.documentElement.setAttribute('data-theme', systemTheme);
            } else {
                document.documentElement.setAttribute('data-theme', savedTheme);
            }

            // Listen for system theme changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                if (localStorage.getItem('theme') === 'system') {
                    document.documentElement.setAttribute('data-theme', e.matches ? 'dark' : 'light');
                }
            });
        });
    </script>
</body>
</html>
