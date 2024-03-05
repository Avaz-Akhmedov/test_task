Установить зависимости
composer install

Скопируйте .env файл
cp .env.example .env

Сгенерировать ключ приложения
php artisan key:generate

Запустите миграции и cидеры
php artisan migrate --seed

Для запуска тестов
php artisan test

Запустите сервер
php artisan serve