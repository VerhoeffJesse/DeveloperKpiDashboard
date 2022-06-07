up:
	docker-compose up -d
	open "http://localhost:8080/dashboard"

watch:
	docker-compose run --rm  npm run watch

build:
	docker-compose build
	docker-compose run --rm nodejs_kpi_dashboard npm install
	docker-compose run --rm nodejs_kpi_dashboard npm run dev
	docker-compose up -d
	docker-compose run --rm php_kpi_dashboard php artisan migrate
	docker-compose run --rm php_kpi_dashboard php artisan db:seed --class=DatabaseSeeder
	docker-compose down

npm-update:
	docker-compose run --rm nodejs_kpi_dashboard update

down:
	docker-compose down


