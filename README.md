# Autoshop (API Laravel + FrankenPHP)

## Requisitos
- Docker 27+
- Docker Compose v2

## Subir local
```bash
docker compose up -d
docker compose exec frankenphp bash -lc "cd /app/backend && composer install && php artisan key:generate && php artisan migrate"
