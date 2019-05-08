cd eWalletAPI
call composer install
call copy .env.example .env
call php artisan key:generate
start cmd /k "composer serve"
start "" http://localhost:8000
