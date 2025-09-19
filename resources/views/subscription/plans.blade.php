<x-layouts.app :title="'料金プラン - FortuneCompass'">
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="text-center mb-16">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    多角占術で"いま"が分かる
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 mb-8">
                    四柱推命、紫微斗数、西洋占星術、数秘術を組み合わせた<br>
                    精度の高い占い結果をお届けします
                </p>
                @auth
                    @if(auth()->user()->hasActiveSubscription())
                        <div class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-lg">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            {{ auth()->user()->getSubscriptionDisplayName() }}にご加入中
                        </div>
                    @endif
                @endauth
            </div>

            <!-- Pricing Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16" id="plans">
                <!-- Free Plan -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8">
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">無料プラン</h3>
                        <div class="mb-6">
                            <span class="text-4xl font-bold text-gray-900 dark:text-white">¥0</span>
                            <span class="text-gray-600 dark:text-gray-400">/月</span>
                        </div>
                        <ul class="space-y-3 mb-8">
                            @foreach($freeFeatures as $feature)
                                <li class="flex items-center text-gray-600 dark:text-gray-300">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>
                        @auth
                            <a href="{{ route('dashboard') }}" class="w-full bg-gray-100 text-gray-900 py-3 px-6 rounded-lg font-medium inline-block text-center">
                                ダッシュボードへ
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="w-full bg-gray-100 text-gray-900 py-3 px-6 rounded-lg font-medium inline-block text-center">
                                無料で始める
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Monthly Plan -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border-2 border-purple-200 dark:border-purple-700 p-8 relative">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                        <span class="bg-purple-600 text-white px-4 py-1 rounded-full text-sm font-medium">人気</span>
                    </div>
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">月額プラン</h3>
                        <div class="mb-6">
                            <span class="text-4xl font-bold text-purple-600">¥{{ number_format($plans['monthly']['price']) }}</span>
                            <span class="text-gray-600 dark:text-gray-400">/月</span>
                        </div>
                        <ul class="space-y-3 mb-8">
                            @foreach($subscriptionFeatures as $feature)
                                <li class="flex items-center text-gray-600 dark:text-gray-300">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>
                        @auth
                            @if(auth()->user()->hasActiveSubscription())
                                <div class="w-full bg-green-100 text-green-800 py-3 px-6 rounded-lg font-medium text-center">
                                    ご加入済み
                                </div>
                            @else
                                <form method="POST" action="{{ route('subscription.checkout') }}" class="w-full">
                                    @csrf
                                    <input type="hidden" name="plan" value="monthly">
                                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 px-6 rounded-lg font-medium">
                                        月額で始める
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('register') }}" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 px-6 rounded-lg font-medium inline-block text-center">
                                月額で始める
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Yearly Plan -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8">
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">年額プラン</h3>
                        <div class="mb-2">
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm font-medium">{{ $plans['yearly']['note'] }}</span>
                        </div>
                        <div class="mb-6">
                            <span class="text-4xl font-bold text-gray-900 dark:text-white">¥{{ number_format($plans['yearly']['price']) }}</span>
                            <span class="text-gray-600 dark:text-gray-400">/年</span>
                        </div>
                        <ul class="space-y-3 mb-8">
                            @foreach($plans['yearly']['features'] as $feature)
                                <li class="flex items-center text-gray-600 dark:text-gray-300">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>
                        @auth
                            @if(auth()->user()->hasActiveSubscription())
                                <div class="w-full bg-green-100 text-green-800 py-3 px-6 rounded-lg font-medium text-center">
                                    ご加入済み
                                </div>
                            @else
                                <form method="POST" action="{{ route('subscription.checkout') }}" class="w-full">
                                    @csrf
                                    <input type="hidden" name="plan" value="yearly">
                                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 px-6 rounded-lg font-medium">
                                        年額で始める
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('register') }}" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 px-6 rounded-lg font-medium inline-block text-center">
                                年額で始める
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-8">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white text-center mb-12">よくある質問</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">請求・解約について</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">
                            月額プランは毎月自動更新されます。年額プランは1年ごとに自動更新されます。いつでも解約可能で、解約後は現在の期間が終了するまでサービスをご利用いただけます。
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">返金について</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">
                            初回決済から30日以内であれば、全額返金いたします。返金をご希望の場合は、サポートまでお問い合わせください。
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">請求書について</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">
                            請求書は自動的にメールでお送りします。法人でのご利用の場合は、別途請求書発行サービスをご利用いただけます。
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">支払い方法について</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">
                            クレジットカード（Visa、Mastercard、JCB）でのお支払いに対応しています。決済はStripeを通じて安全に処理されます。
                        </p>
                    </div>
                </div>
            </div>

            @auth
                @if(auth()->user()->hasActiveSubscription())
                    <!-- Subscription Management -->
                    <div class="mt-12 text-center">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">サブスクリプション管理</h2>
                        <div class="space-y-4">
                            @if(auth()->user()->subscription('default')?->onGracePeriod())
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                                    <p class="text-yellow-800">
                                        サブスクリプションはキャンセルされていますが、{{ auth()->user()->subscription('default')->ends_at->format('Y年m月d日') }}まではサービスをご利用いただけます。
                                    </p>
                                    <form method="POST" action="{{ route('subscription.resume') }}" class="mt-3">
                                        @csrf
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                                            サブスクリプションを再開
                                        </button>
                                    </form>
                                </div>
                            @else
                                <form method="POST" action="{{ route('subscription.cancel') }}" class="inline-block">
                                    @csrf
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg" onclick="return confirm('サブスクリプションをキャンセルしますか？')">
                                        サブスクリプションをキャンセル
                                    </button>
                                </form>
                            @endif
                            <div>
                                <a href="{{ route('subscription.portal') }}" class="text-purple-600 hover:text-purple-500 underline">
                                    請求情報・支払い方法を管理
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</x-layouts.app>
