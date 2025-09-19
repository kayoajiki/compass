<?php

namespace App\Domain\Astrology\DTOs;

class ZiWeiChartDTO
{
    public function __construct(
        public string $mingGong,
        public string $mainStar,
        public array $palaces
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            mingGong: $data['ming_gong'],
            mainStar: $data['main_star'],
            palaces: $data['palaces']
        );
    }

    public function toArray(): array
    {
        return [
            'ming_gong' => $this->mingGong,
            'main_star' => $this->mainStar,
            'palaces' => $this->palaces,
        ];
    }
}
