# :key: Laravel Master Pass 


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

🔌 (For Laravel <=5.4) Next, you must add the service provider to config/app.php

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


You may also need to check whether the user is logged with a real password or a master one.

```php

$bool = Auth::isLoggedInByMasterPass();

```
Or in blade files :

```php

@if(Auth::isLoggedInByMasterPass())

     Your are here by master password.

@endif

```

## Advanced Usage:

### Provide the master pass from a custom source :

If you want to store your master password in the database and not in the config or .env file then :

```php

\Event::listen('masterPass.whatIsIt?', function ($user, $credentials) { 
      return DB::table(...;
});

```

### Limit the usage of master password :

Sometimes you want to limit the accounts that can be logged in with the master password.

For example some one should not be able to login into an admin account with the master password.

In that case, you can listen to the 'masterPass.canBeUsed?' event and check your conditions and return `false` from it.

Sample :

```php

public function boot () {

     // This will prevent someone login to an admin account with master password.
     \Event::listen('masterPass.canBeUsed?', function ($user, $credentials) {
          if ($user->isAdmin) {
               return false;
          }
     });
          
}

```
Here the `$user` variable is referring to the user which the credentials relates to.


### Not every body should be allowed to use master password:

To be really secure and sleep better at night, You may only allow admin users with special privileges to use the master password.

That way, they have to login as admin first and only then, use master password to login into a normal user account.

```php

public function boot () {

     // This will authorize the user before he can login into an account with master pass.
     \Event::listen('masterPass.canBeUsed?', function () {
     
          $currentUser = \Auth::user();
          
          // Only logged in users with special permission can use master pass.
          
          if (is_null($currentUser) or ! $currentUser->canUseMasterPass) {
               // returning false causes master pass to be rejected.
               return false;        
          }

     });
          
}

```

### Is it Compatible with other custom guards ?

Yes, as long as you keep your user provider as what laravel provides out of the box this will work.

Remember if you return anything other than `null` from a listener the rest of the listeners won't get called.

So if you want to continue the checking process return `null`.

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


