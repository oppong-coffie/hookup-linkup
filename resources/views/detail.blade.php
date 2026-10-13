@extends('layouts.app')
@section('title', ($server['name'] ?? 'Server Profile') . ' - Hookup Linkup')

@section('content')
<div class="min-h-screen bg-zinc-950 px-4 py-8 text-white sm:px-6 lg:px-8">
    <div class="mx-auto max-w-6xl">

        {{-- Top Navigation Bar --}}
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 border-b border-white/10 pb-4">
            <a
                href="/"
                class="group inline-flex items-center gap-2 rounded-xl border border-white/10 bg-zinc-900 px-4 py-2 text-sm font-medium text-zinc-300 transition hover:border-pink-500/30 hover:bg-zinc-800 hover:text-white"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-hover:-translate-x-1">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Back to Vibers
            </a>

            <div class="flex items-center gap-3">
                {{-- Share Button --}}
                <button
                    type="button"
                    onclick="shareProfile()"
                    class="inline-flex items-center gap-2 rounded-xl border border-white/10 bg-zinc-900 px-3.5 py-2 text-xs font-semibold text-zinc-300 transition hover:bg-zinc-800 hover:text-white"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="18" cy="5" r="3"></circle>
                        <circle cx="6" cy="12" r="3"></circle>
                        <circle cx="18" cy="19" r="3"></circle>
                        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                    </svg>
                    Share
                </button>

                {{-- Interactive Like Button --}}
                <button
                    type="button"
                    id="likeProfileBtn"
                    onclick="toggleProfileLike()"
                    class="inline-flex items-center gap-2 rounded-xl border {{ !empty($isLiked) ? 'border-pink-500/40 bg-pink-500/10 text-pink-400' : 'border-white/10 bg-zinc-900 text-zinc-300' }} px-3.5 py-2 text-xs font-semibold transition hover:border-pink-500/40 hover:bg-zinc-800 hover:text-pink-400"
                >
                    <svg id="likeHeartIcon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="{{ !empty($isLiked) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-pink-500 transition-transform duration-200">
                        <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
                    </svg>
                    <span id="likesCountText">{{ $server['likes'] ?? 0 }}</span> Likes
                </button>
            </div>
        </div>

        {{-- Share Toast Notice --}}
        <div id="shareToast" class="fixed bottom-6 right-6 z-50 hidden rounded-2xl border border-emerald-500/30 bg-zinc-900/95 px-5 py-3 text-sm font-medium text-emerald-400 shadow-2xl backdrop-blur">
            ✓ Profile link copied to clipboard!
        </div>

        {{-- Profile Header Card --}}
        <div class="overflow-hidden rounded-3xl border border-white/10 bg-zinc-900 shadow-2xl">
            {{-- Cover Banner --}}
            <div class="relative h-48 bg-gradient-to-r from-pink-600 via-purple-600 to-indigo-700 sm:h-64">
                <div class="absolute inset-0 bg-black/20"></div>

                {{-- Floating Status Badge --}}
                <div class="absolute right-5 top-5 flex items-center gap-2 rounded-full border border-white/15 bg-black/40 px-3 py-1.5 backdrop-blur-md">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                    </span>
                    <span class="text-xs font-semibold text-emerald-400">
                        {{ $server['availability'] ?? 'Available Now' }}
                    </span>
                </div>
            </div>

            {{-- Profile Identity Row --}}
            <div class="px-6 pb-8 sm:px-8">
                <div class="-mt-20 flex flex-col items-center text-center sm:-mt-24 sm:flex-row sm:items-end sm:text-left">

                    {{-- Avatar Photo --}}
                    <div class="relative group cursor-pointer" onclick="openLightbox('{{ $server['profile_image'] ?? $server['image'] }}')">
                        <div class="h-36 w-36 overflow-hidden rounded-full border-4 border-zinc-900 bg-zinc-900 shadow-2xl ring-4 ring-pink-500/30 sm:h-44 sm:w-44">
                            <img
                                src="{{ $server['profile_image'] ?? $server['image'] ?? '/profile.jpg' }}"
                                alt="{{ $server['name'] }}"
                                class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                            >
                        </div>
                        <div class="absolute inset-0 flex items-center justify-center rounded-full bg-black/40 opacity-0 transition group-hover:opacity-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>
                        </div>
                    </div>

                    {{-- Name, Location, Badges --}}
                    <div class="mt-4 flex-1 sm:ml-6 sm:mt-0 sm:pb-2">
                        <div class="flex flex-wrap items-center justify-center gap-2 sm:justify-start">
                            <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                                {{ $server['name'] }}
                            </h1>

                            @if(!empty($server['verified']))
                                <span class="inline-flex items-center gap-1 rounded-full bg-sky-500/20 px-2.5 py-0.5 text-xs font-bold text-sky-400 border border-sky-500/30" title="Verified Viber">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                                    VERIFIED
                                </span>
                            @endif

                            @if(!empty($server['premium']))
                                <span class="inline-flex items-center gap-1 rounded-full bg-gradient-to-r from-amber-400 to-orange-500 px-2.5 py-0.5 text-[11px] font-bold text-black shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/></svg>
                                    PREMIUM
                                </span>
                            @endif

                            @if(!empty($server['top']))
                                <span class="inline-flex items-center gap-1 rounded-full bg-gradient-to-r from-orange-500 to-red-500 px-2.5 py-0.5 text-[11px] font-bold text-white shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg>
                                    {{ $server['top'] }}
                                </span>
                            @endif
                        </div>

                        <p class="mt-2 flex items-center justify-center gap-1.5 text-sm font-medium text-zinc-400 sm:justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-pink-500">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            GH {{ $server['location'] ?? 'Accra, Ghana' }}
                        </p>
                    </div>

                    {{-- Direct Action Buttons (WhatsApp & Call) --}}
                    @php
                        $cleanPhone = preg_replace('/[^0-9]/', '', $server['phone'] ?? '');
                        if (empty($cleanPhone)) {
                            $cleanPhone = '233550000000';
                        }
                        $whatsappMsg = urlencode("Hi {$server['name']}, I found your profile on Hookup Linkup! Are you available to connect?");
                    @endphp

                    <div class="mt-6 flex w-full flex-col gap-3 sm:mt-0 sm:w-auto sm:flex-row sm:pb-2">
                        {{-- WhatsApp CTA --}}
                        <a
                            href="https://wa.me/{{ $cleanPhone }}?text={{ $whatsappMsg }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-emerald-500/20 transition-all hover:shadow-emerald-500/40 hover:-translate-y-0.5 active:translate-y-0"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            Chat on WhatsApp
                        </a>

                        {{-- Call CTA --}}
                        <a
                            href="tel:{{ $server['phone'] ?? '' }}"
                            class="inline-flex items-center justify-center gap-2 rounded-2xl border border-white/10 bg-zinc-800 px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-zinc-700 active:translate-y-0"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                            Call
                        </a>
                    </div>

                </div>

                {{-- Stats Bar --}}
                <div class="mt-8 grid grid-cols-2 gap-4 border-t border-white/10 pt-6 text-center sm:grid-cols-4">
                    <div class="rounded-2xl border border-white/5 bg-zinc-800/40 p-3">
                        <p class="text-xs uppercase tracking-wider text-zinc-500">Likes</p>
                        <p class="mt-1 text-2xl font-bold text-pink-500" id="statLikesCount">{{ $server['likes'] ?? 0 }}</p>
                    </div>

                    <div class="rounded-2xl border border-white/5 bg-zinc-800/40 p-3">
                        <p class="text-xs uppercase tracking-wider text-zinc-500">Views</p>
                        <p class="mt-1 text-2xl font-bold text-sky-400">{{ $server['views'] ?? 1 }}</p>
                    </div>

                    <div class="rounded-2xl border border-white/5 bg-zinc-800/40 p-3">
                        <p class="text-xs uppercase tracking-wider text-zinc-500">Age</p>
                        <p class="mt-1 text-2xl font-bold text-white">{{ $server['age'] ?? '23' }} <span class="text-sm font-normal text-zinc-500">yrs</span></p>
                    </div>

                    <div class="rounded-2xl border border-white/5 bg-zinc-800/40 p-3">
                        <p class="text-xs uppercase tracking-wider text-zinc-500">Comments</p>
                        <p class="mt-1 text-2xl font-bold text-emerald-400" id="statCommentsCount">{{ count($comments ?? []) }}</p>
                    </div>
                </div>

            </div>
        </div>

        {{-- Content Grid: Left Column (Bio, Specs, Gallery, Comments), Right Column (Contact & Guidelines) --}}
        <div class="mt-8 grid grid-cols-1 gap-8 lg:grid-cols-3">

            {{-- Left 2 Columns: Bio, Info, Gallery, and Comments --}}
            <div class="space-y-8 lg:col-span-2">

                {{-- About Me Card --}}
                <div class="rounded-3xl border border-white/10 bg-zinc-900 p-6 sm:p-8">
                    <h2 class="flex items-center gap-2 text-xl font-bold text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-pink-500"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        About {{ $server['name'] }}
                    </h2>

                    <p class="mt-4 leading-relaxed text-zinc-300 text-base">
                        {{ $server['bio'] ?? 'No bio description provided yet.' }}
                    </p>

                    {{-- Tags & Highlights --}}
                    @if(!empty($server['services']))
                        <div class="mt-6 border-t border-white/10 pt-5">
                            <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500">Vibe & Activities</p>
                            <div class="mt-3 flex flex-wrap gap-2">
                                @foreach($server['services'] as $service)
                                    <span class="rounded-xl border border-pink-500/20 bg-pink-500/10 px-3.5 py-1.5 text-xs font-semibold text-pink-300">
                                        ✨ {{ $service }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Detailed Specs / Overview Table --}}
                <div class="rounded-3xl border border-white/10 bg-zinc-900 p-6 sm:p-8">
                    <h2 class="flex items-center gap-2 text-xl font-bold text-white mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-pink-500"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                        Personal Details & Preferences
                    </h2>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="flex items-center justify-between rounded-2xl border border-white/5 bg-zinc-800/50 p-4">
                            <span class="text-sm text-zinc-400">Location</span>
                            <span class="text-sm font-semibold text-white">{{ $server['location'] ?? 'Accra, Ghana' }}</span>
                        </div>

                        <div class="flex items-center justify-between rounded-2xl border border-white/5 bg-zinc-800/50 p-4">
                            <span class="text-sm text-zinc-400">Phone Contact</span>
                            <span class="text-sm font-semibold text-emerald-400">{{ $server['phone'] ?? 'Hidden' }}</span>
                        </div>

                        <div class="flex items-center justify-between rounded-2xl border border-white/5 bg-zinc-800/50 p-4">
                            <span class="text-sm text-zinc-400">Height</span>
                            <span class="text-sm font-semibold text-white">{{ $server['height'] ?? '5 ft 7 in' }}</span>
                        </div>

                        <div class="flex items-center justify-between rounded-2xl border border-white/5 bg-zinc-800/50 p-4">
                            <span class="text-sm text-zinc-400">Languages</span>
                            <span class="text-sm font-semibold text-white">{{ $server['languages'] ?? 'English, Twi' }}</span>
                        </div>

                        <div class="flex items-center justify-between rounded-2xl border border-white/5 bg-zinc-800/50 p-4">
                            <span class="text-sm text-zinc-400">Availability</span>
                            <span class="text-sm font-semibold text-emerald-400">{{ $server['availability'] ?? 'Available Now' }}</span>
                        </div>

                        <div class="flex items-center justify-between rounded-2xl border border-white/5 bg-zinc-800/50 p-4">
                            <span class="text-sm text-zinc-400">Verification</span>
                            <span class="inline-flex items-center gap-1 text-sm font-semibold text-sky-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                                100% Verified
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Photo Gallery Section --}}
                @php
                    $gallery = $server['gallery'] ?? [];
                    if (empty($gallery)) {
                        $gallery = [$server['profile_image'] ?? $server['image'] ?? '/servers/server1.jpg'];
                    }
                @endphp

                <div class="rounded-3xl border border-white/10 bg-zinc-900 p-6 sm:p-8">
                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <h2 class="flex items-center gap-2 text-xl font-bold text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-pink-500"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><circle cx="9" cy="9" r="2"></circle><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path></svg>
                                Photo Gallery
                            </h2>
                            <p class="mt-1 text-xs text-zinc-500">Tap any photo to view in full resolution</p>
                        </div>

                        <span class="rounded-full bg-zinc-800 px-3 py-1 text-xs font-semibold text-zinc-400">
                            {{ count($gallery) }} Photos
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                        @foreach($gallery as $photo)
                            <div
                                class="group relative aspect-square cursor-pointer overflow-hidden rounded-2xl border border-white/10 bg-zinc-800"
                                onclick="openLightbox('{{ $photo }}')"
                            >
                                <img
                                    src="{{ $photo }}"
                                    alt="{{ $server['name'] }} gallery photo"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-110"
                                    loading="lazy"
                                >
                                <div class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition group-hover:opacity-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Comments & Reviews Section --}}
                <div class="rounded-3xl border border-white/10 bg-zinc-900 p-6 sm:p-8" id="commentsSection">
                    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <h2 class="flex items-center gap-2 text-xl font-bold text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-pink-500">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                                Comments & Reviews
                            </h2>
                            <p class="mt-1 text-xs text-zinc-500">Real feedback from verified vibers</p>
                        </div>

                        <span id="commentsCountBadge" class="rounded-full bg-pink-500/10 border border-pink-500/20 px-3 py-1 text-xs font-semibold text-pink-400">
                            {{ count($comments ?? []) }} Comments
                        </span>
                    </div>

                    {{-- Add Comment Form --}}
                    <form id="commentForm" onsubmit="submitComment(event)" class="mb-8 rounded-2xl border border-white/5 bg-zinc-800/40 p-5">
                        @csrf
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Leave a Review</span>

                            {{-- Star Rating Picker --}}
                            <div class="flex items-center gap-1" id="starRatingContainer">
                                @for($i = 1; $i <= 5; $i++)
                                    <button
                                        type="button"
                                        class="star-btn text-amber-400 transition hover:scale-125 focus:outline-none"
                                        data-rating="{{ $i }}"
                                        onclick="setCommentRating({{ $i }})"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" stroke="none">
                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                        </svg>
                                    </button>
                                @endfor
                                <input type="hidden" name="rating" id="commentRating" value="5">
                            </div>
                        </div>

                        @guest
                            <div class="mb-3">
                                <input
                                    type="text"
                                    id="commentAuthorName"
                                    name="name"
                                    placeholder="Your Name or Nickname (e.g. Kwame)"
                                    maxlength="80"
                                    class="w-full rounded-xl border border-white/10 bg-zinc-900 px-4 py-2.5 text-sm text-white placeholder-zinc-500 outline-none transition focus:border-pink-500/50"
                                >
                            </div>
                        @else
                            <div class="mb-3 flex items-center gap-2 text-xs text-zinc-400">
                                <span>Commenting as:</span>
                                <span class="font-semibold text-white">{{ Auth::user()->name }}</span>
                            </div>
                        @endguest

                        <div class="mb-3">
                            <textarea
                                id="commentText"
                                name="comment"
                                rows="3"
                                required
                                maxlength="1000"
                                placeholder="Share your experience or leave a nice message for {{ $server['name'] }}..."
                                class="w-full resize-none rounded-xl border border-white/10 bg-zinc-900 p-3.5 text-sm text-white placeholder-zinc-500 outline-none transition focus:border-pink-500/50"
                            ></textarea>
                        </div>

                        <div id="commentAlert" class="mb-3 hidden rounded-xl px-4 py-2.5 text-xs font-medium"></div>

                        <div class="flex items-center justify-end">
                            <button
                                type="submit"
                                id="commentSubmitBtn"
                                class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-pink-600 to-pink-500 px-5 py-2.5 text-xs font-bold text-white shadow-lg shadow-pink-500/20 transition hover:shadow-pink-500/40 hover:-translate-y-0.5 active:translate-y-0 disabled:opacity-50"
                            >
                                <span id="commentSubmitBtnIcon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="22" y1="2" x2="11" y2="13"></line>
                                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                    </svg>
                                </span>
                                <span id="commentSubmitBtnText">Post Comment</span>
                            </button>
                        </div>
                    </form>

                    {{-- Comments Feed --}}
                    <div id="commentsList" class="space-y-4">
                        @if(!empty($comments) && count($comments) > 0)
                            @foreach($comments as $c)
                                <div class="comment-card rounded-2xl border border-white/5 bg-zinc-800/30 p-4 transition hover:border-white/10">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            @if(!empty($c['user_avatar']))
                                                <img src="{{ $c['user_avatar'] }}" alt="{{ $c['user_name'] }}" class="h-9 w-9 rounded-full object-cover border border-white/10">
                                            @else
                                                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-tr from-pink-600 to-purple-600 text-xs font-bold text-white shadow">
                                                    {{ strtoupper(substr($c['user_name'] ?? 'V', 0, 1)) }}
                                                </div>
                                            @endif

                                            <div>
                                                <h4 class="text-sm font-semibold text-white">{{ $c['user_name'] ?? 'Anonymous Viber' }}</h4>
                                                <div class="flex items-center gap-1.5 mt-0.5">
                                                    {{-- Star rating display --}}
                                                    <div class="flex text-amber-400">
                                                        @for($s = 1; $s <= ($c['rating'] ?? 5); $s++)
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="currentColor">
                                                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                            </svg>
                                                        @endfor
                                                    </div>
                                                    <span class="text-[11px] text-zinc-500">• {{ $c['formatted_date'] ?? 'Recently' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <p class="mt-3 text-sm text-zinc-300 leading-relaxed pl-12">
                                        {{ $c['comment'] }}
                                    </p>
                                </div>
                            @endforeach
                        @else
                            <div id="noCommentsBox" class="rounded-2xl border border-white/5 bg-zinc-800/20 p-8 text-center">
                                <p class="text-sm font-medium text-zinc-400">No comments yet.</p>
                                <p class="mt-1 text-xs text-zinc-500">Be the first to leave a comment or review for {{ $server['name'] }}!</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            {{-- Right Column: Safety Guidelines & Direct Contact Box --}}
            <div class="space-y-6">

                {{-- Direct Connect Card --}}
                <div class="rounded-3xl border border-white/10 bg-gradient-to-b from-zinc-900 to-zinc-950 p-6 shadow-xl">
                    <h3 class="text-lg font-bold text-white">Connect with {{ $server['name'] }}</h3>
                    <p class="mt-2 text-xs text-zinc-400 leading-relaxed">
                        Ready to make plans? Contact {{ $server['name'] }} directly via WhatsApp or phone.
                    </p>

                    <div class="mt-5 space-y-3">
                        <a
                            href="https://wa.me/{{ $cleanPhone }}?text={{ $whatsappMsg }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 py-3 text-sm font-bold text-white shadow-md shadow-emerald-500/20 transition hover:shadow-emerald-500/40 hover:-translate-y-0.5"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            Start WhatsApp Chat
                        </a>

                        <a
                            href="tel:{{ $server['phone'] ?? '' }}"
                            class="flex w-full items-center justify-center gap-2 rounded-xl border border-white/10 bg-zinc-800 py-3 text-sm font-semibold text-white transition hover:bg-zinc-700"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                            Call {{ $server['name'] }}
                        </a>
                    </div>
                </div>

                {{-- Safety Card --}}
                <div class="rounded-3xl border border-white/10 bg-zinc-900 p-6">
                    <h3 class="flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-pink-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        Safe Meetup Tips
                    </h3>

                    <ul class="mt-4 space-y-2.5 text-xs text-zinc-400">
                        <li class="flex items-start gap-2">
                            <span class="text-pink-500 font-bold">•</span>
                            <span>Always meet in public locations (cafes, lounges, hotel restaurants) first.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-pink-500 font-bold">•</span>
                            <span>Never send advance payments or deposits before meeting in person.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-pink-500 font-bold">•</span>
                            <span>Inform a close friend or family member of your whereabouts.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-pink-500 font-bold">•</span>
                            <span>Profiles with the blue badge have undergone ID verification.</span>
                        </li>
                    </ul>
                </div>

            </div>

        </div>

        {{-- More Vibers You Might Like --}}
        @if(!empty($relatedServers))
            <div class="mt-16 border-t border-white/10 pt-10">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-extrabold text-white">More Vibers You Might Like</h2>
                        <p class="mt-1 text-sm text-zinc-400">Explore other verified companions in Ghana</p>
                    </div>

                    <a href="/" class="text-xs font-semibold text-pink-500 hover:text-pink-400 transition">
                        View All →
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                    @foreach(array_slice($relatedServers, 0, 4) as $rel)
                        <div class="group relative h-[280px] overflow-hidden rounded-2xl bg-zinc-900 border border-white/5">
                            <img
                                src="{{ $rel['image'] ?? $rel['profile_image'] ?? '/servers/server1.jpg' }}"
                                alt="{{ $rel['name'] }}"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>

                            {{-- Badges --}}
                            <div class="absolute right-2.5 top-2.5 flex items-center gap-1 rounded-full bg-black/60 px-2 py-0.5 text-[11px] font-semibold text-white backdrop-blur">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="#ff6b81" stroke="#ff6b81" stroke-width="2"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                                {{ $rel['likes'] ?? 0 }}
                            </div>

                            <div class="absolute bottom-0 left-0 right-0 p-3">
                                <h3 class="text-base font-bold text-white">{{ $rel['name'] }}</h3>
                                <p class="text-xs text-zinc-400">GH {{ $rel['location'] ?? 'Accra' }}</p>

                                <a
                                    href="/detail/{{ $rel['id'] }}"
                                    class="mt-2.5 flex w-full items-center justify-center gap-1.5 rounded-xl bg-white/90 py-1.5 text-xs font-bold text-black transition hover:bg-white"
                                >
                                    View Server
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>

{{-- Lightbox Modal --}}
<div id="lightboxModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/90 p-4 backdrop-blur-md" onclick="closeLightbox(event)">
    <button
        type="button"
        onclick="closeLightbox(event)"
        class="absolute right-5 top-5 rounded-full bg-white/10 p-2.5 text-white transition hover:bg-white/20"
        title="Close (Esc)"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
    <img
        id="lightboxImg"
        src=""
        alt="Enlarged photo"
        class="max-h-[90vh] max-w-[90vw] rounded-2xl object-contain shadow-2xl"
    >
</div>

<script>
    const serverId = {{ json_encode($server['id']) }};
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    let isLiked = {{ !empty($isLiked) ? 'true' : 'false' }};

    function openLightbox(src) {
        const modal = document.getElementById('lightboxModal');
        const img = document.getElementById('lightboxImg');
        img.src = src;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox(e) {
        if (e.target.id === 'lightboxModal' || e.target.closest('button')) {
            const modal = document.getElementById('lightboxModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            const modal = document.getElementById('lightboxModal');
            if (modal && !modal.classList.contains('hidden')) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            }
        }
    });

    function shareProfile() {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(window.location.href);
        }
        const toast = document.getElementById('shareToast');
        if (toast) {
            toast.classList.remove('hidden');
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }
    }

    // Toggle Profile Like with Backend Persistence
    async function toggleProfileLike() {
        const btn = document.getElementById('likeProfileBtn');
        const likesElem = document.getElementById('likesCountText');
        const statLikesElem = document.getElementById('statLikesCount');
        const heartIcon = document.getElementById('likeHeartIcon');

        // Optimistic UI update
        let currentLikes = parseInt(likesElem.textContent) || 0;
        const willBeLiked = !isLiked;
        isLiked = willBeLiked;

        if (willBeLiked) {
            currentLikes++;
            heartIcon.setAttribute('fill', 'currentColor');
            heartIcon.classList.add('scale-125');
            btn.classList.add('border-pink-500/40', 'bg-pink-500/10', 'text-pink-400');
            btn.classList.remove('border-white/10', 'bg-zinc-900', 'text-zinc-300');
            setTimeout(() => heartIcon.classList.remove('scale-125'), 250);
        } else {
            currentLikes = Math.max(0, currentLikes - 1);
            heartIcon.setAttribute('fill', 'none');
            btn.classList.remove('border-pink-500/40', 'bg-pink-500/10', 'text-pink-400');
            btn.classList.add('border-white/10', 'bg-zinc-900', 'text-zinc-300');
        }

        likesElem.textContent = currentLikes;
        if (statLikesElem) {
            statLikesElem.textContent = currentLikes;
        }

        try {
            const res = await fetch(`/detail/${serverId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({}),
            });

            const data = await res.json();
            if (data && data.success) {
                isLiked = data.liked;
                likesElem.textContent = data.likes_count;
                if (statLikesElem) {
                    statLikesElem.textContent = data.likes_count;
                }
            }
        } catch (err) {
            console.error('Like toggle error:', err);
        }
    }

    // Star rating picker
    function setCommentRating(rating) {
        document.getElementById('commentRating').value = rating;
        const buttons = document.querySelectorAll('.star-btn');
        buttons.forEach((btn, index) => {
            const starSvg = btn.querySelector('svg');
            if (index < rating) {
                starSvg.setAttribute('fill', 'currentColor');
                btn.classList.remove('text-zinc-600');
                btn.classList.add('text-amber-400');
            } else {
                starSvg.setAttribute('fill', 'none');
                starSvg.setAttribute('stroke', 'currentColor');
                starSvg.setAttribute('stroke-width', '2');
                btn.classList.remove('text-amber-400');
                btn.classList.add('text-zinc-600');
            }
        });
    }

    // Submit Comment via AJAX
    async function submitComment(event) {
        event.preventDefault();

        const form = document.getElementById('commentForm');
        const submitBtn = document.getElementById('commentSubmitBtn');
        const submitBtnText = document.getElementById('commentSubmitBtnText');
        const submitBtnIcon = document.getElementById('commentSubmitBtnIcon');
        const alertBox = document.getElementById('commentAlert');
        const commentText = document.getElementById('commentText');
        const authorInput = document.getElementById('commentAuthorName');
        const ratingInput = document.getElementById('commentRating');

        const commentVal = commentText.value.trim();
        if (!commentVal) return;

        submitBtn.disabled = true;
        submitBtnText.textContent = 'Posting...';
        submitBtnIcon.innerHTML = `
            <svg class="h-3.5 w-3.5 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        `;

        const payload = {
            comment: commentVal,
            rating: ratingInput ? parseInt(ratingInput.value) || 5 : 5,
        };

        if (authorInput && authorInput.value.trim()) {
            payload.name = authorInput.value.trim();
        }

        try {
            const res = await fetch(`/detail/${serverId}/comment`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify(payload),
            });

            const data = await res.json();

            if (!res.ok) {
                const errorMsg = data.message || (data.errors && Object.values(data.errors).flat().join(', ')) || 'Failed to post comment.';
                throw new Error(errorMsg);
            }

            // Success message
            alertBox.textContent = 'Comment posted successfully!';
            alertBox.className = 'mb-3 rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-2.5 text-xs font-medium text-emerald-400 block';
            setTimeout(() => alertBox.classList.add('hidden'), 4000);

            // Prepend new comment card to feed
            const c = data.comment;
            const commentsList = document.getElementById('commentsList');
            const noCommentsBox = document.getElementById('noCommentsBox');
            if (noCommentsBox) {
                noCommentsBox.remove();
            }

            const starRating = c.rating || 5;
            let starsHtml = '';
            for (let s = 1; s <= starRating; s++) {
                starsHtml += `
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="currentColor">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                    </svg>
                `;
            }

            const initialLetter = (c.user_name || 'V').charAt(0).toUpperCase();
            const avatarHtml = c.user_avatar
                ? `<img src="${c.user_avatar}" alt="${c.user_name}" class="h-9 w-9 rounded-full object-cover border border-white/10">`
                : `<div class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-tr from-pink-600 to-purple-600 text-xs font-bold text-white shadow">${initialLetter}</div>`;

            const card = document.createElement('div');
            card.className = 'comment-card rounded-2xl border border-white/5 bg-zinc-800/30 p-4 transition hover:border-white/10 opacity-0 translate-y-2';
            card.innerHTML = `
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        ${avatarHtml}
                        <div>
                            <h4 class="text-sm font-semibold text-white">${c.user_name || 'Anonymous Viber'}</h4>
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <div class="flex text-amber-400">${starsHtml}</div>
                                <span class="text-[11px] text-zinc-500">• ${c.formatted_date || 'Just now'}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="mt-3 text-sm text-zinc-300 leading-relaxed pl-12">
                    ${escapeHtml(c.comment)}
                </p>
            `;

            commentsList.prepend(card);

            // Animate card entrance
            requestAnimationFrame(() => {
                card.classList.remove('opacity-0', 'translate-y-2');
                card.classList.add('transition-all', 'duration-300', 'opacity-100', 'translate-y-0');
            });

            // Update comment count badges
            const count = data.comments_count;
            const badge = document.getElementById('commentsCountBadge');
            const statComments = document.getElementById('statCommentsCount');
            if (badge) badge.textContent = `${count} Comments`;
            if (statComments) statComments.textContent = count;

            // Reset comment textarea
            commentText.value = '';

        } catch (err) {
            console.error('Comment submit error:', err);
            alertBox.textContent = err.message || 'Failed to submit comment.';
            alertBox.className = 'mb-3 rounded-xl border border-red-500/20 bg-red-500/10 px-4 py-2.5 text-xs font-medium text-red-400 block';
        } finally {
            submitBtn.disabled = false;
            submitBtnText.textContent = 'Post Comment';
            submitBtnIcon.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="22" y1="2" x2="11" y2="13"></line>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                </svg>
            `;
        }
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
</script>
@endsection
