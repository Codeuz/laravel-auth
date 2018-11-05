# laravel-auth
Laravel Package to scaffold all of the files required for authentication customization.

## Requirements
[Laravel](https://laravel.com/docs/5.5) >= 5.5

## Dependencies
[laravel-bootstrap](https://github.com/Codeuz/laravel-bootstrap) >= 1.1

## What does this imply by default?
- Laravel **Email Verification** System
- An additional **firstname** field for registration
- [Soft Deleting](https://laravel.com/docs/5.7/eloquent#soft-deleting) for the **User** Model
- **Custom templates** and **translations** (EN /FR) for both authentification **views** and **emails**
- Automatically install **Bootstrap** library (v3.3.7)

## Package Installation
    composer require cdz/laravel-auth
    composer update

## Install and scaffold all of the files

    php artisan cdz-auth:install
    
If you would like to overwrite existing files, use the --force switch:

    php artisan cdz-auth:install --force
    
If you would like to only scaffold the views, use the --views switch (Controllers, Notifications, Middlewares, **User** Model and routes will remain unchanged): 

    php artisan cdz-auth:install --views

* * *
Dont' forget to migrate after editing your configuration files.

    php artisan migrate

## Note
Emails translation data are into **ressources/lang/[LANG]/messages.php**