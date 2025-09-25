<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your profile information for accurate astrology readings')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <!-- 基本情報 -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">基本情報</h3>
                
                <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

                <div>
                    <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                    @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                        <div>
                            <flux:text class="mt-4">
                                {{ __('Your email address is unverified.') }}

                                <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                    {{ __('Click here to re-send the verification email.') }}
                                </flux:link>
                            </flux:text>

                            @if (session('status') === 'verification-link-sent')
                                <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </flux:text>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- 四柱推命用情報 -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">四柱推命用情報</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    正確な四柱推命の鑑定を行うために、以下の情報が必要です。
                </p>

                <flux:input wire:model="birth_date" :label="__('Birth Date')" type="date" required />

                <flux:input wire:model="birth_time" :label="__('Birth Time')" type="time" />

                <div>
                    <flux:select wire:model="birth_place_pref" :label="__('Birth Place')" required>
                        <option value="">都道府県を選択してください</option>
                        @foreach($this->getPrefectures() as $code => $name)
                            <option value="{{ $code }}">{{ $name }}</option>
                        @endforeach
                    </flux:select>
                </div>

                <div>
                    <flux:select wire:model="sex" :label="__('Sex')" required>
                        <option value="male">男性</option>
                        <option value="female">女性</option>
                    </flux:select>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>