## Polaris
Laravel rest-api microservice
# Install app
- clone repository
- run commands :
- docker-compose run --rm composer install
- copy .env.example .env  - (in .env set correct db credentials) : 
	DB_CONNECTION=mysql
	DB_HOST=polaris-mysql
	DB_PORT=3306
	DB_DATABASE=polaris_db
	DB_USERNAME=test_user
	DB_PASSWORD=test_pass
- docker-compose run --rm artisan key:generate
- docker-compose run --rm artisan migrate
- docker-compose run --rm artisan storage:link
- docker-compose up -d

Open app : http://localhost:8086/
Open php-myadmin : http://localhost:8087/

