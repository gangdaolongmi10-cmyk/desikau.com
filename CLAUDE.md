# プロジェクト概要
プロジェクト名: desikau
目的: デジタルコンテンツを販売するECサイト
主要言語: PHP, JavaScript
フレームワーク・ライブラリ:
- PHPフレームワーク: Laravel 12
- テンプレートエンジン: Blade
- フロントエンド: jQuery, TailwindCSS
データベース: MySQL

# バージョン管理
- Laravel: 12
- PHP: 8.3
- TailwindCSS: 3.x
- jQuery: 3.x
- Node.js: 18.x以上
- composer.lock と package-lock.json は必ずコミットすること

# コーディングルール

## 共通
- コメントは関数・クラス・重要な変数・複雑な処理に日本語で記述
- コードは可読性を優先し、簡潔に保つ
- 命名規則はプロジェクト全体で統一する

## PHP
- PSR-12に準拠すること
- 命名規則:
  - 変数名: camelCase
  - クラス名: PascalCase
  - 関数名: camelCase
  - 定数名: UPPER_SNAKE_CASE（クラス定数、グローバル定数含む）
  - インスタンス変数名: camelCase(readonly可能なら定義)
  - インスタンスメソッド名: camelCase
  - 静的メソッド名: camelCase
  - 静的変数名: UPPER_SNAKE_CASE
  - インターフェース名: PascalCase
  - トライト名: PascalCase
- 関数: private, protected, publicを明確に定義すること

## Laravel
- Bladeテンプレートを使用すること
- UIコンポーネントはBladeコンポーネント化すること
- Migrationを作成したらSeederを作成すること
- Seederを作成したらFactoryを作成すること（テストデータ生成用）
- ルート定義やコントローラーの命名規則はLaravel標準に従う
- バリデーションはRequestクラスで行うこと

## CSS
- TailwindCSSを使用すること
- Tailwind以外のCSSフレームワークやライブラリは使用禁止

# ディレクトリ構造

## 主要ディレクトリ
- data/
  - db/
  - storage/
- docker/
- src/
  - app/
    - Actions/
    - Enums/
    - Http/
      - Controllers/
      - Middleware/
      - Requests/
    - Models/
    - Repositories/
    - Rules/
    - Providers/
    - Services/
  - bootstrap/
  - config/
  - database/
  - public/
  - resources/
  - routes/
  - storage/
  - tests/

## 重要ファイル
- src/vendor/
- src/artisan
- src/composer.json
- src/package.json
- src/tailwind.config.js
- src/vite.config.js
- src/.env

# 注意点
- Dockerを必ず使用すること（開発・本番ともに統一環境）
- データベースのマイグレーションは必ず実行すること
- APIキーは必ず.envファイルに保存すること
- 本番環境のDB接続情報はローカルに書かないこと
- CSSはTailwind以外使用禁止
- 重要ファイルや環境設定は絶対に削除・変更しないこと

# テストルール
- Featureテストは必ず作成すること
- テストデータはFactoryで生成すること
- コントローラーやサービスの重要処理は必ずテストすること

# Dockerコマンド

## 基本操作
- `make build` - Dockerイメージをビルド
- `make up` - コンテナを起動
- `make down` - コンテナを停止
- `make restart` - コンテナを再起動
- `make logs` - ログを表示
- `make ps` - コンテナの状態を表示

## シェルアクセス
- `make shell` - PHPコンテナに入る
- `make shell-db` - MySQLに接続

## 開発コマンド
- `make artisan [command]` - artisanコマンド実行
- `make composer [command]` - composerコマンド実行
- `make npm [command]` - npmコマンド実行
- `make test` - テスト実行
- `make fresh` - DBをリセットしてシーディング
- `make dev` - Vite開発サーバー起動
- `make build-assets` - 本番用アセットビルド

## 初期セットアップ
- `make init-laravel` - Laravelプロジェクトを新規作成

# サブドメインルーティング

## ドメイン構成
- `desikau.local` - ユーザー向けサイト (routes/user.php)
- `admin.desikau.local` - 管理画面 (routes/admin.php)
- `api.desikau.local` - API (routes/api.php)

## hostsファイル設定（開発環境）
```
127.0.0.1 desikau.local
127.0.0.1 admin.desikau.local
127.0.0.1 api.desikau.local
```

## ルート定義
- ルーティング設定: bootstrap/app.php
- ユーザールート: routes/user.php
- 管理画面ルート: routes/admin.php
- APIルート: routes/api.php
- ※ routes/web.php は使用しない