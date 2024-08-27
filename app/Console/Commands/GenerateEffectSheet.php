<?php

namespace App\Console\Commands;

use App\Models\Settings\Effect;
use Artisan;
use Illuminate\Console\Command;

class GenerateEffectSheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ges';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected string $cacheKey = 'settings-effects-count';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Generating CSS');
        $effectsQuery = Effect::query();

        foreach (config('extension.effects') as $effect) {
            $effectsQuery->firstOrCreate(['slug' => $effect['slug']], $effect);
        }

        $effectsCss = $effectsQuery
            ->get()
            ->reduce(fn (string $initial, Effect $effect) => sprintf('%s %s %s', $initial, $effect->raw_css, PHP_EOL), '');

        file_put_contents(storage_path('app/public/effects.css'), $effectsCss);

        Artisan::call('filament:assets');

        return self::SUCCESS;
    }
}
