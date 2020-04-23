.PHONY: all build deps composer-install composer-update composer reload test run-tests start stop destroy doco rebuild play run-play

current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

# Main targets
build: deps start

deps: composer-install

# Composer
composer-install: CMD=install
composer-update: CMD=update

# Usage example (add a new dependency): `make composer CMD="require --dev symfony/var-dumper ^4.2"`
composer composer-install composer-update:
	@docker run --rm --interactive --tty --volume $(current-dir):/app --user $(id -u):$(id -g) \
		clevyr/prestissimo $(CMD) \
			--ignore-platform-reqs \
			--no-ansi \
			--no-interaction

reload:
	@docker-compose exec php-fpm kill -USR2 1

# Tests

test:
	@docker exec -it shogi-php make run-tests

run-tests:
	mkdir -p build/test_results/phpunit
	./vendor/bin/phpunit --exclude-group='disabled' --log-junit build/test_results/phpunit/junit.xml tests

# Docker Compose
start:
	@docker-compose up -d

stop: CMD=stop

destroy: CMD=down

# Usage: `make doco CMD="ps --services"`
# Usage: `make doco CMD="build --parallel --pull --force-rm --no-cache"`
doco stop destroy:
	@docker-compose $(CMD)

rebuild:
	docker-compose build --pull --force-rm --no-cache
	make deps
	make start

play:
	@docker exec -it shogi-php make run-play

run-play:
	./bin/game
