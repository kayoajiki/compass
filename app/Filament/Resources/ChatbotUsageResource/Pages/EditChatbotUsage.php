<?php

namespace App\Filament\Resources\ChatbotUsageResource\Pages;

use App\Filament\Resources\ChatbotUsageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChatbotUsage extends EditRecord
{
    protected static string $resource = ChatbotUsageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
