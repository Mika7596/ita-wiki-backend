.PHONY: up down clean serve cache-clear route-clear

up: ## Bring up the Docker containers and build images if necessary
	docker compose build --no-cache
	docker compose up -d

down: ## Stop and remove the Docker containers
	docker compose down --volumes --remove-orphans

clean: ## Stop, remove and prune everything related to the project
	docker compose down --volumes --remove-orphans
	docker system prune --all --volumes -f
	docker network prune -f
	docker image prune -a -f

serve: ## Start the Laravel server in the container
	docker exec -it php php artisan serve --host=0.0.0.0 --port=8000

cache-clear: ## Clear the cache
	docker exec -it php php artisan config:clear
	docker exec -it php php artisan config:cache
	docker exec -it php php artisan cache:clear

route-clear: ## Clear the route cache
	docker exec -it php php artisan route:clear
	docker exec -it php php artisan route:cache
