<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\SupabaseStorageService;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(
        protected SupabaseStorageService $supabaseStorage,
        protected TelegramService $telegramService,
    ) {}

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'accepted',
            'phone' => 'nullable|string|max:20',
            'age' => 'nullable|integer|min:18|max:99',
            'bio' => 'nullable|string|max:500',
            'location' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'age' => $request->filled('age') ? (int) $request->age : 24,
            'bio' => $request->bio,
            'location' => $request->location,
        ];

        // Upload profile image to Supabase Storage
        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $this->supabaseStorage->upload(
                $request->file('profile_image'),
                'profile-images'
            );
        }

        // Upload gallery images to Supabase Storage
        if ($request->hasFile('gallery')) {
            $galleryUrls = [];
            foreach ($request->file('gallery') as $galleryFile) {
                $galleryUrls[] = $this->supabaseStorage->upload($galleryFile, 'gallery');
            }
            $data['gallery'] = $galleryUrls;
        }

        $user = User::create($data);

        // Automatically post to Telegram channel
        $this->telegramService->postNewServer($user);

        Auth::login($user);

        return redirect('/portal');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/portal');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'location' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = Auth::user();

        $user->fill($request->only(['name', 'phone', 'bio', 'location']));

        if ($request->hasFile('profile_image')) {
            // Delete old image from Supabase if it exists
            if ($user->profile_image) {
                $this->supabaseStorage->delete($user->profile_image);
            }

            $user->profile_image = $this->supabaseStorage->upload(
                $request->file('profile_image'),
                'profile-images'
            );
        }

        $user->save();

        return redirect('/portal/edit')->with('success', 'Profile updated successfully!');
    }

    // Add photo to gallery
    public function updateGallery(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $user = Auth::user();

        // Upload photo to Supabase storage in 'gallery' folder
        $photoUrl = $this->supabaseStorage->upload($request->file('photo'), 'gallery');

        // Add new photo URL to user's gallery array
        $gallery = is_array($user->gallery) ? $user->gallery : [];
        $gallery[] = $photoUrl;
        $user->gallery = array_values($gallery);
        $user->save();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Photo uploaded successfully.',
                'photo'   => $photoUrl,
                'gallery' => $user->gallery,
            ]);
        }

        return redirect('/portal')->with('success', 'Photo added to gallery successfully!');
    }

    // Remove photo from gallery
    public function deleteGallery(Request $request)
    {
        $request->validate([
            'photo' => 'required|string',
        ]);

        $user = Auth::user();
        $gallery = is_array($user->gallery) ? $user->gallery : [];
        $photoToDelete = $request->input('photo');

        if (($key = array_search($photoToDelete, $gallery)) !== false) {
            unset($gallery[$key]);
            $user->gallery = array_values($gallery);
            $user->save();

            // Delete from Supabase storage
            $this->supabaseStorage->delete($photoToDelete);
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Photo removed successfully.',
                'gallery' => $user->gallery,
            ]);
        }

        return redirect('/portal')->with('success', 'Photo removed successfully.');
    }
}
