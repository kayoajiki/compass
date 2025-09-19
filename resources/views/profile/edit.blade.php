<x-layouts.app :title="'プロフィール設定 - FortuneCompass'">
    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    プロフィール設定
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300">
                    占いの精度向上のため、出生情報を入力してください
                </p>
            </div>

            <!-- Progress Indicator -->
            <div class="mb-8">
                <div class="flex items-center justify-center space-x-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center text-sm font-medium">
                            1
                        </div>
                        <span class="ml-2 text-sm font-medium text-purple-600 dark:text-purple-400">出生情報入力</span>
                    </div>
                    <div class="w-12 h-0.5 bg-gray-300 dark:bg-zinc-600"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-300 dark:bg-zinc-600 text-gray-600 dark:text-gray-400 rounded-full flex items-center justify-center text-sm font-medium">
                            2
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400">完了</span>
                    </div>
                </div>
            </div>

            <!-- Profile Form -->
            <livewire:profile.edit-core />

            <!-- Help Text -->
            <div class="mt-8 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-blue-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-1">
                            入力について
                        </h3>
                        <ul class="text-sm text-blue-700 dark:text-blue-300 space-y-1">
                            <li>• 氏名と生年月日は一度登録すると変更できません</li>
                            <li>• 出生時刻が不明な場合は「不明」を選択してください</li>
                            <li>• 出生地は都道府県レベルで選択してください</li>
                            <li>• 正確な情報を入力することで、より精密な占い結果を得られます</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
