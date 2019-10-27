######################################
.PHONY: instalar
instalar: vendor/
	@composer install

.PHONY: test
test: tests/
	@vendor/bin/phpunit

.PHONY: start, stop
start:
	 docker run --name phppm -v `pwd`:/var/www -p 8080:80 phppm/nginx --bootstrap=laravel --static-directory=public/&

stop:
	docker stop phppm
	docker rm phppm