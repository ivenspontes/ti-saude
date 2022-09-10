FROM lavoweb/php-8.1:composer

RUN apt-get update -qq && apt-get install -y \
  postgresql-client libpq-dev

RUN docker-php-ext-install pgsql pdo_pgsql

#COPY ./ /var/www/laravel
COPY ./.docker/laravel/config/ /etc/apache2/sites-available/
COPY ./.docker/laravel/docker-php-entrypoint /usr/local/bin/docker-php-entrypoint

RUN chmod +x /usr/local/bin/docker-php-entrypoint

WORKDIR /var/www/laravel
