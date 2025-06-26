## Prequisite

PHP ≥ 8.1  
Composer  
MySQL  
Node.js (v20) + npm  
OpenAI API key  

## Setting up

$ composer install  
$ npm install  
$ npm run build  
  
Put in correct environment variable, the database credential and OpenAI API key  

OPENAI_API_KEY=sk-xxxxxxxxxxxxxxxxxxxx
DB_CONNECTION=mysql
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
  
migration schema to MySQL database  
$ php artisan migrate  

start up the server  
$ php artisan serve  

## Info

-admin portal route (/works)  
-candidate portal route (/job-listing)  

1. create job in admin portal first
2. then candidate can do job match with resume
