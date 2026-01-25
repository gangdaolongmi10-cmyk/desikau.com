.PHONY: build up down restart logs ps shell shell-db npm artisan composer fresh

# Dockerコンテナをビルド
build:
	docker-compose build

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

%:
	@:
