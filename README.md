# Inventory Checker Api

API for Kiosk application to check product and stock information in different shops. Searching by product name, EAN, authors with typo tolerance.

Product data will be synced with ERP system by external script. Remember to rebuild search index after data update.

How to set up Kiosk in Windows:
https://learn.microsoft.com/pl-pl/mem/intune/configuration/kiosk-settings-windows


### Tech stack
[Laravel](https://laravel.com), [Meilisearch](https://meilisearch.com) search engine. Frontend will be available in seperate repository ([React](https://react.dev)). 



### TODO:
1. Product images
2. Product prices


### Installation
Using Laravel Sail:
```
cp .env.example .env
```
```
docker run --rm \
-u "$(id -u):$(id -g)" \
-v "$(pwd):/var/www/html" \
-w /var/www/html \
laravelsail/php82-composer:latest \
composer install --ignore-platform-reqs
```
```
./vendor/bin/sail up -d
```
```
./vendor/bin/sail artisan migrate
```
