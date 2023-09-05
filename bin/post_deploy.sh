#!/bin/sh

# update application cache
# php artisan optimize

php ca.php;


# start the application
php-fpm -D &&  nginx -g "daemon off;"
