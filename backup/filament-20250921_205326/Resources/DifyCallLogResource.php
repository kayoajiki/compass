<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DifyCallLogResource\Pages;
use App\Filament\Resources\DifyCallLogResource\RelationManagers;
use App\Models\DifyCallLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DifyCallLogResource extends Resource
{
    protected static ?string $model = DifyCallLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';
    
    protected static ?string $navigationLabel = 'AI連携ログ';
    
    protected static ?string $modelLabel = 'AI連携ログ';
    
    protected static ?string $pluralModelLabel = 'AI連携ログ';
    
    protected static ?string $navigationGroup = 'AI / ログ';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('app_code')
                    ->required(),
                Forms\Components\Toggle::make('success')
                    ->required(),
                Forms\Components\TextInput::make('duration_ms')
                    ->numeric(),
                Forms\Components\TextInput::make('http_status')
                    ->numeric(),
                Forms\Components\Textarea::make('request_data')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('response_data')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('error_message')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('app_code')
                    ->searchable(),
                Tables\Columns\IconColumn::make('success')
                    ->boolean(),
                Tables\Columns\TextColumn::make('duration_ms')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('http_status')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDifyCallLogs::route('/'),
            'create' => Pages\CreateDifyCallLog::route('/create'),
            'edit' => Pages\EditDifyCallLog::route('/{record}/edit'),
        ];
    }
}
