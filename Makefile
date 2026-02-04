.PHONY: build up down restart logs ps shell shell-db npm artisan composer fresh stripe-listen stripe-webhook stripe-trigger

# 現在のユーザーのUID/GIDを取得
export UID := $(shell id -u)
export GID := $(shell id -g)

# Dockerコンテナをビルド
build:
	UID=$(UID) GID=$(GID) docker-compose build

# Dockerコンテナを起動
up:
	docker-compose up -d

# Dockerコンテナを停止
down:
	docker-compose down

# Dockerコンテナを再起動
restart:
	docker-compose restart

# ログを表示
logs:
	docker-compose logs -f

# コンテナの状態を表示
ps:
	docker-compose ps

# PHPコンテナにシェルで入る
shell:
	docker-compose exec app bash

# MySQLコンテナにシェルで入る
shell-db:
	docker-compose exec db mysql -u desikau -ppassword desikau

# npm コマンド実行
npm:
	docker-compose run --rm node npm $(filter-out $@,$(MAKECMDGOALS))

# artisan コマンド実行
artisan:
	docker-compose exec app php artisan $(filter-out $@,$(MAKECMDGOALS))

# composer コマンド実行
composer:
	docker-compose exec app composer $(filter-out $@,$(MAKECMDGOALS))

# データベースを再作成してシーディング
fresh:
	docker-compose exec app php artisan migrate:fresh --seed

# Laravelプロジェクトを新規作成
init-laravel:
	docker-compose exec app bash -c "export COMPOSER_CACHE_DIR=/tmp/composer-cache && composer create-project laravel/laravel:^12.0 ."

# テスト実行
test:
	docker-compose exec app php artisan test

# Vite開発サーバー起動
dev:
	docker-compose run --rm -p 5173:5173 node npm run dev

# 本番ビルド
build-assets:
	docker-compose run --rm node npm run build

# Stripe APIキーを.envから読み込み
STRIPE_SECRET := $(shell grep STRIPE_SECRET src/.env | cut -d '=' -f2)

# Stripe Webhookをリッスン（APIキー使用）
stripe-listen:
	@echo "Stripe Webhookを開始します..."
	docker run -it --rm --network desikau-network stripe/stripe-cli listen --forward-to http://nginx/stripe/webhook --api-key $(STRIPE_SECRET)

# Stripe Webhookをリッスン（Webhook Secret表示）
stripe-webhook:
	@echo "Stripe Webhookを開始します..."
	@echo "表示されるwebhook signing secretを .env の STRIPE_WEBHOOK_SECRET に設定してください"
	docker run -it --rm --network desikau-network stripe/stripe-cli listen --forward-to http://nginx/stripe/webhook --api-key $(STRIPE_SECRET) --print-secret

# Stripeイベントをトリガー（テスト用）
# 使用例: make stripe-trigger checkout.session.completed
stripe-trigger:
	docker run --rm --network desikau-network stripe/stripe-cli trigger $(filter-out $@,$(MAKECMDGOALS)) --api-key $(STRIPE_SECRET)

%:
	@:
