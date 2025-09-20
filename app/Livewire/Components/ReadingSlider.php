<?php

namespace App\Livewire\Components;

use App\Models\Product;
use Livewire\Component;

class ReadingSlider extends Component
{
    public $products;
    public $currentIndex = 0;
    public $autoPlay = true;
    public $autoPlayInterval = 6000; // 6秒（鑑定は少し長めに）

    public function mount()
    {
        // 鑑定商品を取得（アクティブなもののみ）
        $this->products = Product::active()
            ->byType('service')
            ->orderBy('created_at', 'desc')
            ->take(4) // 4つの鑑定方法
            ->get()
            ->toArray();
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
        return view('livewire.components.reading-slider');
    }
}
