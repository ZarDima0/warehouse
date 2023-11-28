build:
	cp .env.example .env
	cp backend/.env.example backend/.env
	chmod o+w backend/storage/ -R
	chown -R www-data:www-data backend/storage
	docker-compose up --build -d
	docker exec -it warehouse-php bash -c "composer install && php artisan migrate && php artisan db:seed && php artisan key:generate"
down:
	docker-compose down

stop:
	docker-compose stop

test:
	docker exec -it warehouse-php bash -c "php artisan test"