<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ServerController extends Controller
{
    /**
     * Default list of featured servers with rich profile data.
     */
    public static function getStaticServers(): array
    {
        return [
            1 => [
                'id' => 1,
                'name' => 'Aliana',
                'location' => 'Osu, Accra',
                'city' => 'Accra',
                'image' => '/servers/server1.jpg',
                'profile_image' => '/servers/server1.jpg',
                'likes' => 194,
                'views' => 1420,
                'age' => 23,
                'gender' => 'Female',
                'phone' => '+233 55 812 9401',
                'bio' => 'Charming, discreet, and always the life of the party. I enjoy fine dining, rooftop cocktail lounges, and spontaneous weekend road trips. Looking for mature, respectful vibes.',
                'premium' => true,
                'top' => 'TOP x14',
                'verified' => true,
                'height' => '5 ft 7 in',
                'languages' => 'English, Twi',
                'availability' => 'Available Today',
                'services' => ['Dinner Date', 'VIP Events', 'Travel Companion', 'Chilled Hangouts'],
                'gallery' => [
                    '/servers/server1.jpg',
                    '/servers/server2.jpg',
                    '/servers/server3.jpg',
                    '/servers/server5.jpg',
                ],
                'default_comments' => [
                    [
                        'id' => 'static_1_1',
                        'user_name' => 'Kwame A.',
                        'user_avatar' => null,
                        'rating' => 5,
                        'comment' => 'Such a pleasant and classy lady! We had dinner at Skybar in Airport and her energy was unmatched.',
                        'formatted_date' => '3 days ago',
                    ],
                    [
                        'id' => 'static_1_2',
                        'user_name' => 'Marcus T.',
                        'user_avatar' => null,
                        'rating' => 5,
                        'comment' => '100% verified, punctual and very polite. Will definitely connect again whenever I am in Accra.',
                        'formatted_date' => '1 week ago',
                    ],
                ],
            ],
            2 => [
                'id' => 2,
                'name' => 'Priuty',
                'location' => 'Osu, Accra',
                'city' => 'Accra',
                'image' => '/servers/server2.jpg',
                'profile_image' => '/servers/server2.jpg',
                'likes' => 292,
                'views' => 2840,
                'age' => 24,
                'gender' => 'Female',
                'phone' => '+233 24 631 8294',
                'bio' => 'Bubbly sweet vibe with an elegant touch. Love deep conversations, beach sunsets, and unforgettable nights out. 100% genuine and verified.',
                'premium' => true,
                'top' => 'TOP x8',
                'verified' => true,
                'height' => '5 ft 6 in',
                'languages' => 'English, Twi, Ga',
                'availability' => 'Available Now',
                'services' => ['Social Escort', 'Cocktails & Lounge', 'Private Hangout'],
                'gallery' => [
                    '/servers/server2.jpg',
                    '/servers/server1.jpg',
                    '/servers/server4.jpg',
                    '/servers/server3.jpg',
                ],
                'default_comments' => [
                    [
                        'id' => 'static_2_1',
                        'user_name' => 'Nana O.',
                        'user_avatar' => null,
                        'rating' => 5,
                        'comment' => 'Priuty is literally the sweetest! Made my weekend trip to Laboma beach super fun.',
                        'formatted_date' => '2 days ago',
                    ],
                ],
            ],
            3 => [
                'id' => 3,
                'name' => 'Pretty',
                'location' => 'East Legon, Accra',
                'city' => 'Accra',
                'image' => '/servers/server3.jpg',
                'profile_image' => '/servers/server3.jpg',
                'likes' => 167,
                'views' => 1890,
                'age' => 22,
                'gender' => 'Female',
                'phone' => '+233 50 714 5520',
                'bio' => 'Lifestyle model and fashion enthusiast based in East Legon. Friendly, easygoing, and drama-free. Let’s make memorable moments together.',
                'premium' => true,
                'top' => null,
                'verified' => true,
                'height' => '5 ft 8 in',
                'languages' => 'English, French',
                'availability' => 'Evenings & Weekends',
                'services' => ['Clubbing & VIP', 'Dinner Companion', 'Exclusive Vibes'],
                'gallery' => [
                    '/servers/server3.jpg',
                    '/servers/server5.jpg',
                    '/servers/server2.jpg',
                ],
                'default_comments' => [
                    [
                        'id' => 'static_3_1',
                        'user_name' => 'Kofi D.',
                        'user_avatar' => null,
                        'rating' => 5,
                        'comment' => 'Gorgeous and genuine. Exactly like her photos and very attentive.',
                        'formatted_date' => '5 days ago',
                    ],
                ],
            ],
            4 => [
                'id' => 4,
                'name' => 'Dicktator',
                'location' => 'Labone, Accra',
                'city' => 'Accra',
                'image' => '/servers/server4.jpg',
                'profile_image' => '/servers/server4.jpg',
                'likes' => 65,
                'views' => 840,
                'age' => 27,
                'gender' => 'Male',
                'phone' => '+233 26 908 3311',
                'bio' => 'Athletic gentleman with great energy. Perfect gentleman for social events, fitness routines, and high-end company. Discreet and punctual.',
                'premium' => true,
                'top' => null,
                'verified' => false,
                'height' => '6 ft 1 in',
                'languages' => 'English, Twi',
                'availability' => 'By Appointment',
                'services' => ['Event Escort', 'Gym & Wellness', 'Private Companion'],
                'gallery' => [
                    '/servers/server4.jpg',
                    '/servers/server1.jpg',
                ],
                'default_comments' => [],
            ],
            5 => [
                'id' => 5,
                'name' => 'Ama Sparkles',
                'location' => 'Airport Residential, Accra',
                'city' => 'Accra',
                'image' => '/servers/server5.jpg',
                'profile_image' => '/servers/server5.jpg',
                'likes' => 312,
                'views' => 3560,
                'age' => 25,
                'gender' => 'Female',
                'phone' => '+233 54 992 4810',
                'bio' => 'Radiant smile, high fashion, and luxurious vibes. Available for sophisticated companionship, travel, and high-profile parties.',
                'premium' => true,
                'top' => 'TOP x20',
                'verified' => true,
                'height' => '5 ft 7 in',
                'languages' => 'English, Twi',
                'availability' => 'Available Now',
                'services' => ['VIP Hospitality', 'Fine Dining', 'Weekend Trips'],
                'gallery' => [
                    '/servers/server5.jpg',
                    '/servers/server3.jpg',
                    '/servers/server2.jpg',
                    '/servers/server1.jpg',
                ],
                'default_comments' => [
                    [
                        'id' => 'static_5_1',
                        'user_name' => 'Ekow J.',
                        'user_avatar' => null,
                        'rating' => 5,
                        'comment' => 'The absolute VIP standard! Look no further in Airport Residential.',
                        'formatted_date' => '4 days ago',
                    ],
                ],
            ],
        ];
    }

    /**
     * Display the welcome page with real and featured servers.
     */
    public function index()
    {
        $staticServers = self::getStaticServers();

        // Check if there are users registered in the DB
        $dbUsers = User::where('is_active', true)->get();
        $servers = [];

        foreach ($dbUsers as $user) {
            $likes = is_array($user->likes) ? $user->likes : [];
            $servers[] = [
                'id' => $user->id,
                'name' => $user->name,
                'location' => $user->location ?? 'Accra',
                'image' => $user->profile_image ?? '/servers/server1.jpg',
                'profile_image' => $user->profile_image ?? '/servers/server1.jpg',
                'likes' => count($likes),
                'premium' => true,
                'top' => null,
                'verified' => (bool) $user->is_verified,
            ];
        }

        // Fill up with static servers to maintain a rich grid
        $baseList = array_values($staticServers);
        $count = count($servers);
        for ($i = 0; $count + $i < 16; $i++) {
            $base = $baseList[$i % count($baseList)];
            $clone = $base;
            $clone['id'] = $base['id']; // preserve ID so it routes to the correct profile
            $servers[] = $clone;
        }

        return view('welcome', compact('servers'));
    }

    /**
     * Show server / user details on detail.blade.php
     */
    public function show($id, Request $request)
    {
        $server = null;
        $isLiked = false;
        $comments = [];

        // Identifier for current visitor
        $likerId = Auth::id() ? 'user_' . Auth::id() : 'session_' . $request->session()->getId();

        // 1. Try finding in database
        $user = User::find($id);

        if ($user) {
            $user->increment('views');

            $gallery = $user->gallery ?? [];
            if (empty($gallery) && $user->profile_image) {
                $gallery = [$user->profile_image];
            }

            $likes = is_array($user->likes) ? $user->likes : [];
            $isLiked = in_array($likerId, $likes);
            $comments = is_array($user->comments) ? $user->comments : [];

            $server = [
                'id' => $user->id,
                'name' => $user->name,
                'location' => $user->location ?? 'Accra, Ghana',
                'city' => $user->location ?? 'Accra',
                'image' => $user->profile_image ?? '/servers/server1.jpg',
                'profile_image' => $user->profile_image ?? '/servers/server1.jpg',
                'likes' => count($likes),
                'views' => $user->views,
                'age' => $user->age ?? 24,
                'gender' => $user->gender ?? 'Female',
                'phone' => $user->phone ?? '+233 55 000 0000',
                'bio' => $user->bio ?: 'Hey there! Welcome to my Hookup Linkup profile. Reach out to connect and make some unforgettable memories.',
                'premium' => true,
                'top' => null,
                'verified' => (bool) $user->is_verified,
                'height' => '5 ft 7 in',
                'languages' => 'English, Twi',
                'availability' => 'Available Now',
                'services' => ['Dinner Date', 'Chill Hangouts', 'Social Companion'],
                'gallery' => $gallery,
                'is_db_user' => true,
            ];
        } else {
            // 2. Lookup in static servers
            $staticServers = self::getStaticServers();

            if (isset($staticServers[$id])) {
                $server = $staticServers[$id];
            } else {
                // Try finding by name or fallback to first
                foreach ($staticServers as $item) {
                    if (strtolower($item['name']) === strtolower($id)) {
                        $server = $item;
                        break;
                    }
                }

                if (!$server) {
                    $server = $staticServers[1];
                }
            }

            // Check session like state for static server
            $isLiked = (bool) $request->session()->get("liked_server_{$server['id']}", false);
            $cachedLikesDelta = (int) Cache::get("server_likes_delta_{$server['id']}", 0);
            $server['likes'] = ($server['likes'] ?? 100) + $cachedLikesDelta;

            // Load comments from cache or default comments
            $cachedComments = Cache::get("server_comments_{$server['id']}", $server['default_comments'] ?? []);
            $comments = is_array($cachedComments) ? $cachedComments : [];
        }

        // Get related servers for "More Vibers You Might Like"
        $allStatic = self::getStaticServers();
        $relatedServers = array_filter($allStatic, function ($item) use ($server) {
            return $item['id'] != $server['id'];
        });

        return view('detail', [
            'server' => $server,
            'isLiked' => $isLiked,
            'comments' => $comments,
            'relatedServers' => array_values($relatedServers),
        ]);
    }

    /**
     * Handle liking and unliking a server.
     */
    public function like(Request $request, $id)
    {
        $user = User::find($id);
        $likerId = Auth::id() ? 'user_' . Auth::id() : 'session_' . $request->session()->getId();

        if ($user) {
            $likes = is_array($user->likes) ? $user->likes : [];

            if (in_array($likerId, $likes)) {
                // Unlike
                $likes = array_diff($likes, [$likerId]);
                $liked = false;
            } else {
                // Like
                $likes[] = $likerId;
                $liked = true;
            }

            $user->likes = array_values($likes);
            $user->save();

            $likesCount = count($user->likes);
        } else {
            // Static server handling
            $staticServers = self::getStaticServers();
            $baseServer = $staticServers[$id] ?? $staticServers[1];
            $sessionKey = "liked_server_{$baseServer['id']}";
            $deltaKey = "server_likes_delta_{$baseServer['id']}";

            $alreadyLiked = $request->session()->get($sessionKey, false);
            $delta = (int) Cache::get($deltaKey, 0);

            if ($alreadyLiked) {
                $request->session()->forget($sessionKey);
                $delta = max(0, $delta - 1);
                $liked = false;
            } else {
                $request->session()->put($sessionKey, true);
                $delta++;
                $liked = true;
            }

            Cache::forever($deltaKey, $delta);
            $likesCount = ($baseServer['likes'] ?? 100) + $delta;
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'liked' => $liked,
                'likes_count' => $likesCount,
            ]);
        }

        return back()->with('success', $liked ? 'Profile liked!' : 'Profile unliked.');
    }

    /**
     * Handle adding a comment to a server.
     */
    public function addComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|min:2|max:1000',
            'name' => 'nullable|string|max:80',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        $authorName = Auth::check()
            ? Auth::user()->name
            : ($request->filled('name') ? trim($request->input('name')) : 'Verified Visitor');

        $authorAvatar = Auth::check() ? Auth::user()->profile_image : null;
        $rating = (int) ($request->input('rating') ?? 5);

        $newComment = [
            'id' => (string) Str::uuid(),
            'user_id' => Auth::id(),
            'user_name' => $authorName,
            'user_avatar' => $authorAvatar,
            'rating' => $rating,
            'comment' => trim($request->input('comment')),
            'created_at' => now()->toIso8601String(),
            'formatted_date' => 'Just now',
        ];

        $user = User::find($id);

        if ($user) {
            $comments = is_array($user->comments) ? $user->comments : [];
            array_unshift($comments, $newComment);
            $user->comments = $comments;
            $user->save();

            $commentsCount = count($comments);
        } else {
            // Static server comment
            $staticServers = self::getStaticServers();
            $baseServer = $staticServers[$id] ?? $staticServers[1];
            $cacheKey = "server_comments_{$baseServer['id']}";

            $cachedComments = Cache::get($cacheKey, $baseServer['default_comments'] ?? []);
            if (!is_array($cachedComments)) {
                $cachedComments = [];
            }
            array_unshift($cachedComments, $newComment);
            Cache::forever($cacheKey, $cachedComments);

            $commentsCount = count($cachedComments);
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Comment posted successfully!',
                'comment' => $newComment,
                'comments_count' => $commentsCount,
            ]);
        }

        return back()->with('success', 'Comment posted successfully!');
    }
}
