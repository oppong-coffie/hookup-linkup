@extends('layouts.app')
@section('title', 'Create Account - Hookup Linkup')
@section('content')
<div class="min-h-[calc(100vh-200px)] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-lg relative">
        {{-- Background glow --}}
        <div class="absolute -inset-1 bg-gradient-to-r from-[#9d4edd] to-[#ff0055] rounded-2xl blur opacity-25"></div>
        
        <div class="relative bg-zinc-900 border border-white/10 rounded-2xl p-8 sm:p-10 shadow-2xl">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-black text-white tracking-tight mb-2">Join the Club</h1>
                <p class="text-zinc-400 text-sm">Create an account to start vibing with verified members.</p>
            </div>

            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="mb-6 rounded-xl border border-red-500/20 bg-red-500/10 px-5 py-4">
                    <ul class="space-y-1 text-sm text-red-400">
                        @foreach($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/register" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="first_name" class="block text-sm font-semibold text-zinc-300 mb-2">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="w-full bg-zinc-950 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-[#9d4edd] focus:ring-1 focus:ring-[#9d4edd] transition-all" placeholder="Kwame" required>
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-semibold text-zinc-300 mb-2">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="w-full bg-zinc-950 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-[#9d4edd] focus:ring-1 focus:ring-[#9d4edd] transition-all" placeholder="Mensah" required>
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-zinc-300 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full bg-zinc-950 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-[#9d4edd] focus:ring-1 focus:ring-[#9d4edd] transition-all" placeholder="you@example.com" required>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-semibold text-zinc-300 mb-2">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="w-full bg-zinc-950 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-[#9d4edd] focus:ring-1 focus:ring-[#9d4edd] transition-all" placeholder="+233 XX XXX XXXX">
                </div>

                <div>
                    <label for="location" class="block text-sm font-semibold text-zinc-300 mb-2">Location</label>
                    <input type="text" id="location" name="location" value="{{ old('location') }}" class="w-full bg-zinc-950 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-[#9d4edd] focus:ring-1 focus:ring-[#9d4edd] transition-all" placeholder="e.g. Accra, Ghana">
                </div>

                <div>
                    <label for="bio" class="block text-sm font-semibold text-zinc-300 mb-2">Bio</label>
                    <textarea id="bio" name="bio" rows="3" maxlength="500" class="w-full bg-zinc-950 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-[#9d4edd] focus:ring-1 focus:ring-[#9d4edd] transition-all resize-none" placeholder="Tell vibers a little about yourself…">{{ old('bio') }}</textarea>
                </div>

                {{-- Profile Image Upload --}}
                <div>
                    <label class="block text-sm font-semibold text-zinc-300 mb-2">Profile Photo</label>
                    <label for="profile_image" class="flex cursor-pointer items-center gap-4 rounded-lg border-2 border-dashed border-white/10 bg-zinc-950 px-4 py-4 transition hover:border-[#9d4edd]/40 hover:bg-zinc-950/80">
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-zinc-800">
                            <img id="imagePreview" src="" alt="" class="hidden h-full w-full rounded-full object-cover">
                            <svg id="uploadIcon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-zinc-500">
                                <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/>
                                <circle cx="12" cy="13" r="3"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-zinc-400">Click to upload a photo</span>
                            <span class="block mt-0.5 text-xs text-zinc-600">JPG, PNG or WEBP — max 2MB</span>
                        </div>
                    </label>
                    <input type="file" id="profile_image" name="profile_image" accept="image/*" class="hidden" onchange="previewImage(event)">
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-zinc-300 mb-2">Password</label>
                    <input type="password" id="password" name="password" class="w-full bg-zinc-950 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-[#9d4edd] focus:ring-1 focus:ring-[#9d4edd] transition-all" placeholder="Create a strong password" required>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-zinc-300 mb-2">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="w-full bg-zinc-950 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-[#9d4edd] focus:ring-1 focus:ring-[#9d4edd] transition-all" placeholder="Repeat your password" required>
                </div>

                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input type="checkbox" id="terms" name="terms" class="w-4 h-4 rounded border-white/10 bg-zinc-950 text-[#9d4edd] focus:ring-[#9d4edd] focus:ring-offset-zinc-900" required>
                    </div>
                    <label for="terms" class="ml-2 text-sm text-zinc-400 leading-relaxed">
                        I agree to the <a href="#" class="text-white hover:text-[#9d4edd] transition-colors underline decoration-white/30 underline-offset-2">Terms of Service</a> and <a href="#" class="text-white hover:text-[#9d4edd] transition-colors underline decoration-white/30 underline-offset-2">Privacy Policy</a>.
                    </label>
                </div>

                <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3.5 rounded-lg text-sm font-bold text-white bg-gradient-to-r from-[#9d4edd] to-[#ff2a6d] shadow-lg shadow-[#9d4edd]/20 hover:shadow-[#9d4edd]/40 transition-all hover:-translate-y-0.5">
                    Create Account
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-white/10 text-center">
                <p class="text-zinc-400 text-sm">
                    Already have an account? 
                    <a href="/login" class="font-bold text-white hover:text-[#9d4edd] transition-colors">Log in</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                document.getElementById('uploadIcon').classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
