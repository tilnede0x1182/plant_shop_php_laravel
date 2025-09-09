
run:
	clear && php artisan serve --port=8003

seed:
	clear && php artisan db:seed

redis:
# Ce projet repose sur un serveur Redis, qu'il faut lancer en amont du projet
	sudo service redis-server start

db-reset:
	clear && php artisan db:seed
