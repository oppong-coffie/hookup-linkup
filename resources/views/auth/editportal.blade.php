@extends('layouts.app')
@section('title', 'Edit Profile - Hookup Linkup')
@section('content')
<div class="min-h-screen bg-zinc-950 px-4 py-10 text-white">
    <div class="mx-auto max-w-2xl">

        {{-- Back Link --}}
        <a href="/portal" class="mb-8 inline-flex items-center gap-2 text-sm text-zinc-400 transition hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6"/>
            </svg>
            Back to Portal
        </a>

        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold">Edit Profile</h1>
            <p class="mt-2 text-sm text-zinc-500">Update your information visible to other vibers</p>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-5 py-4 text-sm text-emerald-400">
                {{ session('success') }}
            </div>
        @endif

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="mb-6 rounded-2xl border border-red-500/20 bg-red-500/10 px-5 py-4">
                <ul class="space-y-1 text-sm text-red-400">
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/portal/edit" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            {{-- Profile Image Section --}}
            <div class="overflow-hidden rounded-3xl border border-white/10 bg-zinc-900 p-6">
                <h2 class="mb-5 text-lg font-semibold">Profile Photo</h2>

                <div class="flex flex-col items-center gap-6 sm:flex-row">
                    {{-- Current Image Preview --}}
                    <div class="relative group">
                        <div class="h-32 w-32 overflow-hidden rounded-full border-4 border-zinc-800 shadow-xl
                                    shadow-pink-500/10">
                            <img
                                id="imagePreview"
                                src="{{ Auth::user()->profile_image ?? '/profile.jpg' }}"
                                alt="{{ Auth::user()->name }}"
                                class="h-full w-full object-cover"
                            >
                        </div>
                        <div class="absolute inset-0 flex items-center justify-center rounded-full bg-black/50
                                    opacity-0 transition group-hover:opacity-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="text-white">
                                <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/>
                                <circle cx="12" cy="13" r="3"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Upload Area --}}
                    <div class="flex-1">
                        <label for="profile_image"
                               class="flex cursor-pointer flex-col items-center rounded-2xl border-2 border-dashed
                                      border-white/10 bg-zinc-800/50 px-6 py-8 transition
                                      hover:border-pink-500/40 hover:bg-zinc-800">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round" class="mb-3 text-zinc-500">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="17,8 12,3 7,8"/>
                                <line x1="12" x2="12" y1="3" y2="15"/>
                            </svg>
                            <span class="text-sm font-medium text-zinc-400">Click to upload a photo</span>
                            <span class="mt-1 text-xs text-zinc-600">JPG, PNG or WEBP — max 2MB</span>
                        </label>
                        <input type="file" id="profile_image" name="profile_image" accept="image/*" class="hidden"
                               onchange="previewImage(event)">
                    </div>
                </div>
            </div>

            {{-- Personal Info Section --}}
            <div class="overflow-hidden rounded-3xl border border-white/10 bg-zinc-900 p-6">
                <h2 class="mb-5 text-lg font-semibold">Personal Information</h2>

                <div class="space-y-5">
                    {{-- Name --}}
                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-zinc-400">Display Name</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', Auth::user()->name) }}"
                            placeholder="Your display name"
                            class="w-full rounded-xl border border-white/10 bg-zinc-800 px-4 py-3
                                   text-white placeholder-zinc-600 outline-none transition
                                   focus:border-pink-500/50 focus:ring-2 focus:ring-pink-500/20"
                        >
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label for="phone" class="mb-2 block text-sm font-medium text-zinc-400">Phone Number</label>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            value="{{ old('phone', Auth::user()->phone) }}"
                            placeholder="+233 XX XXX XXXX"
                            class="w-full rounded-xl border border-white/10 bg-zinc-800 px-4 py-3
                                   text-white placeholder-zinc-600 outline-none transition
                                   focus:border-pink-500/50 focus:ring-2 focus:ring-pink-500/20"
                        >
                    </div>

                    {{-- Location --}}
                    <div>
                        <label for="location" class="mb-2 block text-sm font-medium text-zinc-400">Location</label>
                        <input
                            type="text"
                            id="location"
                            name="location"
                            value="{{ old('location', Auth::user()->location) }}"
                            placeholder="e.g. Accra, Ghana"
                            class="w-full rounded-xl border border-white/10 bg-zinc-800 px-4 py-3
                                   text-white placeholder-zinc-600 outline-none transition
                                   focus:border-pink-500/50 focus:ring-2 focus:ring-pink-500/20"
                        >
                    </div>
                </div>
            </div>

            {{-- Bio Section --}}
            <div class="overflow-hidden rounded-3xl border border-white/10 bg-zinc-900 p-6">
                <h2 class="mb-5 text-lg font-semibold">About You</h2>

                <div>
                    <label for="bio" class="mb-2 block text-sm font-medium text-zinc-400">Bio</label>
                    <textarea
                        id="bio"
                        name="bio"
                        rows="4"
                        maxlength="500"
                        placeholder="Tell other vibers a little about yourself…"
                        class="w-full resize-none rounded-xl border border-white/10 bg-zinc-800 px-4 py-3
                               text-white placeholder-zinc-600 outline-none transition
                               focus:border-pink-500/50 focus:ring-2 focus:ring-pink-500/20"
                        oninput="updateCharCount(this)"
                    >{{ old('bio', Auth::user()->bio) }}</textarea>
                    <p class="mt-2 text-right text-xs text-zinc-600">
                        <span id="charCount">{{ strlen(old('bio', Auth::user()->bio ?? '')) }}</span>/500
                    </p>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <a href="/portal"
                   class="inline-flex items-center justify-center rounded-xl border border-white/10
                          bg-zinc-900 px-6 py-3 text-sm font-semibold text-zinc-300 transition
                          hover:bg-zinc-800 hover:text-white">
                    Cancel
                </a>
                <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r
                               from-pink-600 to-pink-500 px-8 py-3 text-sm font-bold text-white
                               shadow-lg shadow-pink-500/20 transition hover:shadow-pink-500/40
                               hover:-translate-y-0.5 active:translate-y-0">
                    Save Changes
                </button>
            </div>

        </form>

    </div>
</div>

{{-- Image Preview Script --}}
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    function updateCharCount(textarea) {
        document.getElementById('charCount').textContent = textarea.value.length;
    }
</script>
@endsection
