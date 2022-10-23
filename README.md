# eTES

## Установка и запуск

склонировать репу, перейти в корень

установить зависимости
1) docker-compose run --rm fpm-auth composer install
2) docker-compose run --rm fpm-task composer install
3) docker-compose run --rm fpm-billing composer install

docker-compose up

накатить схемы БД
1) docker-compose run --rm fpm-auth php bin/console doctrine:database:create
2) docker-compose run --rm fpm-task php bin/console doctrine:database:create
3) docker-compose run --rm fpm-billing php bin/console doctrine:database:create

накатить миграции
1) docker-compose run --rm fpm-auth php /app/bin/console doctrine:migrations:migrate
2) docker-compose run --rm fpm-task php /app/bin/console doctrine:migrations:migrate
3) docker-compose run --rm fpm-billing php /app/bin/console doctrine:migrations:migrate

cгенерировать ключи для токена
```docker-compose run --rm fpm-auth php bin/console lexik:jwt:generate-keypair```
дальше надо скопировать /app/Auth/config/jwt/* в /app/Billing/config/jwt/* и /app/TaskTracker/config/jwt/*

поправить /etc/hosts
   ```
   127.0.0.1	rest.ates-task
   127.0.0.1	rest.ates-billing
   127.0.0.1	rest.ates-auth
   127.0.0.1	db.ates-task
   127.0.0.1	db.ates-billing
   127.0.0.1	db.ates-auth
   127.0.0.1	rabbit.ates
   ```

Profit!

Примеры запросов подготовлены тут
   ```
   /app/Auth/tests/test_auth_api.http
   /app/TaskTracker/tests/test_task_api.http
   /app/Billing/tests/test_billing_api.http
   ```