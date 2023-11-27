build:
	cp .env.example .env
	cp backend/.env.example backend/.env
	docker-compose up --build -d
	docker exec -it warehouse-php bash -c "composer install && php artisan migrate && php artisan db:seed && php artisan key:generate"
down:
	docker-compose down

stop:
	docker-compose stop

test:
	docker exec -it warehouse-php bash -c "php artisan test"