vendor: composer.lock
	composer install

phpstan: vendor
	vendor/bin/phpstan analyze -c phpstan.neon

test: vendor
	vendor/bin/atoum -d Tests