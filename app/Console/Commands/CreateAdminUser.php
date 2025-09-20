<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create-user';
    protected $description = 'Create an admin user for the Filament panel';

    public function handle()
    {
        $name = $this->ask('管理者名を入力してください', 'Admin');
        $email = $this->ask('メールアドレスを入力してください');
        $password = $this->secret('パスワードを入力してください');

        if (User::where('email', $email)->exists()) {
            $this->error('このメールアドレスのユーザーは既に存在します。');
            return 1;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]);

        $this->info("管理者ユーザーが作成されました: {$user->name} ({$user->email})");
        $this->info("管理パネル: http://localhost:8000/admin");

        return 0;
    }
}