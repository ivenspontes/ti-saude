SHELL := /usr/bin/env bash
start:
	docker-compose up -d

stop:
	docker-compose down -v

restart:
	docker-compose down -v
	docker-compose up -d

tail:
	docker-compose logs -f

build:
	docker-compose up -d --build --force-recreate
	docker exec -it saude-laravel composer install --ignore-platform-reqs
	docker exec -it saude-laravel chown -R www-data:www-data /var/www/
	docker exec -it saude-laravel chmod -R g+rwX /var/www/
	docker exec -it saude-laravel cp -f .env.example .env
	docker exec -it saude-laravel php artisan key:generate
	docker exec -it saude-laravel php artisan migrate --seed
	docker exec -it saude-laravel php artisan jwt:secret

