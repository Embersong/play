Документация
==================================

# Как развернуть и запустить проект #

Перейти в папку deploy
`cd .\deploy`

Выполнить `docker-compose up -d`

Настроить файл .ENV в соответствии с docker-compose.yml
Указать случайную строку для JWT_SECRET

В контейнере php-fpm выполнить
`composer install`
и запустить миграции
`php artisan migrate:fresh --seed`

Коллекция запросов для postman в папке deploy

## Доступ к сервисам ##

Service|Address outside containers
-------|--------------------------
Webserver|[localhost:8000](http://localhost:8000)
PostgreSQL|**host:** `localhost`; **port:** `8004`

## Доступ к хостам внутри среды ##

Пример конфигурации:

Service|Hostname|Port number
------|---------|-----------
php-fpm|php-fpm|9000
Postgres|postgres|5432 (default)


# Права для файлов приложения #

`docker-compose exec php-fpm chown -R www-data:www-data /app/public`

## Xdebug 2

Если нужен xdebug добавить в конфиг
php-fpm/php-ini-overrides.ini:

## Xdebug 3


### For linux:

```
xdebug.mode=debug
xdebug.discover_client_host=true
xdebug.start_with_request=yes
xdebug.client_port=9000
```

### For macOS and Windows:

```
xdebug.mode = debug
xdebug.client_host = host.docker.internal
xdebug.start_with_request = yes
```

## Добавить секцию “environment” для php-fpm service in docker-compose.yml:

```
environment:
  PHP_IDE_CONFIG: "serverName=Docker"
```
