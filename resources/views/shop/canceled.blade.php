<x-layouts.app>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <!-- キャンセルメッセージ -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">購入がキャンセルされました</h1>
                <p class="text-lg text-gray-600">
                    支払いが完了しませんでした
                </p>
            </div>

            <!-- キャンセル理由の説明 -->
            <div class="bg-yellow-50 rounded-2xl p-6 mb-6">
                <h3 class="text-lg font-semibold text-yellow-900 mb-3">キャンセルの理由</h3>
                <div class="space-y-2 text-yellow-800">
                    <p>• 支払い画面で「戻る」ボタンを押した</p>
                    <p>• 支払い処理がタイムアウトした</p>
                    <p>• ブラウザを閉じた</p>
                    <p>• その他の理由で支払いが完了しなかった</p>
                </div>
            </div>

            <!-- 再購入の案内 -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">再度ご購入いただけます</h3>
                <p class="text-gray-600 mb-4">
                    キャンセルされた場合でも、いつでも再度ご購入いただけます。
                    前回の注文は無効になっており、料金は発生いたしません。
                </p>
                
                <div class="space-y-3">
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-xs font-bold text-purple-600">1</span>
                        </div>
                        <p class="text-sm text-gray-600">再度商品を選択してください</p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-xs font-bold text-purple-600">2</span>
                        </div>
                        <p class="text-sm text-gray-600">数量を選択してください</p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-xs font-bold text-purple-600">3</span>
                        </div>
                        <p class="text-sm text-gray-600">支払い完了後、商品を発送いたします</p>
                    </div>
                </div>
            </div>

            <!-- アクションボタン -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('shop') }}" class="flex-1 bg-purple-600 text-white py-3 px-6 rounded-lg font-semibold text-center hover:bg-purple-700 transition-colors">
                    再度購入する
                </a>
                <a href="{{ route('dashboard') }}" class="flex-1 border border-gray-300 text-gray-700 py-3 px-6 rounded-lg font-semibold text-center hover:bg-gray-50 transition-colors">
                    ダッシュボードに戻る
                </a>
            </div>

            <!-- サポート情報 -->
            <div class="text-center mt-8">
                <p class="text-sm text-gray-500">
                    支払いでお困りの場合は、
                    <a href="mailto:support@example.com" class="text-purple-600 hover:text-purple-700">
                        サポートまでお問い合わせください
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-layouts.app>
