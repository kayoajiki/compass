@extends('admin.layout')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">新規商品追加</h3>
                <p class="mt-1 text-sm text-gray-600">新しい商品の情報を入力してください。</p>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="shadow sm:overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="name" class="block text-sm font-medium text-gray-700">商品名 *</label>
                                <input type="text" name="name" id="name" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                       value="{{ old('name') }}">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="sku" class="block text-sm font-medium text-gray-700">SKU *</label>
                                <input type="text" name="sku" id="sku" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                       value="{{ old('sku') }}">
                                @error('sku')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="type" class="block text-sm font-medium text-gray-700">商品タイプ *</label>
                                <select name="type" id="type" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">選択してください</option>
                                    <option value="physical" {{ old('type') == 'physical' ? 'selected' : '' }}>物理商品</option>
                                    <option value="digital" {{ old('type') == 'digital' ? 'selected' : '' }}>デジタル商品</option>
                                    <option value="service" {{ old('type') == 'service' ? 'selected' : '' }}>サービス</option>
                                </select>
                                @error('type')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="price_cents" class="block text-sm font-medium text-gray-700">価格（円） *</label>
                                <input type="number" name="price_cents" id="price_cents" required min="0"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                       value="{{ old('price_cents') }}">
                                @error('price_cents')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="stock" class="block text-sm font-medium text-gray-700">在庫数</label>
                                <input type="number" name="stock" id="stock" min="0"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                       value="{{ old('stock') }}"
                                       placeholder="空欄で無制限">
                                @error('stock')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_active" id="is_active" value="1"
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                        アクティブ
                                    </label>
                                </div>
                            </div>

                            <div class="col-span-6">
                                <label for="description" class="block text-sm font-medium text-gray-700">商品説明</label>
                                <textarea name="description" id="description" rows="3"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6">
                                <label for="image" class="block text-sm font-medium text-gray-700">商品画像</label>
                                <input type="file" name="image" id="image" accept="image/*"
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                @error('image')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <a href="{{ route('admin.products.index') }}" 
                           class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            キャンセル
                        </a>
                        <button type="submit" 
                                class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            商品を作成
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
