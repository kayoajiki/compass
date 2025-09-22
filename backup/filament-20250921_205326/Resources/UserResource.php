<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?string $navigationLabel = 'ユーザー';
    
    protected static ?string $modelLabel = 'ユーザー';
    
    protected static ?string $pluralModelLabel = 'ユーザー';
    
    protected static ?string $navigationGroup = 'ユーザー';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->disabled(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->disabled(),
                Forms\Components\DateTimePicker::make('email_verified_at')
                    ->disabled(),
                Forms\Components\DateTimePicker::make('created_at')
                    ->label('登録日')
                    ->disabled(),
                Forms\Components\Toggle::make('is_admin')
                    ->label('管理者')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('名前')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('メールアドレス')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label('認証日時')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('登録日')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_admin')
                    ->label('管理者')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('verified')
                    ->label('認証済み')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),
                Tables\Filters\Filter::make('admins')
                    ->label('管理者のみ')
                    ->query(fn (Builder $query): Builder => $query->where('is_admin', true)),
                Tables\Filters\Filter::make('created_after')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('登録日（開始）'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                //
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListUsers::route('/'),
            'view' => Pages\ViewUser::route('/{record}'),
        ];
    }
}
