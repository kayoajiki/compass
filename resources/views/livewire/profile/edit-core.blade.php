<div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-purple-100 dark:border-zinc-700 p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                出生情報
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                占いの精度向上のため、正確な出生情報を入力してください
            </p>
        </div>
        @if($is_completed)
            <div class="flex items-center text-green-600 dark:text-green-400">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm font-medium">登録完了</span>
            </div>
        @endif
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
            <div class="flex">
                <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm text-green-800 dark:text-green-200">{{ session('message') }}</p>
            </div>
        </div>
    @endif

    <!-- General Error -->
    @error('general')
        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
            <div class="flex">
                <svg class="w-5 h-5 text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm text-red-800 dark:text-red-200">{{ $message }}</p>
            </div>
        </div>
    @enderror

    @if(!$is_editing)
        <!-- Display Mode -->
        <div class="space-y-4">
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">氏名</label>
                    <div class="p-3 bg-gray-50 dark:bg-zinc-800 rounded-lg border">
                        <span class="text-gray-900 dark:text-white">{{ $name ?: '未入力' }}</span>
                        @if($is_completed)
                            <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">（変更不可）</span>
                        @endif
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">生年月日</label>
                    <div class="p-3 bg-gray-50 dark:bg-zinc-800 rounded-lg border">
                        <span class="text-gray-900 dark:text-white">{{ $birth_date ? \Carbon\Carbon::parse($birth_date)->format('Y年m月d日') : '未入力' }}</span>
                        @if($is_completed)
                            <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">（変更不可）</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">出生時刻</label>
                    <div class="p-3 bg-gray-50 dark:bg-zinc-800 rounded-lg border">
                        <span class="text-gray-900 dark:text-white">
                            @if($is_birth_time_unknown)
                                不明
                            @else
                                {{ $birth_time ?: '未入力' }}
                            @endif
                        </span>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">出生地</label>
                    <div class="p-3 bg-gray-50 dark:bg-zinc-800 rounded-lg border">
                        <span class="text-gray-900 dark:text-white">{{ $this->getBirthPlaceName() ?: '未選択' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex justify-end">
            @if(!$is_completed)
                <button 
                    wire:click="startEditing"
                    class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors"
                >
                    編集する
                </button>
            @else
                <button 
                    wire:click="startEditing"
                    class="border border-purple-600 text-purple-600 hover:bg-purple-50 dark:text-purple-400 dark:hover:bg-purple-900/20 px-6 py-2 rounded-lg text-sm font-medium transition-colors"
                >
                    出生時刻・出生地を編集
                </button>
            @endif
        </div>
    @else
        <!-- Edit Mode -->
        <form wire:submit.prevent="save">
            <div class="space-y-6">
                <!-- 氏名 -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        氏名 <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name"
                        wire:model="name"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-zinc-800 dark:text-white @error('name') border-red-500 @enderror"
                        placeholder="山田太郎"
                        @if($is_completed) readonly @endif
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    @if($is_completed)
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">氏名は一度登録すると変更できません</p>
                    @endif
                </div>

                <!-- 生年月日 -->
                <div>
                    <label for="birth_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        生年月日 <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        id="birth_date"
                        wire:model="birth_date"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-zinc-800 dark:text-white @error('birth_date') border-red-500 @enderror"
                        @if($is_completed) readonly @endif
                    >
                    @error('birth_date')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    @if($is_completed)
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">生年月日は一度登録すると変更できません</p>
                    @endif
                </div>

                <!-- 出生時刻 -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        出生時刻
                    </label>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input 
                                type="radio" 
                                wire:model="is_birth_time_unknown" 
                                value="true"
                                class="w-4 h-4 text-purple-600 border-gray-300 focus:ring-purple-500"
                            >
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">不明</span>
                        </label>
                        <label class="flex items-center">
                            <input 
                                type="radio" 
                                wire:model="is_birth_time_unknown" 
                                value="false"
                                class="w-4 h-4 text-purple-600 border-gray-300 focus:ring-purple-500"
                            >
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">分かる</span>
                        </label>
                    </div>
                    
                    @if(!$is_birth_time_unknown)
                        <div class="mt-3">
                            <input 
                                type="time" 
                                wire:model="birth_time"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-zinc-800 dark:text-white @error('birth_time') border-red-500 @enderror"
                            >
                            @error('birth_time')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
                </div>

                <!-- 出生地 -->
                <div>
                    <label for="birth_place" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        出生地 <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="birth_place"
                        wire:model="birth_place"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-zinc-800 dark:text-white @error('birth_place') border-red-500 @enderror"
                    >
                        <option value="">都道府県を選択してください</option>
                        @foreach($this->getPrefectures() as $code => $name)
                            <option value="{{ $code }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('birth_place')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex justify-end space-x-3">
                <button 
                    type="button"
                    wire:click="cancelEditing"
                    class="px-6 py-2 border border-gray-300 dark:border-zinc-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors"
                >
                    キャンセル
                </button>
                <button 
                    type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors"
                >
                    保存する
                </button>
            </div>
        </form>
    @endif
</div>