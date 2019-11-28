# Dockerizando la aplicación

## Fichero Dockerfile

```Dockerfile
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
```
Vamos a comentar orden por orden el funcionamiento de este Dockerfile:

- FROM php:7.2-alpine: como imagen base para nuestra aplicación se ha optado por elegir la imagen oficial de php que trae instaladas la mayor parte de las herramientas que necesitamos para ejecutar la aplicación. Se ha elegido la versión _7.2_ porque es la versión de php en la que corre la aplicación y por último se ha elegido la variante de SO de _alpine_ por ser el más ligeros de todos ocupando la imagen final 107MB.
- WORKDIR /web: nos movemos al directorio donde se instalarán todos los elementos de la app.
- Órdenes COPY: copiamos solo los elementos necesarios para hacer funcionar la aplicación web.
- COPY --from=composer:latest /usr/bin/composer /usr/bin/composer: instalamos _composer_ en nuestro contenedor, copiándolo directamente desde la imagen oficial de composer.
- RUN composer install --no-dev --optimize-autoloader: instalamos las dependencias de la aplicación. (Solo las necesarias en producción, no las de desarrollo).
- ENV PORT=8080: declaramos la variable de entorno PORT con el valor 8080. Este será el puerto donde escuchará el servidor. Es necesario declarar este puerto para el posterior despliegue en los PaaS.
- EXPOSE 8080: (orden meramente informativa, se podría quitar) decimos que estamos exponiendo el puerto 8080 al exterior del contenedor.
- CMD composer start-docker: orden por defecto cuando se lanza el contenedor. Ejecuta la orden de composer para iniciar el servicio que lanza la aplicación para que escuche en 0.0.0.0:8080.