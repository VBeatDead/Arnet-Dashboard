How to run


download the coressponding .env file

php artisan key:generate
php artisan migrate:fresh
php artisan storage:link
php artisan session:table
php artisan db:seed --class=UsersSeeder