# Test task, payment system prototype, BACKEND

``` bash
$ git clone https://github.com/linghart-y/pay-backend.git

$ cd pay-backend
$ composer install

!!! Configure .env to work correctly with the database !!!

$ php artisan migrate
$ php artisan seed

$ php artisan jwt:secret

$ php artisan serve

```
