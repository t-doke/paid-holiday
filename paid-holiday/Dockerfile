# PHPの公式Apacheイメージを使用
FROM php:8.4-apache

# 必要なPHP拡張をインストール
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Apacheの設定をコピー
COPY ./config/vhost.conf /etc/apache2/sites-available/000-default.conf

# PHP設定ファイルをコピー
COPY ./config/php.ini /usr/local/etc/php/

# Apacheのモジュールを有効化
RUN a2enmod rewrite
RUN a2enmod mime

# Apacheを再起動
RUN service apache2 restart

# ドキュメントルートの設定
WORKDIR /var/www/html

# ポート80を公開
EXPOSE 80
