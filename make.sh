#!/bin/bash

php artisan clear-compiled
composer dump-autoload
php artisan optimize

php artisan migrate:reset
php artisan migrate
php artisan db:seed

kdialog --title "Pay" --passivepopup "Пересборка завершена" 10
