#!/usr/bin/env bash
set -e

cd /app

# Ensure .env exists (Coolify may inject a fresh one without APP_KEY).
if [ ! -f .env ]; then
    cp .env.production .env
fi

# Ensure APP_KEY is present; generate one into .env if missing.
if ! grep -qE '^APP_KEY=base64:' .env; then
    php artisan key:generate --force
fi

# SQLite database.
mkdir -p /app/database
touch /app/database/database.sqlite

# Storage symlink (ignore if it already exists).
php artisan storage:link || true

# Cache config AFTER ensuring APP_KEY so cached config carries the key.
php artisan config:clear
php artisan config:cache
php artisan route:cache || true

# Migrate + seed (idempotent seeders).
php artisan migrate --force --seed || php artisan migrate --force

# Serve.
exec php artisan serve --host=0.0.0.0 --port=8080
