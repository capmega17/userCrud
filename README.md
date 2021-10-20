# Capmega/userCrud
A package to create, delete and update users

# Installation
You can install the package via composer:
   ```sh
   composer require capmega/user-crud
   ```

If your laravel version is <7 add this code in your composer.js file:
   ```sh
   "minimum-stability": "dev",
   "prefer-stable" : true
   ```

To detect the routes file it is necessary to add the following code in config / app.php
   ```sh
   'providers' => [
      Capmega\UserCrud\UserCrudServiceProvider::class,
   ],
   ```

# Configuration

To be able to use the content of the package it is necessary to publish it, with the following command it will be enough:
  ```sh
   php artisan vendor:publish --provider="Capmega\UserCrud\UserCrudServiceProvider" --tag=users-crud --force
   ```


