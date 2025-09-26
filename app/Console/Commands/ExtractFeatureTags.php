<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Domain\Features\FeatureTagService;
use App\Models\User;

class ExtractFeatureTags extends Command
{
    protected $signature = 'features:extract {theme} {--user_id=}';
    protected $description = 'Extract feature tags for a theme';

    public function handle(FeatureTagService $featureTagService): int
    {
        $theme = $this->argument('theme');
        $userId = $this->option('user_id');

        if ($userId) {
            $user = User::find($userId);
            if (!$user) {
                $this->error("User {$userId} not found");
                return 1;
            }
            $users = collect([$user]);
        } else {
            $users = User::all();
        }

        $this->info("Extracting feature tags for theme: {$theme}");
        $bar = $this->output->createProgressBar($users->count());

        foreach ($users as $user) {
            try {
                $featureTagService->extractForTheme($user->id, $theme);
                $bar->advance();
            } catch (\Exception $e) {
                $this->error("Failed for user {$user->id}: " . $e->getMessage());
            }
        }

        $bar->finish();
        $this->newLine();
        $this->info('Feature tags extraction completed');

        return 0;
    }
}
