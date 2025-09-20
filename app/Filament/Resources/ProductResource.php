<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    
    protected static ?string $navigationLabel = '商品管理';
    
    protected static ?string $modelLabel = '商品';
    
    protected static ?string $pluralModelLabel = '商品';
    
    protected static ?string $navigationGroup = '取引';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('基本情報')
                    ->schema([
                        Forms\Components\TextInput::make('sku')
                            ->label('SKU')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('name')
                            ->label('商品名')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('type')
                            ->label('商品タイプ')
                            ->options([
                                'physical' => '物理商品（開運アイテム）',
                                'service' => 'サービス（個別鑑定）',
                                'digital' => 'デジタル商品',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('price_cents')
                            ->label('価格（円）')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('currency')
                            ->label('通貨')
                            ->default('JPY')
                            ->maxLength(3),
                        Forms\Components\TextInput::make('stock')
                            ->label('在庫数')
                            ->numeric()
                            ->default(0)
                            ->visible(fn (Forms\Get $get): bool => $get('type') === 'physical'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('有効')
                            ->default(true),
                    ])
                    ->columns(2),
                    
                Forms\Components\Section::make('商品詳細')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('商品画像')
                            ->image()
                            ->directory('products')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ]),
                        Forms\Components\Textarea::make('description')
                            ->label('商品説明')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('benefits')
                            ->label('効果・メリット')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('target_audience')
                            ->label('対象者')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                    
                Forms\Components\Section::make('メタデータ')
                    ->schema([
                        Forms\Components\Select::make('category')
                            ->label('カテゴリー')
                            ->options([
                                'crystal' => 'クリスタル',
                                'omamori' => 'お守り',
                                'accessory' => 'アクセサリー',
                                'book' => '書籍・プランナー',
                                'incense' => 'お香',
                                'reading' => '鑑定サービス',
                            ]),
                        Forms\Components\Select::make('price_range')
                            ->label('価格帯')
                            ->options([
                                'budget' => 'お手頃',
                                'entry' => 'エントリー',
                                'standard' => 'スタンダード',
                                'premium' => 'プレミアム',
                            ]),
                        Forms\Components\TextInput::make('popularity_score')
                            ->label('人気度スコア')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->default(50),
                        Forms\Components\TagsInput::make('recommend_tags')
                            ->label('おすすめタグ')
                            ->placeholder('タグを入力'),
                        Forms\Components\TextInput::make('duration')
                            ->label('鑑定時間（分）')
                            ->numeric()
                            ->visible(fn (Forms\Get $get): bool => $get('type') === 'service'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('画像')
                    ->circular()
                    ->size(60),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('商品名')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('type')
                    ->label('タイプ')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'physical' => '物理商品',
                        'service' => 'サービス',
                        'digital' => 'デジタル',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'physical' => 'success',
                        'service' => 'info',
                        'digital' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('price_cents')
                    ->label('価格')
                    ->formatStateUsing(fn (int $state): string => '¥' . number_format($state))
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock')
                    ->label('在庫')
                    ->numeric()
                    ->sortable()
                    ->visible(fn ($record): bool => $record?->type === 'physical'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('有効')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('作成日')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('タイプ')
                    ->options([
                        'physical' => '物理商品',
                        'service' => 'サービス',
                        'digital' => 'デジタル',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('有効')
                    ->placeholder('すべて')
                    ->trueLabel('有効のみ')
                    ->falseLabel('無効のみ'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
