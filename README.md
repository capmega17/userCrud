# Capmega/userCrud
A package to create, delete and update users

# Installation
   ```sh
   composer require capmega/user-crud
   ```
# Configuration
To be able to use the content of the package it is necessary to publish it, with the following command it will be enough:
  ```sh
   php artisan vendor:publish --provider="Capmega\UserCrud\UserCrudServiceProvider" --tag=users-crud --force
   ```


