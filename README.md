# laravel-MasterPass

Helps you set a master password in .env file and login into a any account with that.

This means that each account can be logged in with 2 passwords. The real one and the master one.

# Installation



# Config

The only thing you should do is to put your master password in the .env file:

```
MASTER_PASSWORD=mySecretMasterPass
```

or you can put the hashed version of the password here to hide it from stilling eyes. :eyes:

```
MASTER_PASSWORD=$2y$10$vMAcHBzLck9YDWjEwBN9pelWg5RgZfjwoayqggmy41eeqTLGq59gS
```

both of the options will work just fine.


# Warning

Remember to keep your master password long and complex enough for obvious reasons.


### :exclamation: Security
If you discover any security related issues, please email imanghafoori1@gmail.com instead of using the issue tracker.


### :star: Your Stars Make Us Do More :star:
As always if you found this package useful and you want to encourage us to maintain and work on it, Please press the star button to declare your willing.


### More from the author:

https://github.com/imanghafoori1/laravel-terminator

https://github.com/imanghafoori1/laravel-widgetize

https://github.com/imanghafoori1/laravel-anypass
