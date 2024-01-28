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


### Frontend часть
В проекте есть некоторая часть компонент написаная на vue  

8. run `yarn` or `npm install` для установки npm-пакетов
   (лучше не использовать node версии выше 14, может не собраться)

#
### Based on Laravel 5.7 Boilerplate

[![Latest Stable Version](https://poser.pugx.org/rappasoft/laravel-5-boilerplate/v/stable)](https://packagist.org/packages/rappasoft/laravel-5-boilerplate)

### License

MIT: [http://anthony.mit-license.org](http://anthony.mit-license.org)
