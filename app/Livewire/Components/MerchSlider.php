<?php

namespace App\Livewire\Components;

use App\Models\Product;
use Livewire\Component;

class MerchSlider extends Component
{
    public $products;
    public $currentIndex = 0;
    public $autoPlay = true;
    public $autoPlayInterval = 5000; // 5秒

    public function mount()
    {
        // 物販商品を取得（在庫あり、アクティブなもののみ）
        // 人気度スコアでソートし、上位商品を優先表示
        $products = Product::active()
            ->byType('physical')
            ->where('stock', '>', 0)
            ->get()
            ->map(function ($product) {
                $metadata = $product->metadata ?? [];
                $product->popularity_score = $metadata['popularity_score'] ?? 0;
                return $product;
            })
            ->sortByDesc('popularity_score')
            ->take(8)
            ->values()
            ->toArray();

        $this->products = $products;
    }

    public function next()
    {
        if (count($this->products) > 1) {
            $this->currentIndex = ($this->currentIndex + 1) % count($this->products);
        }
    }

    public function previous()
    {
        if (count($this->products) > 1) {
            $this->currentIndex = $this->currentIndex === 0 
                ? count($this->products) - 1 
                : $this->currentIndex - 1;
        }
    }

    public function goToSlide($index)
    {
        if ($index >= 0 && $index < count($this->products)) {
            $this->currentIndex = $index;
        }
    }

    public function render()
    {
        return view('livewire.components.merch-slider');
    }
}
