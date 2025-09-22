<?php

namespace App\Filament\Resources\ChatbotUsageResource\Pages;

use App\Filament\Resources\ChatbotUsageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChatbotUsages extends ListRecords
{
    protected static string $resource = ChatbotUsageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
