env = ./.env.example

ifneq ("$(wildcard ./.env)","")
    env = ./.env
endif

sail = ./vendor/bin/sail

include ${env}
export

build:
	pwd
	docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v $(shell pwd):/var/www/html \
        -w /var/www/html \
        laravelsail/php80-composer:latest \
        composer install --ignore-platform-reqs
	cp .env.example .env
	${sail} up -d
	${sail} artisan key:generate
	${sail} artisan migrate:fresh --seed

up:
	${sail} up -d

composer-update:
	${sail} up -d
	${sail} composer update

composer-install:
	${sail} up -d
	${sail} composer install

db-update:
	${sail} up -d
	${sail} artisan migrate:fresh --seed

down:
	${sail} down

test:
	${sail} artisan test --stop-on-failure

generate-api-doc:
	${sail} artisan l5-swagger:generate

optimize-clear:
	${sail} artisan optimize:clear

