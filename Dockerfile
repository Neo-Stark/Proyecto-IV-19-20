FROM php:7.2-alpine

WORKDIR /web

COPY app app
COPY bootstrap bootstrap
COPY database database
COPY public public
COPY resources resources
COPY routes routes
COPY storage storage

COPY composer.json .
COPY composer.lock .
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

ENV PORT=8080
EXPOSE 8080
CMD composer start-docker