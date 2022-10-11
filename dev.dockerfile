FROM php:8.0-apache
MAINTAINER AvaloniumTeam <hello@avalonium.site>

EXPOSE 80
ARG LICENSE_KEY
ENV PHP_IDE_CONFIG="serverName=Docker"

# Enables apache rewrite w/ security
RUN a2enmod rewrite expires && \
    sed -i 's/ServerTokens OS/ServerTokens ProductOnly/g' \
    /etc/apache2/conf-available/security.conf

# Install dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    libfreetype6-dev libjpeg-dev libpng-dev libwebp-dev \
    libpq-dev libsqlite3-dev libzip-dev git-core zip unzip \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install gd zip mysqli pdo_pgsql pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# PHP Xdebug config
RUN { \
    echo 'xdebug.mode=debug'; \
    echo 'xdebug.idekey=PHPSTORM'; \
    echo 'xdebug.client_host=host.docker.internal'; \
  } > /usr/local/etc/php/conf.d/docker-xdebug-php.ini

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN chown -R www-data:www-data /var/www

# Installs OctoberCMS
USER www-data
WORKDIR /var/www/html
RUN composer create-project october/october . --no-interaction --prefer-dist

# Artisan commands
RUN php artisan key:generate && \
    php artisan project:set ${LICENSE_KEY} && \
    php artisan october:build

# Install Faker
RUN composer require fakerphp/faker --dev

# Install Laravel Debugbar
RUN composer require --dev barryvdh/laravel-debugbar \
    && php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"

# Install IDE HELPER
RUN composer require --dev barryvdh/laravel-ide-helper \
    && php artisan vendor:publish --provider="Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider" --tag=config

# Instal Avalonium.Feedback Plugin
COPY . /var/www/html/plugins/avalonium/feedback

CMD ["apache2-foreground"]