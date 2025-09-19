@if($showSwitcher)
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <label for="person-select" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                対象人物を選択
            </label>
            <span class="text-xs text-gray-500 dark:text-gray-400">
                サブスク会員特典
            </span>
        </div>
        <select 
            id="person-select"
            wire:model.live="selectedPersonId"
            class="mt-1 block w-full border-gray-300 dark:border-zinc-600 rounded-md shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white"
        >
            @foreach($persons as $person)
                <option value="{{ $person['id'] }}" {{ $selectedPersonId == $person['id'] ? 'selected' : '' }}>
                    @if($person['is_self'])
                        👤 {{ $person['name'] }}
                    @else
                        👥 {{ $person['name'] }}
                    @endif
                </option>
            @endforeach
        </select>
        @if($selectedPersonId && !collect($persons)->firstWhere('id', $selectedPersonId)['is_self'])
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                他者のプロフィール情報に基づいた鑑定結果を表示しています
            </p>
        @endif
    </div>
@endif