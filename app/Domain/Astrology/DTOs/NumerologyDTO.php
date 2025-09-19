<?php

namespace App\Domain\Astrology\DTOs;

class NumerologyDTO
{
    public function __construct(
        public int $lifePathNumber,
        public int $expressionNumber,
        public int $soulUrgeNumber,
        public array $personalYear
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            lifePathNumber: $data['life_path_number'],
            expressionNumber: $data['expression_number'],
            soulUrgeNumber: $data['soul_urge_number'],
            personalYear: $data['personal_year']
        );
    }

    public function toArray(): array
    {
        return [
            'life_path_number' => $this->lifePathNumber,
            'expression_number' => $this->expressionNumber,
            'soul_urge_number' => $this->soulUrgeNumber,
            'personal_year' => $this->personalYear,
        ];
    }
}
