# FortuneCompass - 人生の羅針盤占い

FortuneCompassは、四柱推命・紫微斗数・西洋占星術・数秘術など複数の占術を横断し、利用者に人生の羅針盤を提供するサービスです。

## 機能

### 無料プラン
- 今日の運勢（簡易版）
- 各占術：盤面表示＋総合点
- タロット1日1回

### 有料プラン（月額¥980 / 年額¥9,800）
- 各占術詳細（観点別・提案付き）
- 相性・二者択一・吉日詳細
- 他者鑑定追加（上限5人）
- 運勢カレンダー＋月次レポート（AI生成）

## 技術スタック

- **Framework**: Laravel 12 / PHP 8.3
- **UI**: Blade + Livewire v3 + TailwindCSS
- **Auth**: Breeze + Socialite（Google / Email）
- **Queue**: Redis + Horizon
- **Payments**: Stripe（Cashier）
- **AI連携**: Dify API
- **Admin**: Filament v3
- **Infra**: MySQL 8.x, Redis, Horizon

## セットアップ

### 1. リポジトリのクローン
```bash
git clone https://github.com/your-username/fortune-compass.git
cd fortune-compass
```

### 2. 依存関係のインストール
```bash
composer install
npm install
```

### 3. 環境設定
```bash
cp .env.example .env
php artisan key:generate
```

### 4. データベース設定
```bash
php artisan migrate
```

### 5. アセットのビルド
```bash
npm run dev
# または
npm run build
```

### 6. サーバー起動
```bash
php artisan serve
```

## 環境変数

### 必須設定
- `APP_KEY`: アプリケーションキー
- `DB_DATABASE`: データベースファイルのパス（SQLite使用時）

### Google OAuth
- `GOOGLE_CLIENT_ID`: Google OAuth クライアントID
- `GOOGLE_CLIENT_SECRET`: Google OAuth クライアントシークレット
- `GOOGLE_REDIRECT_URI`: コールバックURL

### Stripe
- `STRIPE_KEY`: Stripe公開キー
- `STRIPE_SECRET`: Stripeシークレットキー
- `STRIPE_WEBHOOK_SECRET`: Stripe Webhookシークレット

## プロジェクト構造

```
app/
├── Domain/
│   └── Astrology/
│       └── Services/
│           └── DailyMockService.php
├── Http/
│   ├── Controllers/
│   └── Middleware/
├── Livewire/
│   ├── Dashboard/
│   └── Profile/
└── Models/

resources/
├── views/
│   ├── components/
│   ├── livewire/
│   └── layouts/
└── css/

routes/
├── web.php
└── auth.php
```

## 開発

### テスト実行
```bash
php artisan test
```

### コードスタイル
```bash
./vendor/bin/pint
```

## ライセンス

このプロジェクトはMITライセンスの下で公開されています。

## 貢献

プルリクエストやイシューの報告を歓迎します。

## 連絡先

プロジェクトに関する質問がある場合は、イシューを作成してください。
