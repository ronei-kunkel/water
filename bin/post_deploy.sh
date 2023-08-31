#!/bin/sh

# update application cache
# php artisan optimize

pwd

# start the application
php-fpm -D &&  nginx -g "daemon off;"
