@extends('layouts.app')
@section('title', 'Portal - Hookup Linkup')
@section('content')
<div class="min-h-screen bg-zinc-950 px-4 py-10 text-white">
    <div class="mx-auto max-w-5xl">

        {{-- Profile Header --}}
        <div class="overflow-hidden rounded-3xl border border-white/10 bg-zinc-900 shadow-2xl">

            {{-- Cover --}}
            <div class="h-40 bg-gradient-to-r from-pink-600 via-purple-600 to-indigo-600"></div>

            {{-- Profile Info --}}
            <div class="px-6 pb-8">

                <div class="-mt-20 flex flex-col items-center text-center md:flex-row md:items-end md:text-left">

                    {{-- Profile Image --}}
                    <div class="rounded-full border-8 border-zinc-900 bg-zinc-900 shadow-xl">
                        <img
                            src="{{ Auth::user()->profile_image ?? '/profile.jpg' }}"
                            alt="{{ Auth::user()->name }}"
                            class="h-36 w-36 rounded-full object-cover"
                        >
                    </div>

                    {{-- Name --}}
                    <div class="mt-4 md:ml-6 md:mt-0 md:pb-2">
                        <h1 class="text-3xl font-bold">
                            Welcome, {{ Auth::user()->name }}
                        </h1>

                        <p class="mt-1 text-sm text-zinc-400">
                            Your Hookup Linkup profile
                        </p>
                    </div>

                    {{-- Action --}}
                    <div class="mt-5 md:ml-auto md:pb-2">
                        <a
                            href="/portal/edit"
                            class="inline-flex items-center rounded-xl bg-pink-600 px-5 py-3
                                   text-sm font-semibold transition hover:bg-pink-700"
                        >
                            Edit Profile
                        </a>
                    </div>

                </div>

                {{-- Stats --}}
                <div class="mt-8 grid grid-cols-3 border-t border-white/10 pt-6 text-center">

                    <div>
                        <p class="text-2xl font-bold text-pink-500">{{ is_array(Auth::user()->likes) ? count(Auth::user()->likes) : (int)(Auth::user()->likes ?? 0) }}</p>
                        <p class="text-sm text-zinc-500">Likes</p>
                    </div>

                    <div>
                        <p class="text-2xl font-bold text-sky-400">{{ Auth::user()->views ?? 0 }}</p>
                        <p class="text-sm text-zinc-500">Views</p>
                    </div>

                    <div>
                        <p class="text-2xl font-bold text-emerald-400">{{ is_array(Auth::user()->comments) ? count(Auth::user()->comments) : 0 }}</p>
                        <p class="text-sm text-zinc-500">Comments</p>
                    </div>

                </div>

            </div>
        </div>


        {{-- Alerts / Feedback --}}
        @if(session('success'))
            <div class="mt-6 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-5 py-4 text-sm text-emerald-400">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mt-6 rounded-2xl border border-red-500/20 bg-red-500/10 px-5 py-4">
                <ul class="space-y-1 text-sm text-red-400">
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div id="galleryAlert" class="hidden mt-6 rounded-2xl px-5 py-4 text-sm transition"></div>

        {{-- Gallery --}}
        <div class="mt-8">

            <div class="mb-5 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold">
                        My Gallery
                    </h2>

                    <p class="mt-1 text-sm text-zinc-500">
                        Photos you've added to your profile
                    </p>
                </div>

                <div>
                    <input
                        type="file"
                        id="photo"
                        name="photo"
                        accept="image/jpeg,image/png,image/webp"
                        class="hidden"
                    >

                    <button
                        type="button"
                        id="addPhotoBtn"
                        onclick="document.getElementById('photo').click()"
                        class="inline-flex items-center gap-2 rounded-xl border border-white/10 bg-zinc-900 px-4 py-2.5
                               text-sm font-semibold text-zinc-200 shadow-md transition
                               hover:border-pink-500/30 hover:bg-zinc-800 hover:text-white
                               disabled:cursor-not-allowed disabled:opacity-60 active:scale-95"
                    >
                        <span id="addPhotoBtnIcon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                        </span>
                        <span id="addPhotoBtnText">+ Add Photo</span>
                    </button>
                </div>
            </div>

            @php
                $hasGallery = Auth::user()->gallery && count(Auth::user()->gallery) > 0;
            @endphp

            {{-- Gallery Grid --}}
            <div id="galleryGrid" class="{{ $hasGallery ? 'grid' : 'hidden' }} grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4">
                @if($hasGallery)
                    @foreach(Auth::user()->gallery as $photo)
                        <div class="gallery-item group relative aspect-square overflow-hidden rounded-2xl border border-white/10 bg-zinc-900 transition duration-300" data-photo="{{ $photo }}">
                            <img
                                src="{{ $photo }}"
                                alt="Gallery photo"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-110"
                                loading="lazy"
                            >

                            {{-- Hover Overlay --}}
                            <div class="absolute inset-0 flex items-end bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 transition duration-200 group-hover:opacity-100">
                                <div class="w-full p-3">
                                    <button
                                        type="button"
                                        onclick="deleteGalleryPhoto('{{ addslashes($photo) }}', this)"
                                        class="remove-photo-btn rounded-lg bg-red-600/90 px-3 py-1.5 text-xs font-semibold text-white shadow backdrop-blur transition hover:bg-red-500 disabled:opacity-50"
                                    >
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- Empty Gallery State --}}
            <div id="emptyGalleryState" class="{{ $hasGallery ? 'hidden' : 'block' }} rounded-2xl border border-white/10 bg-zinc-900/60 p-12 text-center">
                <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-zinc-800 text-zinc-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                </div>
                <p class="font-medium text-zinc-400">No photos in your gallery yet.</p>
                <p class="mt-1 text-xs text-zinc-500">Click "+ Add Photo" to showcase your best moments.</p>
            </div>

        </div>

        {{-- Profile Comments Section --}}
        @php
            $userComments = is_array(Auth::user()->comments) ? Auth::user()->comments : [];
        @endphp

        <div class="mt-10 rounded-3xl border border-white/10 bg-zinc-900 p-6 sm:p-8">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-pink-500">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                        Comments on Your Profile
                    </h2>
                    <p class="mt-1 text-sm text-zinc-500">What vibers are saying about your profile</p>
                </div>

                <span class="rounded-full bg-pink-500/10 border border-pink-500/20 px-3 py-1 text-xs font-semibold text-pink-400">
                    {{ count($userComments) }} Comments
                </span>
            </div>

            @if(count($userComments) > 0)
                <div class="space-y-3">
                    @foreach($userComments as $cm)
                        <div class="rounded-2xl border border-white/5 bg-zinc-800/40 p-4 transition hover:border-white/10">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-tr from-pink-600 to-purple-600 text-xs font-bold text-white shadow">
                                        {{ strtoupper(substr($cm['user_name'] ?? 'V', 0, 1)) }}
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-white">{{ $cm['user_name'] ?? 'Anonymous Viber' }}</h4>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            @if(!empty($cm['rating']))
                                                <div class="flex text-amber-400">
                                                    @for($s = 1; $s <= $cm['rating']; $s++)
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="currentColor">
                                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                        </svg>
                                                    @endfor
                                                </div>
                                            @endif
                                            <span class="text-[11px] text-zinc-500">• {{ $cm['formatted_date'] ?? 'Recently' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-2.5 text-sm text-zinc-300 leading-relaxed pl-11">
                                {{ $cm['comment'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="rounded-2xl border border-white/5 bg-zinc-800/20 p-8 text-center">
                    <p class="text-sm font-medium text-zinc-400">No comments on your profile yet.</p>
                    <p class="mt-1 text-xs text-zinc-500">When visitors leave reviews or feedback, they will appear here.</p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
