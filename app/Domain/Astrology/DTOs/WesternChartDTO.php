<?php

namespace App\Domain\Astrology\DTOs;

class WesternChartDTO
{
    public function __construct(
        public array $planets,
        public array $houses,
        public array $aspects
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            planets: $data['planets'],
            houses: $data['houses'],
            aspects: $data['aspects']
        );
    }

    public function toArray(): array
    {
        return [
            'planets' => $this->planets,
            'houses' => $this->houses,
            'aspects' => $this->aspects,
        ];
    }
}
