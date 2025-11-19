.PHONY: up down rebuild clean init-theme

up:
	docker-compose up -d

down:
	docker-compose down

rebuild:
	docker-compose down
	docker-compose build --no-cache
	docker-compose up -d

init-theme:
	@echo "Création du thème jardin-de-famille dans wp-data/wp-content/themes/"
	@mkdir -p ../wp-data/wp-content/themes/jardin-de-famille
	@docker exec jardin_wordpress chown -R www-data:www-data /var/www/html/wp-content/themes/jardin-de-famille

clean:
	docker-compose down -v
	docker system prune -af
