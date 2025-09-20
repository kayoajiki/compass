<?php

namespace App\Filament\Resources\DifyCallLogResource\Pages;

use App\Filament\Resources\DifyCallLogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDifyCallLog extends EditRecord
{
    protected static string $resource = DifyCallLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
