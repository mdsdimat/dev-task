# dev-task
Dev Task

PHP 7.3 MySQL 5.7.27

create .env,
if need proxy? set APP_PROXY,
set parameter for database
-composer install
-php artisan migrate

create Cron entry for sheduler
* * * * * php artisan schedule:run >> /dev/null 2>&1
