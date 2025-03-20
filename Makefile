.PHONY: build up down restart app

docker_app=docker exec -it rd_app
docker_app_no_deps=docker-compose run --rm --no-deps app

build:
	@docker-compose up -d --build

up:
	@docker-compose up -d

down:
	@docker-compose down

restart:
	@make down
	@make up

app:
	@$(docker_app) bash
