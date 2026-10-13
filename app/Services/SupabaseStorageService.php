<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SupabaseStorageService
{
    protected string $url;
    protected string $key;
    protected string $bucket;

    public function __construct()
    {
        $this->url = config('services.supabase.url');
        $this->key = config('services.supabase.key');
        $this->bucket = config('services.supabase.bucket');
    }

    /**
     * Upload a file to Supabase Storage and return the public URL.
     */
    public function upload(UploadedFile $file, string $folder = 'profile-images'): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = $folder . '/' . Str::uuid() . '.' . $extension;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->key,
            'Content-Type'  => $file->getMimeType(),
        ])->withBody(
            file_get_contents($file->getRealPath()),
            $file->getMimeType()
        )->post("{$this->url}/storage/v1/object/{$this->bucket}/{$filename}");

        if ($response->failed()) {
            Log::error('Supabase upload failed', [
                'status'   => $response->status(),
                'response' => $response->json(),
            ]);

            throw new \RuntimeException('Failed to upload file to Supabase Storage.');
        }

        // Return the public URL
        return "{$this->url}/storage/v1/object/public/{$this->bucket}/{$filename}";
    }

    /**
     * Delete a file from Supabase Storage by its public URL.
     */
    public function delete(string $publicUrl): bool
    {
        // Extract the file path from the public URL
        $prefix = "{$this->url}/storage/v1/object/public/{$this->bucket}/";

        if (! str_starts_with($publicUrl, $prefix)) {
            return false;
        }

        $filePath = str_replace($prefix, '', $publicUrl);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->key,
        ])->delete("{$this->url}/storage/v1/object/{$this->bucket}", [
            'prefixes' => [$filePath],
        ]);

        if ($response->failed()) {
            Log::warning('Supabase delete failed', [
                'status'   => $response->status(),
                'response' => $response->json(),
                'path'     => $filePath,
            ]);

            return false;
        }

        return true;
    }
}
