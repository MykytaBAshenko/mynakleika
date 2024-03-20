## Что бы поднять проект

1. copy `.env.example` to `.env` 

Для локальной разработки лучше использовать docker
Подымаем контейнер

2. `docker-compose up -d`


### Backend часть 
#### (если не используем docker, то часть в командах `docker-compose exec app` пропускаем)
3. run `docker-compose exec app composer install` to install composer deps
4. run `docker-compose exec app php artisan key:generate` to generate app key
5. run `docker-compose exec app php artisan storage:link` to generate storage link
6. run db migrations `docker-compose exec app php artisan migrate`
7. seed initial data to db `docker-compose exec app php artisan db:seed`
8. generate laravel-passport api keys `docker-compose exec app php artisan passport:keys`


### Frontend часть
В проекте есть некоторая часть компонент написаная на vue  

8. run `yarn` or `npm install` для установки npm-пакетов
   (лучше не использовать node версии выше 14, может не собраться)

#
### Based on Laravel 5.7 Boilerplate

[![Latest Stable Version](https://poser.pugx.org/rappasoft/laravel-5-boilerplate/v/stable)](https://packagist.org/packages/rappasoft/laravel-5-boilerplate)

### License

MIT: [http://anthony.mit-license.org](http://anthony.mit-license.org)


Выливка файлов на сервер происходит с помощью ftp.

Host: s6.thehost.com.ua
User: wpgs
Password: (rCqBtT0

Перевыливать весь проект по фтп с заменой всех дирекорий и файлов очень накладно, поэтому я рекомендую выливать те файлы, в которые вносятся изменения, буквально поштучно. В случае с фронтом, где при пересборке билда меняются все файлы (css, js), можно перевыливать с заменой папок. Дропнул, к примеру, папку js на сервере и сразу залил свежую. 

Если надо вылить только фронт:

Собираем новый бандл для прода: npm run prod

Рабочая папка на сервере: /www/nakleika.com.ua
Это аналог папки public на локальной машине.
Как правило нужно перевылить две папки - css и js и обязательно файл mix-manifest.json

Если надо вылить бекенд:

Рабочая папка на сервере: /project
Как правило большинство изменений происходит в папках
app, bootstrap, config, resources и routes 

Если добавился новый пакет через composer, то тогда нужно перевылить и папку vendor.

Отдельно важный момент с файлом /app/Providers/AppServiceProvider.php
Для сервера он отличается от локальной версии и лучше или не менять его или при выливке папки app заливать его отдельно (лучше где то сохранить его локально).   
