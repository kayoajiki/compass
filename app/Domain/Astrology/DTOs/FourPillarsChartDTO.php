<?php

namespace App\Domain\Astrology\DTOs;

class FourPillarsChartDTO
{
    public function __construct(
        public array $year,
        public array $month,
        public array $day,
        public array $hour
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            year: $data['year'],
            month: $data['month'],
            day: $data['day'],
            hour: $data['hour']
        );
    }

    public function toArray(): array
    {
        return [
            'year' => $this->year,
            'month' => $this->month,
            'day' => $this->day,
            'hour' => $this->hour,
        ];
    }
}
