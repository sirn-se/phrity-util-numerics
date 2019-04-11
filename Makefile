# Default
all: deps-install


# DEPENDENCY MANAGEMENT

# Updates dependencies according to lock file
deps-install: composer.phar
	./composer.phar --no-interaction install

# Updates dependencies according to json file
deps-update: composer.phar
	./composer.phar self-update
	./composer.phar --no-interaction update

# Updates dependencies according to lock file, production optimized
deps-prod: composer.phar
	./composer.phar --no-interaction install --no-dev --optimize-autoloader


# TESTS AND REPORTS

# Code standard check
cs-check: composer.lock
	./vendor/bin/phpcs --standard=PSR1,PSR2 --encoding=UTF-8 --report=full --colors src tests

# Check inline documentation
docs-check: composer.lock
	./vendor/bin/phpdoc --validate -d src,tests -t phpdoc-temp
	rm -rf phpdoc-temp

# Run tests
test: composer.lock
	./vendor/bin/phpunit

# Run tests with clover coverage report
coverage: composer.lock
	./vendor/bin/phpunit --coverage-clover build/logs/clover.xml
	./vendor/bin/php-coveralls -v

# INITIAL INSTALL

# Ensures composer is installed
composer.phar:
	curl -sS https://getcomposer.org/installer | php

# Ensures composer is installed and dependencies loaded
composer.lock: composer.phar
	./composer.phar --no-interaction install