FROM php:8.3-fpm

# ビルド引数でUID/GIDを受け取る（デフォルトは1000）
ARG UID=1000
ARG GID=1000

# 必要なパッケージをインストール
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Composerをインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# www-dataユーザーのUID/GIDをホストユーザーに合わせる
RUN usermod -u ${UID} www-data && groupmod -g ${GID} www-data

# 作業ディレクトリを設定
WORKDIR /var/www

# www-dataユーザーで実行
USER www-data

EXPOSE 9000
CMD ["php-fpm"]
