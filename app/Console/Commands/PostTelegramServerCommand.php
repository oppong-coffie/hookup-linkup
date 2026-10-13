<?php

namespace App\Console\Commands;

use App\Http\Controllers\ServerController;
use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Console\Command;

class PostTelegramServerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:post-server {id? : User ID or static server ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post a server profile to the configured Telegram channel';

    /**
     * Execute the console command.
     */
    public function handle(TelegramService $telegramService): int
    {
        if (!$telegramService->isConfigured()) {
            $this->error('Telegram is not configured. Please ensure TELEGRAM_BOT_TOKEN and TELEGRAM_CHANNEL_ID are set in your .env file.');
            return Command::FAILURE;
        }

        $id = $this->argument('id');
        $server = null;

        if ($id) {
            $user = User::find($id);
            if ($user) {
                $server = $user;
            } else {
                $static = ServerController::getStaticServers();
                $server = $static[$id] ?? null;
            }
        } else {
            // Pick latest registered user if any, otherwise first featured server
            $user = User::latest()->first();
            if ($user) {
                $server = $user;
            } else {
                $static = ServerController::getStaticServers();
                $server = $static[1] ?? null;
            }
        }

        if (!$server) {
            $this->error("Server with ID [{$id}] not found.");
            return Command::FAILURE;
        }

        $name = $server instanceof User ? $server->name : ($server['name'] ?? 'Server');
        $this->info("Posting server [{$name}] to Telegram channel...");

        $success = $telegramService->postNewServer($server);

        if ($success) {
            $this->info("✅ Successfully posted [{$name}] to the Telegram channel!");
            return Command::SUCCESS;
        } else {
            $this->error("❌ Failed to post to Telegram. Check storage/logs/laravel.log for details.");
            $this->line("Tip: Make sure the bot is added as an Administrator to the channel with 'Post Messages' permission.");
            return Command::FAILURE;
        }
    }
}
