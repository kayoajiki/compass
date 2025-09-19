<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class PersonSwitcher extends Component
{
    public bool $showSwitcher;
    public array $persons;
    public ?int $selectedPersonId;

    /**
     * Create a new component instance.
     */
    public function __construct(?int $selectedPersonId = null)
    {
        $this->selectedPersonId = $selectedPersonId;
        
        // サブスクリプション会員のみ表示
        $this->showSwitcher = auth()->check() && auth()->user()->hasActiveSubscription();
        
        // モックデータ：後でpersonsテーブルから取得するように変更
        $this->persons = [
            [
                'id' => null,
                'name' => auth()->user()?->name ?? '本人',
                'is_self' => true
            ],
            [
                'id' => 1,
                'name' => '田中 花子',
                'is_self' => false
            ],
            [
                'id' => 2,
                'name' => '佐藤 太郎',
                'is_self' => false
            ],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.person-switcher');
    }
}