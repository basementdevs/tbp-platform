<?php

namespace App\Console\Commands;

use App\Clients\Consumer\ConsumerClient;
use App\Models\User;
use Illuminate\Console\Command;

class SyncSettingsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(ConsumerClient $client)
    {
        foreach (User::all() as $user) {
            $settings = $user->settings()->with('occupation', 'color', 'effect')->get();
            foreach ($settings as $setting) {
                $client->updateUser($user, $setting);
            }
        }
    }
}
