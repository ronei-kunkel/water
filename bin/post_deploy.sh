#!/bin/sh

# update application cache
# php artisan optimize

chmod -R 777 ./temp

# Caminho do arquivo de origem e destino
caminho_origem="/etc/secrets/.env"
caminho_destino="/var/www/water/.env"

# Verifica se o arquivo de origem existe
if [ -f "$caminho_origem" ]; then
    # Copia o arquivo para o destino
    cp "$caminho_origem" "$caminho_destino"
    echo "Arquivo copiado com sucesso!"
else
    echo "O arquivo de origem não existe."
fi

# start the application
php-fpm -D &&  nginx -g "daemon off;"
