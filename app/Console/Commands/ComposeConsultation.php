<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Domain\Ai\ConsultationComposer;
use App\Models\User;

class ComposeConsultation extends Command
{
    protected $signature = 'consult:compose {user_id} {theme} {question*}';
    protected $description = 'Compose consultation using Dify';

    public function handle(ConsultationComposer $composer): int
    {
        $userId = $this->argument('user_id');
        $theme = $this->argument('theme');
        $question = implode(' ', $this->argument('question'));

        $user = User::find($userId);
        if (!$user) {
            $this->error("User {$userId} not found");
            return 1;
        }

        $this->info("Composing consultation for user {$userId}, theme: {$theme}");
        $this->info("Question: {$question}");

        try {
            $result = $composer->compose($question, $user, $theme);
            
            $this->newLine();
            $this->info("Title: {$result['title']}");
            $this->newLine();
            $this->info("Message:");
            $this->line($result['message']);
            
        } catch (\Exception $e) {
            $this->error("Failed to compose consultation: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
