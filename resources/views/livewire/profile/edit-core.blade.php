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

    <!-- Edit Mode -->
        <form wire:submit.prevent="save">
            <div class="space-y-6">
                <!-- 氏名 -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            氏名 <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <input 
                                    type="text" 
                                    wire:model="last_name"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-zinc-800 dark:text-white @error('last_name') border-red-500 @enderror"
                                    placeholder="姓"
                                    @if($is_completed) readonly @endif
                                >
                                @error('last_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <input 
                                    type="text" 
                                    wire:model="first_name"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-zinc-800 dark:text-white @error('first_name') border-red-500 @enderror"
                                    placeholder="名"
                                    @if($is_completed) readonly @endif
                                >
                                @error('first_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            ふりがな <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <input 
                                    type="text" 
                                    wire:model="last_name_kana"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-zinc-800 dark:text-white @error('last_name_kana') border-red-500 @enderror"
                                    placeholder="セイ"
                                    @if($is_completed) readonly @endif
                                >
                                @error('last_name_kana')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <input 
                                    type="text" 
                                    wire:model="first_name_kana"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-zinc-800 dark:text-white @error('first_name_kana') border-red-500 @enderror"
                                    placeholder="メイ"
                                    @if($is_completed) readonly @endif
                                >
                                @error('first_name_kana')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            カタカナで入力してください
                        </p>
                    </div>
                    
                    @if($is_completed)
                        <p class="text-xs text-gray-500 dark:text-gray-400">氏名は一度登録すると変更できません</p>
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
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <select 
                                wire:model="birth_hour"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-zinc-800 dark:text-white @error('birth_hour') border-red-500 @enderror"
                            >
                                @foreach($this->getHourOptions() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('birth_hour')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <select 
                                wire:model="birth_minute"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-zinc-800 dark:text-white @error('birth_minute') border-red-500 @enderror"
                            >
                                @foreach($this->getMinuteOptions() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('birth_minute')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        1分刻みで選択できます。不明な場合は「不明」を選択してください。
                    </p>
                </div>

                <!-- 出生地 -->
                <div>
                    <label for="birth_place_pref" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        出生地 <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="birth_place_pref"
                        wire:model="birth_place_pref"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-zinc-800 dark:text-white @error('birth_place_pref') border-red-500 @enderror"
                    >
                        <option value="">都道府県を選択してください</option>
                        @foreach($this->getPrefectures() as $code => $name)
                            <option value="{{ $code }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('birth_place_pref')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex justify-end space-x-3">
                <button 
                    type="button"
                    wire:click="resetForm"
                    class="px-6 py-2 border border-gray-300 dark:border-zinc-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors"
                >
                    リセット
                </button>
                <button 
                    type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors"
                >
                    保存する
                </button>
            </div>
        </form>
</div>