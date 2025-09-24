@extends('admin.layout')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold text-gray-900">商品管理</h1>
            <p class="mt-2 text-sm text-gray-700">商品の一覧、追加、編集、削除を行います。</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <a href="{{ route('admin.products.create') }}" 
               class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                新規商品追加
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mt-4 rounded-md bg-green-50 p-4">
            <div class="flex">
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-green-800">成功</h3>
                    <div class="mt-2 text-sm text-green-700">
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="mt-8 flex flex-col">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    商品情報
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    タイプ
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    価格
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    在庫
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ステータス
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">操作</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($products as $product)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if($product->image_url)
                                                    <img class="h-10 w-10 rounded-full object-cover" 
                                                         src="{{ $product->image_url }}" 
                                                         alt="{{ $product->name }}">
                                                @else
                                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                        <span class="text-gray-500 text-sm font-medium">{{ substr($product->name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                                <div class="text-sm text-gray-500">SKU: {{ $product->sku }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
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
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $product->formatted_price }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($product->stock === null)
                                            <span class="text-gray-500">無制限</span>
                                        @else
                                            {{ $product->stock }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $product->is_active ? 'アクティブ' : '非アクティブ' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.products.show', $product) }}" 
                                               class="text-indigo-600 hover:text-indigo-900">詳細</a>
                                            <a href="{{ route('admin.products.edit', $product) }}" 
                                               class="text-indigo-600 hover:text-indigo-900">編集</a>
                                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" 
                                                  class="inline" 
                                                  onsubmit="return confirm('この商品を削除してもよろしいですか？')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">削除</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                        商品がありません。
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- ページネーション -->
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
