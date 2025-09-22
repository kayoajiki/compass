<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\Reading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatsController extends Controller
{
    public function index()
    {
        $stats = $this->getStatsData();
        return view('admin.stats.index', compact('stats'));
    }

    private function getStatsData()
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfYear = $now->copy()->startOfYear();
        $lastMonth = $now->copy()->subMonth();
        $lastMonthStart = $lastMonth->copy()->startOfMonth();
        $lastMonthEnd = $lastMonth->copy()->endOfMonth();

        return [
            // 基本統計
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total_cents'),
            
            // 今月の統計
            'monthly_revenue' => Order::where('status', '!=', 'cancelled')
                ->where('created_at', '>=', $startOfMonth)
                ->sum('total_cents'),
            'monthly_orders' => Order::where('created_at', '>=', $startOfMonth)->count(),
            'monthly_new_users' => User::where('created_at', '>=', $startOfMonth)->count(),
            
            // 先月の統計（比較用）
            'last_month_revenue' => Order::where('status', '!=', 'cancelled')
                ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
                ->sum('total_cents'),
            'last_month_orders' => Order::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count(),
            'last_month_new_users' => User::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count(),
            
            // 商品別売上
            'top_products' => $this->getTopProducts(),
            
            // 注文ステータス別統計
            'order_status_stats' => $this->getOrderStatusStats(),
            
            // 月別売上推移（過去12ヶ月）
            'monthly_revenue_chart' => $this->getMonthlyRevenueChart(),
            
            // 日別売上推移（過去30日）
            'daily_revenue_chart' => $this->getDailyRevenueChart(),
            
            // 商品タイプ別統計
            'product_type_stats' => $this->getProductTypeStats(),
            
            // 最近の注文
            'recent_orders' => Order::with(['user', 'orderItems.product'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get(),
            
            // 売上成長率
            'revenue_growth' => $this->calculateGrowthRate(
                Order::where('status', '!=', 'cancelled')
                    ->where('created_at', '>=', $startOfMonth)
                    ->sum('total_cents'),
                Order::where('status', '!=', 'cancelled')
                    ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
                    ->sum('total_cents')
            ),
            
            // 注文成長率
            'orders_growth' => $this->calculateGrowthRate(
                Order::where('created_at', '>=', $startOfMonth)->count(),
                Order::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count()
            ),
            
            // ユーザー成長率
            'users_growth' => $this->calculateGrowthRate(
                User::where('created_at', '>=', $startOfMonth)->count(),
                User::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count()
            ),
        ];
    }

    private function getTopProducts()
    {
        return OrderItem::with('product')
            ->select('product_id', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(subtotal_cents) as total_revenue'))
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', '!=', 'cancelled')
            ->where('orders.created_at', '>=', Carbon::now()->subMonths(3))
            ->groupBy('product_id')
            ->orderBy('total_revenue', 'desc')
            ->limit(10)
            ->get();
    }

    private function getOrderStatusStats()
    {
        return Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();
    }

    private function getMonthlyRevenueChart()
    {
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $startOfMonth = $month->copy()->startOfMonth();
            $endOfMonth = $month->copy()->endOfMonth();
            
            $revenue = Order::where('status', '!=', 'cancelled')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->sum('total_cents');
            
            $data[] = [
                'month' => $month->format('Y-m'),
                'label' => $month->format('Y年n月'),
                'revenue' => $revenue / 100,
            ];
        }
        
        return $data;
    }

    private function getDailyRevenueChart()
    {
        $data = [];
        for ($i = 29; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i);
            $startOfDay = $day->copy()->startOfDay();
            $endOfDay = $day->copy()->endOfDay();
            
            $revenue = Order::where('status', '!=', 'cancelled')
                ->whereBetween('created_at', [$startOfDay, $endOfDay])
                ->sum('total_cents');
            
            $data[] = [
                'date' => $day->format('Y-m-d'),
                'label' => $day->format('n月j日'),
                'revenue' => $revenue / 100,
            ];
        }
        
        return $data;
    }

    private function getProductTypeStats()
    {
        return OrderItem::with('product')
            ->select('products.type', DB::raw('SUM(order_items.subtotal_cents) as total_revenue'), DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', '!=', 'cancelled')
            ->where('orders.created_at', '>=', Carbon::now()->subMonths(3))
            ->groupBy('products.type')
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                    $item->type => [
                        'revenue' => $item->total_revenue / 100,
                        'quantity' => $item->total_quantity,
                    ]
                ];
            });
    }

    private function calculateGrowthRate($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        
        return round((($current - $previous) / $previous) * 100, 1);
    }

    public function getChartData(Request $request)
    {
        $type = $request->get('type', 'monthly');
        
        switch ($type) {
            case 'monthly':
                return response()->json($this->getMonthlyRevenueChart());
            case 'daily':
                return response()->json($this->getDailyRevenueChart());
            case 'product_types':
                return response()->json($this->getProductTypeStats());
            default:
                return response()->json([]);
        }
    }
}
