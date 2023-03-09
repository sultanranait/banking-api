

Perform below steps for project setup:

1- clone project from repo
2- open laravel/ directory in terminal
3- run following command to install all vendors and packages
  
  composer install

  => When above gets completed
4- update .env file with DB credentials and other needed env variables
5- Run following commands to set/save .env updates and seeder classes safely in project scope:

  php artisan key:generate
  php artisan config:cache
  composer dump-autoload

6- Run following commands to migrate DB tables and seeding data for tables

  php artisan migrate
  php artisan db:seed

7- Run following command to run unit tests of business logics and helper methods of AccountServices and TransferServices API

  php artisan test

8- Find 'Bank API.postman_collection.json' file in root directory (same location where setup_readme.txt resides)
  
  Import 'Bank API.postman_collection.json' in Postman to test and work with API endpoints
  API documentation is published, Go to the following url to get complete API doc
    https://documenter.getpostman.com/view/8523464/2s93JnTRSj
