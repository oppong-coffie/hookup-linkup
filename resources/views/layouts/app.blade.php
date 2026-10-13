<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hookup Linkup')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-zinc-950 text-white flex flex-col font-sans antialiased selection:bg-[#ff0055] selection:text-white">

    {{-- Navbar --}}
    <header class="fixed top-0 w-full z-50 bg-zinc-950/70 backdrop-blur-md border-b border-white/10 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                {{-- Logo --}}
                <div class="bg-white p-1 rounded-lg">
                    <a href="/" class="flex items-center gap-2 group">
                        <img src="logo.png" alt="" width="60" height="100" class="rounded-full"/>
                        <img src="logo2.png" alt="" width="110" height="110"/>
                    </a>
                </div>

                {{-- Desktop Menu --}}
                <nav class="hidden md:flex items-center gap-8">
                    <a href="/" class="text-sm font-semibold text-zinc-300 hover:text-white transition-colors">Home</a>
                </nav>

                {{-- Auth Buttons --}}
                <div class="flex items-center gap-4">
                    <a href="/portal" class="inline-flex items-center justify-center px-6 py-2.5 rounded-full text-sm font-bold text-white bg-gradient-to-r from-[#ff0055] to-[#ff2a6d] hover:to-[#ff0055] shadow-lg shadow-[#ff0055]/20 hover:shadow-[#ff0055]/40 transition-all hover:-translate-y-0.5">
                        Portal
                    </a>
                    <!-- Telegram Link -->
                    <a href="https://t.me/+dvnOoilhpwY3Njg0" target="_blank" class="inline-flex items-center justify-center px-6 py-2.5 rounded-full text-sm font-bold text-white bg-gradient-to-r from-[#ff0055] to-[#ff2a6d] hover:to-[#ff0055] shadow-lg shadow-[#ff0055]/20 hover:shadow-[#ff0055]/40 transition-all hover:-translate-y-0.5">
                        Telegram
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="flex-1 mt-20">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-zinc-950 border-t border-white/5 pt-16 pb-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <a href="/" class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-[#ff0055] to-[#9d4edd] flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-white"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/></svg>
                        </div>
                        <span class="font-bold text-lg text-white">Hookup Linkup</span>
                    </a>
                    <p class="text-zinc-500 text-sm max-w-sm leading-relaxed">
                        The premier platform to connect with verified vibers across Ghana. Skip the small talk and dive into real connections.
                    </p>
                </div>
                <div>
                    <h3 class="font-semibold text-white mb-4">Locations</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-zinc-500 hover:text-[#ff2a6d] transition-colors text-sm">Accra</a></li>
                        <li><a href="#" class="text-zinc-500 hover:text-[#ff2a6d] transition-colors text-sm">Kumasi</a></li>
                        <li><a href="#" class="text-zinc-500 hover:text-[#ff2a6d] transition-colors text-sm">Takoradi</a></li>
                        <li><a href="#" class="text-zinc-500 hover:text-[#ff2a6d] transition-colors text-sm">Cape Coast</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold text-white mb-4">Legal</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-zinc-500 hover:text-[#ff2a6d] transition-colors text-sm">Privacy Policy</a></li>
                        <li><a href="#" class="text-zinc-500 hover:text-[#ff2a6d] transition-colors text-sm">Terms of Service</a></li>
                        <li><a href="#" class="text-zinc-500 hover:text-[#ff2a6d] transition-colors text-sm">Cookie Policy</a></li>
                        <li><a href="#" class="text-zinc-500 hover:text-[#ff2a6d] transition-colors text-sm">Safety Tips</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/5 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-zinc-600 text-xs">
                    &copy; {{ date('Y') }} Hookup Linkup. All rights reserved.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="text-zinc-600 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                    </a>
                    <a href="#" class="text-zinc-600 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                    </a>
                    <a href="#" class="text-zinc-600 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
