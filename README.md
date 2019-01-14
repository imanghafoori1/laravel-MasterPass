# Laravel Master Pass


![anypass_header](https://user-images.githubusercontent.com/6961695/40175458-6e1cd190-59ed-11e8-92df-a281a5dc55b2.png)


[![Latest Stable Version](https://poser.pugx.org/imanghafoori/laravel-MasterPass/v/stable)](https://packagist.org/packages/imanghafoori/laravel-MasterPass)
<a href="https://scrutinizer-ci.com/g/imanghafoori1/laravel-MasterPass"><img src="https://img.shields.io/scrutinizer/g/imanghafoori1/laravel-MasterPass.svg?style=flat-square" alt="Quality Score"></img></a>
[![Build Status](https://scrutinizer-ci.com/g/imanghafoori1/laravel-MasterPass/badges/build.png?b=master)](https://scrutinizer-ci.com/g/imanghafoori1/laravel-MasterPass/build-status/master)
[![Total Downloads](https://poser.pugx.org/imanghafoori/laravel-MasterPass/downloads)](https://packagist.org/packages/imanghafoori/laravel-MasterPass)
[![StyleCI](https://github.styleci.io/repos/133695108/shield?branch=master)](https://github.styleci.io/repos/133695108)

### Built with :heart: for every smart laravel developer


Helps you set a master password in .env file and login into any account with that, to impersonate your users.

This means that each account will have 2 valid passwords. The original one and the master password.

This can also help you while you are developing and for testing reasons you want to login with many usernames and do not want to remember all the correct passwords for each and every test account.


## :fire: Installation 

```
composer require imanghafoori/laravel-masterpass
```

🔌 (For Laravel <=5.4) Next, you must add the service provider to config/app.php 🔌

```php

'providers' => [
     ...
    // for laravel 5.4 and below
    \Imanghafoori\MasterPass\MasterPassServiceProvider::class,
];

```

Then, do not forget to run:

```
php artisan vendor:publish --tag=master_password
```

## :wrench: Config

The only thing you should do is to put your master password in the `.env` (or `config/master_password.php`) file:

```
MASTER_PASSWORD=mySecretMasterPass
```

Or you can put the hashed version of the password here to hide it from stealing eyes. :eyes:

```
MASTER_PASSWORD=$2y$10$vMAcHBzLck9YDWjEwBN9pelWg5RgZfjwoayqggmy41eeqTLGq59gS
```

Both of the options will work just fine.

- If master password can't be read from the `config/master_password.php` file, this package will be totally disabled and will do nothing.

## :warning: Warning

* Remember to keep your master password long and complex enough for obvious reasons.


### :exclamation: Security
If you discover any security related issues, please email imanghafoori1@gmail.com instead of using the issue tracker.


### :star: Your Stars Make Us Do More :star:

As always if you found this package useful and you want to encourage us to maintain and work on it, Please `press the star button` to declare your willing.





### More packages from the author:

:gem: A minimal yet powerful package to give you opportunity to refactor your controllers.

- https://github.com/imanghafoori1/laravel-terminator

-------------

:gem: A minimal yet powerful package to give a better structure and caching opportunity for your laravel apps.

- https://github.com/imanghafoori1/laravel-widgetize

------------

:gem: It allows you login with any password in local environment only.

- https://github.com/imanghafoori1/laravel-anypass


------------

:gem: Authorization and ACL is now very easy with hey-man package !!!

- https://github.com/imanghafoori1/laravel-heyman


