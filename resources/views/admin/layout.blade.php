<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '管理画面') - FortuneCompass</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- ヘッダー -->
        <nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="text-xl font-semibold text-gray-900">
                            FortuneCompass 管理画面
                        </a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-700">管理者: {{ Auth::guard('admin')->user()->name }}</span>
                        <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-red-600 hover:text-red-800">
                                ログアウト
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex">
            <!-- サイドバー -->
            <div class="hidden md:flex md:w-64 md:flex-col">
                <div class="flex flex-col flex-grow pt-5 bg-white overflow-y-auto border-r border-gray-200">
                    <div class="flex flex-col flex-grow mt-5">
                        <nav class="flex-1 px-2 space-y-1">
                            <a href="{{ route('admin.dashboard') }}" 
                               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                <span class="mr-3">📊</span>
                                ダッシュボード
                            </a>
                            
                            <a href="{{ route('admin.products.index') }}" 
                               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.products.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                <span class="mr-3">🛍️</span>
                                商品管理
                            </a>
                            
                            <a href="{{ route('admin.users.index') }}" 
                               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.users.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                <span class="mr-3">👥</span>
                                ユーザー管理
                            </a>
                            
                            <a href="#" 
                               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                                <span class="mr-3">📦</span>
                                注文管理
                            </a>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- メインコンテンツ -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <main class="flex-1 relative overflow-y-auto focus:outline-none">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</body>
</html>
