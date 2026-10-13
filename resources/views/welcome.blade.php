@php
if (!isset($servers) || empty($servers)) {
$servers = [
  [
    'name' => 'Aliana',
    'location' => 'Osu',
    'image' => '/servers/server1.jpg',
    'likes' => 194,
    'premium' => true,
    'top' => 'TOP x14',
    'verified' => true,
  ],
  [
    'name' => 'Priuty',
    'location' => 'Osu',
    'image' => '/servers/server2.jpg',
    'likes' => 292,
    'premium' => true,
    'top' => null,
    'verified' => true,
  ],
  [
    'name' => 'Pretty',
    'location' => 'East Legon',
    'image' => '/servers/server3.jpg',
    'likes' => 67,
    'premium' => true,
    'top' => null,
    'verified' => true,
  ],
  [
    'name' => 'Dicktator',
    'location' => 'Labone',
    'image' => '/servers/server4.jpg',
    'likes' => 65,
    'premium' => true,
    'top' => null,
    'verified' => false,
  ],
   [
    'name' => 'Aliana',
    'location' => 'Osu',
    'image' => '/servers/server1.jpg',
    'likes' => 194,
    'premium' => true,
    'top' => 'TOP x14',
    'verified' => true,
  ],
  [
    'name' => 'Priuty',
    'location' => 'Osu',
    'image' => '/servers/server2.jpg',
    'likes' => 292,
    'premium' => true,
    'top' => null,
    'verified' => true,
  ],
  [
    'name' => 'Pretty',
    'location' => 'East Legon',
    'image' => '/servers/server3.jpg',
    'likes' => 67,
    'premium' => true,
    'top' => null,
    'verified' => true,
  ],
  [
    'name' => 'Dicktator',
    'location' => 'Labone',
    'image' => '/servers/server4.jpg',
    'likes' => 65,
    'premium' => true,
    'top' => null,
    'verified' => false,
  ],
   [
    'name' => 'Aliana',
    'location' => 'Osu',
    'image' => '/servers/server1.jpg',
    'likes' => 194,
    'premium' => true,
    'top' => 'TOP x14',
    'verified' => true,
  ],
  [
    'name' => 'Priuty',
    'location' => 'Osu',
    'image' => '/servers/server2.jpg',
    'likes' => 292,
    'premium' => true,
    'top' => null,
    'verified' => true,
  ],
  [
    'name' => 'Pretty',
    'location' => 'East Legon',
    'image' => '/servers/server3.jpg',
    'likes' => 67,
    'premium' => true,
    'top' => null,
    'verified' => true,
  ],
  [
    'name' => 'Dicktator',
    'location' => 'Labone',
    'image' => '/servers/server4.jpg',
    'likes' => 65,
    'premium' => true,
    'top' => null,
    'verified' => false,
  ],
   [
    'name' => 'Aliana',
    'location' => 'Osu',
    'image' => '/servers/server1.jpg',
    'likes' => 194,
    'premium' => true,
    'top' => 'TOP x14',
    'verified' => true,
  ],
  [
    'name' => 'Priuty',
    'location' => 'Osu',
    'image' => '/servers/server2.jpg',
    'likes' => 292,
    'premium' => true,
    'top' => null,
    'verified' => true,
  ],
  [
    'name' => 'Pretty',
    'location' => 'East Legon',
    'image' => '/servers/server3.jpg',
    'likes' => 67,
    'premium' => true,
    'top' => null,
    'verified' => true,
  ],
  [
    'name' => 'Dicktator',
    'location' => 'Labone',
    'image' => '/servers/server4.jpg',
    'likes' => 65,
    'premium' => true,
    'top' => null,
    'verified' => false,
  ]
];
}
@endphp
@extends('layouts.app')
@section('title', 'Hookup Linkup - Home')
@section('content')
  <div>
    <div class="relative flex flex-col items-center justify-center text-center px-4 sm:px-6 py-20 sm:py-28 flex-1 bg-cover bg-fixed bg-center" style="background-image: url('{{ asset('hero.jpg') }}');">
      {{-- Ambient background blur circles --}}
      <div class="absolute w-full h-full bg-black/50 blur-2xl"></div>
      {{-- Live Badge --}}
      <div class="relative inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 border border-[#ff2a6d]/30 backdrop-blur-md mb-8 shadow-lg shadow-[#ff0055]/10">
        <span class="relative flex h-2 w-2">
          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#ff0055] opacity-75"></span>
          <span class="relative inline-flex rounded-full h-2 w-2 bg-[#ff0055]"></span>
        </span>
        <span class="text-xs font-bold uppercase tracking-widest text-[#ff4d6d]">
          1.5M Verified Vibers
        </span>
      </div>

      {{-- Hero Title --}}
      <h1 class="relative max-w-4xl text-4xl sm:text-6xl lg:text-7xl font-black tracking-tight leading-[1.1] mb-6">
        <span class="bg-gradient-to-r from-[#ff0055] via-[#ff2a6d] to-[#9d4edd] bg-clip-text text-transparent">
          Ghana Hookup Platform
        </span>
      </h1>

      {{-- Hero Subtitle --}}
      <p class="relative max-w-2xl text-base sm:text-lg text-zinc-400 mb-10 leading-relaxed">
        Skip the endless small talk.
      </p>

      {{-- Hero CTAs --}}
      <div class="relative flex flex-col sm:flex-row items-center gap-4 w-full sm:w-auto">

        <a
          href="/discover"
          class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 rounded-full text-base font-semibold text-zinc-200 bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-200"
        >
          <span>Accra</span>
          <svg class="w-4 h-4 text-[#05f1cd]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" />
          </svg>
        </a>
        <a
          href="/discover"
          class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 rounded-full text-base font-semibold text-zinc-200 bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-200"
        >
          <span>Kumasi</span>
          <svg class="w-4 h-4 text-[#05f1cd]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" />
          </svg>
        </a>
        <a
          href="/discover"
          class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 rounded-full text-base font-semibold text-zinc-200 bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-200"
        >
          <span>Takoradi</span>
          <svg class="w-4 h-4 text-[#05f1cd]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" />
          </svg>
        </a>
      </div>

    </div>

    <section class="w-full bg-[#09090b] px-4 py-6 md:px-6">
      {{-- Featured Servers --}}
      <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
        @foreach($servers as $server)
          <div class="group relative h-[308px] overflow-hidden rounded-2xl bg-gray-900">
            {{-- Image --}}
            <img
              src="{{ $server['image'] }}"
              alt="{{ $server['name'] }}"
              class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
            />

            {{-- Gradient --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>

            {{-- Badges --}}
            <div class="absolute left-2.5 top-2.5 flex flex-col gap-1.5">
              @if($server['premium'])
                <span class="flex w-fit items-center gap-1 rounded-full bg-gradient-to-r from-yellow-300 to-orange-400 px-3 py-1 text-[11px] font-bold text-black">
                  <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles"><path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/><path d="M20 3v4"/><path d="M22 5h-4"/><path d="M4 17v2"/><path d="M5 18H3"/></svg>
                  PREMIUM
                </span>
              @endif

              @if($server['top'])
                <span class="flex w-fit items-center gap-1 rounded-full bg-gradient-to-r from-orange-500 to-red-500 px-3 py-1 text-[11px] font-bold text-white">
                  <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-flame"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg>
                  {{ $server['top'] }}
                </span>
              @endif
            </div>

            {{-- Likes --}}
            <div class="absolute right-2.5 top-2.5 flex items-center gap-1 rounded-full bg-black/55 px-2.5 py-1 text-xs font-semibold text-white backdrop-blur-sm">
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="#ff6b81" stroke="#ff6b81" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#ff6b81]"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
              {{ $server['likes'] }}
            </div>

            {{-- Server info --}}
            <div class="absolute bottom-0 left-0 right-0 p-3">
              <div class="flex items-center gap-1">
                <h3 class="text-[20px] font-extrabold leading-none text-white">
                  {{ $server['name'] }}
                </h3>

                @if($server['verified'])
                  <span class="flex h-[17px] w-[17px] items-center justify-center rounded-full bg-sky-500 text-[10px] font-bold text-white">
                    ✓
                  </span>
                @endif
              </div>

              <p class="mt-1 text-[12px] font-medium text-white/90">
                GH {{ $server['location'] }}
              </p>

              {{-- View Server - appears on hover --}}
              <a
                href="/detail/{{ $server['id'] ?? $loop->iteration }}"
                class="mt-3 flex w-full translate-y-4 items-center justify-center gap-2 rounded-full bg-white py-2.5 text-sm font-bold text-gray-900 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100 hover:bg-gray-100"
              >
                View Server
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
              </a>
            </div>
          </div>
        @endforeach
      </div>

      {{-- Latest Servers --}}
      <h2 class="mb-4 mt-7 text-[20px] font-extrabold text-white">
        Latest Servers
      </h2>
    </section>

  </div>
@endsection