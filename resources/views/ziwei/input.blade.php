<x-layouts.app.sidebar>

<x-slot>
<div class="min-h-screen bg-gradient-to-br from-purple-900 via-blue-900 to-indigo-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white mb-4">紫微斗数命盤</h1>
            <p class="text-blue-200">生年月日・出生時間・出生地を入力して命盤を作成します</p>
        </div>

        <div class="bg-white rounded-lg shadow-xl p-8">
            <form action="{{ route('ziwei.generate') }}" method="POST" class="space-y-6">
                @csrf
                
                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-md">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- プロフィール情報の表示 -->
                @if($profileData)
                    <div class="bg-blue-50 border border-blue-200 rounded-md p-4 mb-6">
                        <h3 class="text-sm font-medium text-blue-800 mb-2">登録済みのプロフィール情報</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div><span class="font-semibold">お名前:</span> {{ $profileData['name'] }}</div>
                            <div><span class="font-semibold">生年月日:</span> {{ $profileData['birth_date'] }}</div>
                            <div><span class="font-semibold">出生時間:</span> {{ $profileData['birth_time'] ?? '不明' }}</div>
                            <div class="md:col-span-3"><span class="font-semibold">出生地:</span> {{ $profileData['prefecture_name'] }}</div>
                        </div>
                        <p class="text-xs text-blue-700 mt-2">
                            ※ プロフィール情報を変更したい場合は、<a href="{{ route('profile.edit') }}" class="underline hover:no-underline">プロフィール設定</a>から変更してください。
                        </p>
                    </div>
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mb-6">
                        <h3 class="text-sm font-medium text-yellow-800 mb-2">プロフィール情報が未完了です</h3>
                        <p class="text-sm text-yellow-700 mb-3">
                            紫微斗数命盤を作成するには、生年月日・出生時間・出生地の情報が必要です。
                        </p>
                        <a href="{{ route('profile.edit') }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-yellow-800 bg-yellow-100 border border-yellow-300 rounded-md hover:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            プロフィール設定へ
                        </a>
                    </div>
                @endif

                <!-- 生年月日 -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                        生年月日 <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           id="date" 
                           name="date" 
                           value="{{ old('date', $profileData['birth_date'] ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                           required>
                </div>

                <!-- 出生時間 -->
                <div>
                    <label for="time" class="block text-sm font-medium text-gray-700 mb-2">
                        出生時間 <span class="text-red-500">*</span>
                    </label>
                    <input type="time" 
                           id="time" 
                           name="time" 
                           value="{{ old('time', $profileData['birth_time'] ?? '00:00') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                           required>
                    <p class="text-xs text-gray-500 mt-1">24時間形式で入力してください（例：15:30）</p>
                </div>

                <!-- 都道府県 -->
                <div>
                    <label for="prefecture" class="block text-sm font-medium text-gray-700 mb-2">
                        出生地（都道府県） <span class="text-red-500">*</span>
                    </label>
                    <select id="prefecture" 
                            name="prefecture" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                            required>
                        <option value="">都道府県を選択してください</option>
                        @foreach($prefectures as $prefecture)
                            <option value="{{ $prefecture }}" 
                                    {{ old('prefecture', $profileData['prefecture_name'] ?? '') === $prefecture ? 'selected' : '' }}>
                                {{ $prefecture }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">出生地の都道府県を選択してください</p>
                </div>

                <!-- 注意事項 -->
                <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                    <h3 class="text-sm font-medium text-blue-800 mb-2">注意事項</h3>
                    <ul class="text-xs text-blue-700 space-y-1">
                        <li>• 出生時間が不明な場合は、午前0時を入力してください</li>
                        <li>• 子時（23:00-00:59）は特別な扱いをします</li>
                        <li>• 地方時は自動的に補正されます</li>
                        <li>• 1948-1951年のサマータイム期間も考慮されます</li>
                    </ul>
                </div>

                <!-- 送信ボタン -->
                <div class="pt-4">
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white font-bold py-3 px-4 rounded-md hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                        命盤を作成する
                    </button>
                </div>
            </form>
        </div>

        <!-- 説明 -->
        <div class="mt-8 text-center">
            <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-white mb-3">紫微斗数とは</h3>
                <p class="text-blue-200 text-sm leading-relaxed">
                    紫微斗数は、中国の伝統的な占星術の一つで、14の主星と様々な副星を12の宮に配置して、
                    人の性格や運命を分析する占術です。生年月日・出生時間・出生地を基に、
                    個人の命盤を作成し、人生の様々な側面を読み解きます。
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // フォームのバリデーション
    const form = document.querySelector('form');
    const dateInput = document.getElementById('date');
    const timeInput = document.getElementById('time');
    const prefectureSelect = document.getElementById('prefecture');

    form.addEventListener('submit', function(e) {
        if (!dateInput.value || !timeInput.value || !prefectureSelect.value) {
            e.preventDefault();
            alert('すべての項目を入力してください。');
            return false;
        }

        // 日付の妥当性チェック
        const selectedDate = new Date(dateInput.value);
        const today = new Date();
        
        if (selectedDate > today) {
            e.preventDefault();
            alert('未来の日付は入力できません。');
            return false;
        }
    });
});
</script>
</x-slot>
</x-layouts.app.sidebar>
