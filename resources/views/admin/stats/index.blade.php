@extends('admin.layout')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold text-gray-900">統計ダッシュボード</h1>
            <p class="mt-2 text-sm text-gray-700">売上、ユーザー数、注文数などの統計情報を表示します。</p>
        </div>
    </div>

    <!-- 主要KPIカード -->
    <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <!-- 総売上 -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                            <span class="text-white text-sm font-medium">¥</span>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">総売上</dt>
                            <dd class="text-lg font-medium text-gray-900">¥{{ number_format($stats['total_revenue'] / 100) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- 今月の売上 -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                            <span class="text-white text-sm font-medium">📈</span>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">今月の売上</dt>
                            <dd class="text-lg font-medium text-gray-900">¥{{ number_format($stats['monthly_revenue'] / 100) }}</dd>
                            <dd class="text-sm text-gray-500">
                                @if($stats['revenue_growth'] > 0)
                                    <span class="text-green-600">+{{ $stats['revenue_growth'] }}%</span>
                                @elseif($stats['revenue_growth'] < 0)
                                    <span class="text-red-600">{{ $stats['revenue_growth'] }}%</span>
                                @else
                                    <span class="text-gray-500">0%</span>
                                @endif
                                前月比
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- 総ユーザー数 -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                            <span class="text-white text-sm font-medium">👥</span>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">総ユーザー数</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['total_users']) }}</dd>
                            <dd class="text-sm text-gray-500">
                                今月: +{{ number_format($stats['monthly_new_users']) }}人
                                @if($stats['users_growth'] > 0)
                                    <span class="text-green-600">(+{{ $stats['users_growth'] }}%)</span>
                                @elseif($stats['users_growth'] < 0)
                                    <span class="text-red-600">({{ $stats['users_growth'] }}%)</span>
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- 総注文数 -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                            <span class="text-white text-sm font-medium">📦</span>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">総注文数</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['total_orders']) }}</dd>
                            <dd class="text-sm text-gray-500">
                                今月: {{ number_format($stats['monthly_orders']) }}件
                                @if($stats['orders_growth'] > 0)
                                    <span class="text-green-600">(+{{ $stats['orders_growth'] }}%)</span>
                                @elseif($stats['orders_growth'] < 0)
                                    <span class="text-red-600">({{ $stats['orders_growth'] }}%)</span>
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- チャートセクション -->
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- 月別売上推移 -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">月別売上推移（過去12ヶ月）</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">月別の売上推移を表示しています。</p>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <canvas id="monthlyRevenueChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- 商品タイプ別売上 -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">商品タイプ別売上（過去3ヶ月）</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">商品タイプ別の売上構成を表示しています。</p>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <canvas id="productTypeChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- 注文ステータス別統計 -->
    <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">注文ステータス別統計</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">注文のステータス別の件数を表示しています。</p>
        </div>
        <div class="border-t border-gray-200">
            <div class="px-4 py-5 sm:px-6">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    @foreach([
                        'pending' => ['label' => '待機中', 'color' => 'bg-yellow-100 text-yellow-800'],
                        'processing' => ['label' => '処理中', 'color' => 'bg-blue-100 text-blue-800'],
                        'shipped' => ['label' => '発送済み', 'color' => 'bg-purple-100 text-purple-800'],
                        'delivered' => ['label' => '配送完了', 'color' => 'bg-green-100 text-green-800'],
                        'cancelled' => ['label' => 'キャンセル', 'color' => 'bg-red-100 text-red-800'],
                        'refunded' => ['label' => '返金済み', 'color' => 'bg-gray-100 text-gray-800'],
                    ] as $status => $config)
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">
                                {{ $stats['order_status_stats'][$status] ?? 0 }}
                            </div>
                            <div class="text-sm text-gray-500">{{ $config['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- 人気商品ランキング -->
    <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">人気商品ランキング（過去3ヶ月）</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">売上金額順の商品ランキングを表示しています。</p>
        </div>
        <div class="border-t border-gray-200">
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">順位</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">商品名</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">売上数量</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">売上金額</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($stats['top_products'] as $index => $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $item->product->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($item->total_quantity) }}個
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ¥{{ number_format($item->total_revenue / 100) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    データがありません。
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 最近の注文 -->
    <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">最近の注文</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">最新の注文情報を表示しています。</p>
        </div>
        <div class="border-t border-gray-200">
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">注文ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">顧客</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">金額</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ステータス</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">注文日</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($stats['recent_orders'] as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $order->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $order->user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ¥{{ number_format($order->total_cents / 100) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                                        @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                        @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                        @elseif($order->status === 'refunded') bg-gray-100 text-gray-800
                                        @endif">
                                        @switch($order->status)
                                            @case('pending') 待機中 @break
                                            @case('processing') 処理中 @break
                                            @case('shipped') 発送済み @break
                                            @case('delivered') 配送完了 @break
                                            @case('cancelled') キャンセル @break
                                            @case('refunded') 返金済み @break
                                            @default {{ $order->status }}
                                        @endswitch
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $order->created_at->format('Y年m月d日') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    注文がありません。
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// 月別売上推移チャート
const monthlyCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
const monthlyData = @json($stats['monthly_revenue_chart']);

new Chart(monthlyCtx, {
    type: 'line',
    data: {
        labels: monthlyData.map(item => item.label),
        datasets: [{
            label: '売上（円）',
            data: monthlyData.map(item => item.revenue),
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '¥' + value.toLocaleString();
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return '売上: ¥' + context.parsed.y.toLocaleString();
                    }
                }
            }
        }
    }
});

// 商品タイプ別売上チャート
const productTypeCtx = document.getElementById('productTypeChart').getContext('2d');
const productTypeData = @json($stats['product_type_stats']);

const typeLabels = {
    'physical': '物販',
    'digital': 'デジタル',
    'service': 'サービス'
};

new Chart(productTypeCtx, {
    type: 'doughnut',
    data: {
        labels: Object.keys(productTypeData).map(type => typeLabels[type] || type),
        datasets: [{
            data: Object.values(productTypeData).map(item => item.revenue),
            backgroundColor: [
                'rgb(59, 130, 246)',
                'rgb(16, 185, 129)',
                'rgb(245, 158, 11)'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.label + ': ¥' + context.parsed.toLocaleString();
                    }
                }
            }
        }
    }
});
</script>
@endsection
