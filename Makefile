
run:
	clear && php artisan serve --port=8003

build-css-run:
	clear && npm run build && php artisan serve --port=8003

db-seed:
	clear && php artisan db:seed

db-reset:
	clear && php artisan db:seed
