# Laravel Tasks/Projects Platform application

To build the project:
- Copy the repository
- In the main directory run ```composer install```
- In the frontend directory run ```npm install```
- In the main directory run ```docker compose build --no-cache``` and after it has finished building ```docker compose up -d```
- Inside the php container make sure you run the laravel migrations ```php artisan migrate``` ( ```php artisan migrate:install``` in case the previous did not work )
- After that generate APP token with ```php artisan key:generate``` and ```php artisan jwt:secret``` ( might require config clear with ```php artisan config:clear``` )
- As the final step please run ```php artisan db:seed``` to seed database with example data

Your project should be available under these URLs:
- Frontend http://localhost:5137 ( this is the URL that should be used )
- Laravel http://localhost:8000
- Swagger UI http://localhost:8000/api/documentation ( OpenAPI for testing some configured endpoints )
- PHPMyAdmin http://localhost:8080 ( user and password are both "laravel" )


## Features

- PHP 8.4
- Vue.js ( version 3 )
- MySQL with PHPMyAdmin
- Nginx
- Swagger UI ( to update Swagger endpoints use ```php artisan l5-swagger:generate``` in the main directory )

## Environment Variables

To run this project, you will need to add/update the following environment variables to your .env file

Database:
```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel_api_db
DB_USERNAME=laravel
DB_PASSWORD=laravel
```

JWT:
```
JWT_SECRET=XXX
```
