# Barmate

Modern and intuitive POS web application written with the Laravel framework.

## Table of contents

- [Screenshots](#screenshots)
- [Quick start](#quick-start)
- [Copyright and license](#copyright-and-license)

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
* Copy **.env.example** to **.env** and adapt the values to your configuration (application URL and database)
```
cp .env.example .env
```
* Set the application key with
```
php artisan key:generate
```
* Install the database by running
```
php artisan migrate
php artisan db:seed
```

Note that on some configurations, you need to specify the correct rights for the storage folder:
```
chmod -R 777 storage/
```

That's it! You can now test Barmate by going to you application URL, go to the login page and enter the following credentials: 
```
admin@barmate.com
password
```

## Copyright and license

Barmate is released under the [MIT license](https://github.com/Saluki/Barmate/blob/master/LICENSE). Feel free to suggest a feature, report a bug, or ask something: [https://github.com/Saluki/Barmate/issues](https://github.com/Saluki/Barmate/issues)