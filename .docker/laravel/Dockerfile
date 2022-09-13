FROM lavoweb/php-8.1:composer

RUN apt-get update -qq && apt-get install -y \
  postgresql-client libpq-dev

RUN docker-php-ext-install pgsql pdo_pgsql

COPY ./.docker/laravel/config/ /etc/apache2/sites-available/

WORKDIR /var/www/laravel
