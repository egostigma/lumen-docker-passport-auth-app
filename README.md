# lumen-docker-passport-auth-app

## Usage

Installing dependencies:
- `docker run --rm -v $(pwd):/app composer install`

Start docker image:
- `docker-compose up -d`

Run artisan commands:
- `docker-compose exec app php artisan key:generate`
- `docker-compose exec app php artisan migrate`

Install encryption keys and other necessary stuff for Passport:
- `docker-compose exec app php artisan passport:install`

Copy the generated Password Grant Client ID & Secret to .env:
- `PASSPORT_PERSONAL_ACCESS_CLIENT_ID={Password Grant Client ID}`
- `PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET={Password Grant Client Secret}`

(Optional) Set permissions on the project directory so that it is owned by your non-root user:
- `sudo chown -R $USER:$USER ./`
