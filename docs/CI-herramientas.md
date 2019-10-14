# CI y herramientas de construcción

## Herramientas de tests e integración continua

Para testear la aplicación se ha optado por utilizar *phpunit* que se trata del entorno por excelencia para realizar tests unitarios en PHP, permite crear tests de manera sencilla y haciendo las comprobaciones a través de assertions (como la mayoria de software dedicado a realizar tests) para verificar que el resultado de una función o parte del código es el esperado.

En cuanto a la herramienta de integración continua se ha utilizado *Travis CI* principalmente porque permite testear proyectos open source (como este) de manera gratuita. Otra razón tan importante o más, es que permite crear configuraciones muy fáciles y da soporte completo a PHP (hay muchos otros servicios de CI que no lo hacen sin plugins o con configuraciones muy complejas).

### Configuración Travis-CI

Una vez integrado nuestro repositorio con travis-ci.com se ha configurado el fichero .travis.yml siguiente:
```yml
language: php
before_script: composer install
```
Como vemos es un fichero de configuración bastante simple, lo primero que hacemos es indicar a travis que el lenguaje que vamos a usar es php. Hay que añadir que solo se testea en la última versión porque nuestra aplicación solo es compatible con versiones posteriores a la 7.2. Posteriormente se le indica que antes de ejecutar ningún script instale las dependecias de nuestro proyecto con `composer install`. Por último quedaría decir a travis que ejecute nuestros tests, pero como usamos *phpunit* no es necesario porque es el script que travis usa por defecto.

### Configuración CircleCI:

En cuanto a CircleCI se ha hecho la siguiente configuración:
```yml
# config.yml
version: 2 # use CircleCI 2.0

jobs: # a collection of steps
  build: # runs not using Workflows must have a `build` job as entry point
    docker: # run the steps with Docker 
      - image: circleci/php # ...with this image as the primary container; this is where all `steps` will run
    steps:
      - checkout
      - run: sudo composer self-update
      - run: composer install
      - run: ./vendor/bin/phpunit
```

Sigue una estructura similiar a la de travis, la única diferencia es que indicamos de forma explicita que utilizamos un contenedor de docker para correr los tests. Al igual que en el caso anterior, usamos la ultima versión de php porque nuestra applicación no es compatible con versiones anteriores. Por último, actualizamos nuestro gestor de dependencias, instalamos las dependencias e indicamos que corra los tests con phpunit.

## Herramienta de construcción y dependecias

En este caso se ha usado composer para gestionar las dependecias de toda la aplicación y para poder instalar con un solo comando `composer install` todas ellas. Estas dependencias se encuentran definidas en el fichero composer.json generado automaticamente al crear un proyecto con lumen y modificado para que se ajuste a nuestro proyecto que contiene la siguiente estructura:
```json
{
    // Metadatos: nombre, descripción, licencia
    "name": "laravel/lumen",
    "description": "The Laravel Lumen Framework.",
    "keywords": ["framework", "laravel", "lumen"],
    "license": "MIT",
    "type": "project",
    // Dependencias
    "require": {
        "php": "^7.2",
        "dompdf/dompdf": "^0.8.3",
        "laravel/lumen-framework": "^6.0"
    },
    // Dependencias tests y build tool
    "require-dev": {
        "fzaninotto/faker": "^1.4",
        "phpunit/phpunit": "^8.0",
        "mockery/mockery": "^1.0",
        "phing/phing": "2.*"
    },
    // autoload, rutas
    "autoload": {
        "classmap": [
            "database/seeds",
            "database/factories"
        ],
        "psr-4": {
            "App\\": "app/"
        }
    },
    "autoload-dev": {
        "classmap": [
            "tests/"
        ]
    },
    // Creación .env
    "scripts": {
        "post-root-package-install": [
            "@php -r \"file_exists('.env') || copy('.env.example', '.env');\""
        ]
    },
    // flags instalación
    "config": {
        "preferred-install": "dist",
        "sort-packages": true,
        "optimize-autoloader": true
    },
    "minimum-stability": "dev",
    "prefer-stable": true
}
```
En las primeras líneas indicamos algunos metadatos de nuestro proyecto, lo más importante de ahí es que indicamos la licencia, concorde con la elegida en nuestro repositorio de GitHub. Posteriormente, en el apartado require, es donde definimos nuestras dependencias propiamente dichas que son: php(^7.2), dompdf y el (micro)framework lumen. En la siguiente entrada, require-dev, definimos las dependencias de desarrollo, básicamente los paquetes que nos permiten crear tests y la herramianta de construcción:
- phpunit: para correr los tests
- fzaninotto/faker: Para generar datos de prueba
- mockery: para crear objetos de prueba para nuestros tests
- Phing: Build tool

En los siguientes apartados definimos las rutas por defecto de nuestro proyecto como el namespace de nuestra aplicación, el directorio de las clases para bbdd y el directorio de las clases para tests. Por último, se define un script para crear un fichero .env a partir de .env.example si no existe y se definen varios parámetros de instalación.