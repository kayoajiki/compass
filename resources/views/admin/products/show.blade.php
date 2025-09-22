@extends('admin.layout')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold text-gray-900">商品詳細</h1>
            <p class="mt-2 text-sm text-gray-700">{{ $product->name }}</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <a href="{{ route('admin.products.edit', $product) }}" 
               class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                編集
            </a>
            <a href="{{ route('admin.products.index') }}" 
               class="ml-3 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                一覧に戻る
            </a>
        </div>
    </div>

    <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">商品情報</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">商品の詳細情報を表示しています。</p>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">商品名</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $product->name }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">SKU</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $product->sku }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">商品タイプ</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                            @if($product->type === 'physical') bg-blue-100 text-blue-800
                            @elseif($product->type === 'digital') bg-green-100 text-green-800
                            @else bg-purple-100 text-purple-800
                            @endif">
                            @if($product->type === 'physical') 物理商品
                            @elseif($product->type === 'digital') デジタル商品
                            @else サービス
                            @endif
                        </span>
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">価格</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $product->formatted_price }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">在庫数</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @if($product->stock === null)
                            <span class="text-gray-500">無制限</span>
                        @else
                            {{ $product->stock }}
                        @endif
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">ステータス</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                            {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->is_active ? 'アクティブ' : '非アクティブ' }}
                        </span>
                    </dd>
                </div>
                @if($product->metadata && isset($product->metadata['description']))
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">商品説明</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $product->metadata['description'] }}</dd>
                </div>
                @endif
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">作成日時</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $product->created_at->format('Y年m月d日 H:i') }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">更新日時</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $product->updated_at->format('Y年m月d日 H:i') }}</dd>
                </div>
            </dl>
        </div>
    </div>

    @if($product->metadata && isset($product->metadata['image']))
    <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">商品画像</h3>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
            <img src="{{ Storage::url($product->metadata['image']) }}" 
                 alt="{{ $product->name }}" 
                 class="h-32 w-32 object-cover rounded-lg">
        </div>
    </div>
    @endif

    <!-- 削除ボタン -->
    <div class="mt-8 bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <span class="text-red-400">⚠️</span>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">危険な操作</h3>
                <div class="mt-2 text-sm text-red-700">
                    <p>この商品を削除すると、関連する注文データにも影響する可能性があります。</p>
                </div>
                <div class="mt-4">
                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" 
                          onsubmit="return confirm('この商品を削除してもよろしいですか？この操作は取り消せません。')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            商品を削除
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
