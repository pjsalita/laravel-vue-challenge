#!/bin/sh
set -e

if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate
fi

if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
fi

php artisan migrate:fresh --seed

if [ -f public/hot ]; then
    rm public/hot
fi

APP_ENV_VALUE="${APP_ENV:-}"
if [ "$APP_ENV_VALUE" = "local" ] || [ "$APP_ENV_VALUE" = "development" ]; then
    npm run dev &
else
    npm run build
fi

exec "$@"
