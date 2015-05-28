# Barmate

POS web application

## Quick start

Follow these instructions to install Barmate:

* Install [Composer](https://getcomposer.org/), [Npm](https://www.npmjs.com/), [Bower](http://bower.io/) and [Grunt](http://gruntjs.com/)
* Install the dependencies with
```
composer install
npm install
bower install
```
* Copy **.env.example** to **.env** and adapt the values to your configuration
* Set the application key with
```
php artisan key:generate
```
* Install the database by running
```
php artisan migrate
php artisan db:seed
```

## Copyright and license

Barmate is released under the [MIT license](https://github.com/Saluki/Barmate/blob/master/LICENSE).