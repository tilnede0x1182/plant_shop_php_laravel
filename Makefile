
run:
	clear && php artisan serve --port=8003

db-seed:
	clear && php artisan db:seed

db-reset:
	clear && php artisan db:seed
