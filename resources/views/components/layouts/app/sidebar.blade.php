<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            body {
                font-family: 'Hiragino Sans', 'Yu Gothic', 'Meiryo', 'Noto Sans JP', ui-sans-serif, system-ui, sans-serif;
                line-height: 1.6;
            }
            svg {
                display: inline-block;
                vertical-align: middle;
                max-width: 100%;
                height: auto;
            }
            .w-5 {
                width: 1.25rem !important;
                height: 1.25rem !important;
            }
            .w-6 {
                width: 1.5rem !important;
                height: 1.5rem !important;
            }
            .w-8 {
                width: 2rem !important;
                height: 2rem !important;
            }
            .h-5 {
                height: 1.25rem !important;
            }
            .h-6 {
                height: 1.5rem !important;
            }
            .h-8 {
                height: 2rem !important;
            }
        </style>
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <div class="flex h-screen">
            <!-- Sidebar -->
            <div class="hidden lg:flex lg:w-64 lg:flex-col lg:fixed lg:inset-y-0">
                <div class="flex flex-col flex-grow pt-5 bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
                    <!-- Logo -->
                    <div class="flex items-center flex-shrink-0 px-4 mb-8">
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2" wire:navigate>
                            <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-sm">FC</span>
                            </div>
                            <span class="text-xl font-bold text-gray-900 dark:text-white">FortuneCompass</span>
                        </a>
                    </div>

                    <!-- Navigation -->
                    <nav class="flex-1 px-4 space-y-2">
                        <div class="space-y-1">
                            <h3 class="px-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Platform</h3>
                            <a href="{{ route('dashboard') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dashboard') ? 'bg-purple-100 text-purple-900 dark:bg-purple-900 dark:text-purple-100' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}" wire:navigate>
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                                </svg>
                                だっしゅぼーど
                            </a>
                            <a href="{{ route('profile.edit') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('profile.edit') ? 'bg-purple-100 text-purple-900 dark:bg-purple-900 dark:text-purple-100' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}" wire:navigate>
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                プロフィール設定
                            </a>
                            <a href="{{ route('calendar.chart') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('calendar.*') ? 'bg-purple-100 text-purple-900 dark:bg-purple-900 dark:text-purple-100' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}" wire:navigate>
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                運勢カレンダー
                            </a>
                            <a href="{{ route('compatibility.chart') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('compatibility.*') ? 'bg-purple-100 text-purple-900 dark:bg-purple-900 dark:text-purple-100' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}" wire:navigate>
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                相性占い
                            </a>
                        </div>
                    </nav>

                    <!-- User Menu -->
                    <div class="flex-shrink-0 p-4 border-t border-zinc-200 dark:border-zinc-700">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-medium">{{ auth()->user()->initials() }}</span>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:pl-64 flex flex-col flex-1">
                <!-- Mobile header -->
                <div class="lg:hidden flex items-center justify-between px-4 py-2 bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">FC</span>
                        </div>
                        <span class="ml-2 text-lg font-bold text-gray-900 dark:text-white">FortuneCompass</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-medium">{{ auth()->user()->initials() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Page Content -->
                <main class="flex-1">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
