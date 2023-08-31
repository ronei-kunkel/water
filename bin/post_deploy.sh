#!/bin/sh

# update application cache
# php artisan optimize

chmod -R 777 ./temp

# start the application
php-fpm -D &&  nginx -g "daemon off;"
