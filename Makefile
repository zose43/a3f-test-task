init: app-build app-init composer-install
start: app-start
stop: down

app-build:
	docker-compose build --pull

app-init:
	docker-compose up -d

composer-install:
	docker-compose run --rm php-cli composer install

app-start:
	docker-compose run --rm php-fpm php index.php $(url)

down:
	docker-compose down --remove-orphans --volumes --rmi local
