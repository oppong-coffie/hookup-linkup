<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected ?string $botToken;
    protected ?string $channelId;
    protected string $apiUrl;

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token');
        $this->channelId = config('services.telegram.channel_id');
        $this->apiUrl = "https://api.telegram.org/bot{$this->botToken}";
    }

    /**
     * Check if Telegram is configured.
     */
    public function isConfigured(): bool
    {
        return !empty($this->botToken) && !empty($this->channelId);
    }

    /**
     * Broadcast a new server profile to the Telegram channel.
     *
     * @param User|array $server
     * @return bool
     */
    public function postNewServer(User|array $server): bool
    {
        if (!$this->isConfigured()) {
            Log::warning('TelegramService: bot_token or channel_id is missing in config/services.php');
            return false;
        }

        // Normalize server data
        if ($server instanceof User) {
            $name = $server->name;
            $location = $server->location ?: 'Accra, Ghana';
            $age = $server->age ?: '24';
            $photo = $server->profile_image;
            $profileUrl = url('/detail/' . $server->id);
        } else {
            $name = $server['name'] ?? 'New Member';
            $location = $server['location'] ?? 'Accra';
            $age = $server['age'] ?? '24';
            $photo = $server['profile_image'] ?? ($server['image'] ?? null);
            $profileUrl = isset($server['id']) ? url('/detail/' . $server['id']) : url('/');
        }

        // Clean values for HTML
        $safeName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        $safeLocation = htmlspecialchars($location, ENT_QUOTES, 'UTF-8');
        $safeAge = htmlspecialchars((string) $age, ENT_QUOTES, 'UTF-8');

        // Prepare message body matching exact user format
        $text = "🔥 <b>New Server Available</b>\n\n"
              . "<b>Name:</b> {$safeName}\n"
              . "<b>Location:</b> {$safeLocation}\n"
              . "<b>Age:</b> {$safeAge}\n\n"
              . "<a href=\"{$profileUrl}\">View Profile</a>";

        // Prepare inline button: [ View Profile ]
        $replyMarkup = [
            'inline_keyboard' => [
                [
                    [
                        'text' => '🔥 View Profile',
                        'url'  => $profileUrl,
                    ],
                ],
            ],
        ];

        // 1. Try sending with photo if photo is a valid public HTTP/HTTPS URL
        if ($photo && (str_starts_with($photo, 'http://') || str_starts_with($photo, 'https://'))) {
            try {
                $photoResponse = Http::timeout(10)->post("{$this->apiUrl}/sendPhoto", [
                    'chat_id'      => $this->channelId,
                    'photo'        => $photo,
                    'caption'      => $text,
                    'parse_mode'   => 'HTML',
                    'reply_markup' => json_encode($replyMarkup),
                ]);

                if ($photoResponse->successful()) {
                    Log::info('TelegramService: Successfully posted new server with photo to channel', [
                        'server_name' => $name,
                        'channel_id'  => $this->channelId,
                    ]);
                    return true;
                }

                Log::warning('TelegramService: sendPhoto failed, falling back to sendMessage', [
                    'status'   => $photoResponse->status(),
                    'response' => $photoResponse->json(),
                ]);
            } catch (\Throwable $e) {
                Log::warning('TelegramService: sendPhoto exception, falling back to sendMessage: ' . $e->getMessage());
            }
        }

        // 2. Fallback or text-only message
        try {
            $response = Http::timeout(10)->post("{$this->apiUrl}/sendMessage", [
                'chat_id'      => $this->channelId,
                'text'         => $text,
                'parse_mode'   => 'HTML',
                'reply_markup' => json_encode($replyMarkup),
            ]);

            if ($response->successful()) {
                Log::info('TelegramService: Successfully posted new server message to channel', [
                    'server_name' => $name,
                    'channel_id'  => $this->channelId,
                ]);
                return true;
            }

            Log::error('TelegramService: sendMessage failed', [
                'status'   => $response->status(),
                'response' => $response->json(),
            ]);

            return false;
        } catch (\Throwable $e) {
            Log::error('TelegramService: Exception while sending message: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send a custom text message to the channel.
     */
    public function sendMessage(string $text, ?array $replyMarkup = null): bool
    {
        if (!$this->isConfigured()) {
            return false;
        }

        try {
            $payload = [
                'chat_id'    => $this->channelId,
                'text'       => $text,
                'parse_mode' => 'HTML',
            ];

            if ($replyMarkup) {
                $payload['reply_markup'] = json_encode($replyMarkup);
            }

            $response = Http::timeout(10)->post("{$this->apiUrl}/sendMessage", $payload);
            return $response->successful();
        } catch (\Throwable $e) {
            Log::error('TelegramService: ' . $e->getMessage());
            return false;
        }
    }
}
