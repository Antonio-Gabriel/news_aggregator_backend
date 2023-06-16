#!/bin/sh

dockerize -wait tcp://db:3306 -timeout 40s

chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

composer install --optimize-autoloader --no-dev

php artisan key:generate
php artisan migrate:refresh
php artisan db:seed;
php artisan sync:external-news;

chmod -R 777 \
/var/www/storage \
/var/www/bootstrap/cache

php artisan serve --host=0.0.0.0 --port=8080