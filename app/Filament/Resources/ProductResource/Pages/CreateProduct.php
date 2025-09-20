<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // 画像URLをmetadataに保存
        if (isset($data['image'])) {
            $data['metadata'] = array_merge($data['metadata'] ?? [], [
                'image_url' => $data['image'],
            ]);
        }
        
        // 商品詳細をmetadataに保存
        $metadataFields = ['description', 'benefits', 'target_audience', 'category', 'price_range', 'popularity_score', 'recommend_tags', 'duration'];
        $metadata = [];
        
        foreach ($metadataFields as $field) {
            if (isset($data[$field])) {
                $metadata[$field] = $data[$field];
            }
        }
        
        if (!empty($metadata)) {
            $data['metadata'] = array_merge($data['metadata'] ?? [], $metadata);
        }
        
        // フォームフィールドから除外
        foreach ($metadataFields as $field) {
            unset($data[$field]);
        }
        unset($data['image']);
        
        return $data;
    }
}
