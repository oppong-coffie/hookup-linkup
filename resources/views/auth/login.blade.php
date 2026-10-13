@extends('layouts.app')
@section('title', 'Log In - Hookup Linkup')
@section('content')
<div class="min-h-[calc(100vh-200px)] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md relative">
        {{-- Background glow --}}
        <div class="absolute -inset-1 bg-gradient-to-r from-[#ff0055] to-[#9d4edd] rounded-2xl blur opacity-25"></div>
        
        <div class="relative bg-zinc-900 border border-white/10 rounded-2xl p-8 sm:p-10 shadow-2xl">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-black text-white tracking-tight mb-2">Welcome Back</h1>
                <p class="text-zinc-400 text-sm">Enter your credentials to access your account.</p>
            </div>

            <form action="#" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-semibold text-zinc-300 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" class="w-full bg-zinc-950 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-[#ff2a6d] focus:ring-1 focus:ring-[#ff2a6d] transition-all" placeholder="you@example.com" required>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-sm font-semibold text-zinc-300">Password</label>
                        <a href="#" class="text-xs font-semibold text-[#ff2a6d] hover:text-[#ff0055] transition-colors">Forgot password?</a>
                    </div>
                    <input type="password" id="password" name="password" class="w-full bg-zinc-950 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-[#ff2a6d] focus:ring-1 focus:ring-[#ff2a6d] transition-all" placeholder="••••••••" required>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded border-white/10 bg-zinc-950 text-[#ff2a6d] focus:ring-[#ff2a6d] focus:ring-offset-zinc-900">
                    <label for="remember" class="ml-2 text-sm text-zinc-400">Remember me</label>
                </div>

                <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3.5 rounded-lg text-sm font-bold text-white bg-gradient-to-r from-[#ff0055] to-[#ff2a6d] hover:to-[#ff0055] shadow-lg shadow-[#ff0055]/20 hover:shadow-[#ff0055]/40 transition-all hover:-translate-y-0.5">
                    Log In
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-white/10 text-center">
                <p class="text-zinc-400 text-sm">
                    Don't have an account? 
                    <a href="/register" class="font-bold text-white hover:text-[#ff2a6d] transition-colors">Sign up</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
