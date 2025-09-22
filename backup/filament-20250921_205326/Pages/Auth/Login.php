<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getRememberFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    public function authenticate(): ?LoginResponse
    {
        try {
            // CSRFトークンの問題を回避するため、直接認証を実行
            $credentials = $this->form->getState();
            
            if (!auth()->attempt([
                'email' => $credentials['email'],
                'password' => $credentials['password'],
            ], $credentials['remember'] ?? false)) {
                throw ValidationException::withMessages([
                    'data.email' => '認証に失敗しました。',
                ]);
            }
            
            // 管理者権限チェック
            if (!auth()->user()->isAdmin()) {
                auth()->logout();
                throw ValidationException::withMessages([
                    'data.email' => '管理者権限が必要です。',
                ]);
            }
            
            session()->regenerate();
            
            return app(LoginResponse::class);
            
        } catch (ValidationException $e) {
            throw $e;
        }
    }
}
