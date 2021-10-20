# Capmega/userCrud
A package to create, delete and update users

# Installation
You can install the package via composer:
   ```sh
   composer require capmega/user-crud
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


