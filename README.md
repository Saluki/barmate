# Barmate

POS web application

## Screenshots

![Dashboard screenshots](http://s2.postimg.org/jobpfx4op/barmate_S1.png)

![Menu screenshot](http://s2.postimg.org/rfsfeh8u1/barmate_S2.png)

![Users screenshot](http://s2.postimg.org/eacx8deyh/barmate_S3.png)

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