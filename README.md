# PrintCloud

[![Build Status](https://travis-ci.com/Neo-Stark/Proyecto-IV-19-20.svg?branch=master)](https://travis-ci.com/Neo-Stark/Proyecto-IV-19-20)
[![CircleCI](https://circleci.com/gh/Neo-Stark/Proyecto-IV-19-20.svg?style=svg)](https://circleci.com/gh/Neo-Stark/Proyecto-IV-19-20)
[![PPM Compatible](https://raw.githubusercontent.com/php-pm/ppm-badge/master/ppm-badge.png)](https://github.com/php-pm/php-pm)
[![StyleCI](https://github.styleci.io/repos/208740465/shield?branch=master)](https://github.styleci.io/repos/208740465)

Despliegue: https://printcloud.azurewebsites.net

Contenedor: https://printcloud-docker.azurewebsites.net

Contenedor 2: https://printcloud-docker.herokuapp.com

DockerHub: https://hub.docker.com/r/neostark/printcloud

- Comando Docker pull: docker pull neostark/printcloud

Vagrant Cloud: https://app.vagrantup.com/NeoStark/boxes/PrintCloud

## Overview

PrintCloud es una simple API que genera un pdf a partir del conjunto de datos que quieras enviarle.

Te permite enviar la información en un formato JSON que _PrintCloud_ decodificará y creará un documento HTML a partir de ellos para, posteriormente, generar un pdf a partir de ese HTML aplicandole una hoja de estilos CSS.

Además, te permite elegir entre diferentes formatos y diseños para generar el pdf, que puedes declarar como un parámetro más en llamada. Puedes consultar todos los diseños [aquí](docs/styles).

## Instalación

```bash
$ git clone https://github.com/Neo-Stark/Proyecto-IV-19-20.git
$ cd Proyecto-IV-19-20
$ composer install
```

> Requiere tener instalado [Composer](https://getcomposer.org)

## Tests

```bash
$ composer test
```

\*En la raíz del proyecto

## Iniciar servicio

```bash
$ composer start&
```

> Requiere tener instalado [docker](https://docs.docker.com/install/linux/docker-ce/ubuntu/)

## [Documentación adicional](https://neo-stark.github.io/Proyecto-IV-19-20/)

- [VM y provisionamiento](docs/VM-provisionamiento.md)
- [Dockerfile](https://neo-stark.github.io/Proyecto-IV-19-20/docker)
- [Docker Hub y GitHub](https://neo-stark.github.io/Proyecto-IV-19-20/dockerhub-github)
- [Despliegue contenedor azure](https://neo-stark.github.io/Proyecto-IV-19-20/despliegue-azure)
- [Despliegue contenedor heroku](https://neo-stark.github.io/Proyecto-IV-19-20/despliegue-heroku)
- [Despliegue](https://neo-stark.github.io/Proyecto-IV-19-20/despliegue)
- [Documentación rutas](https://neo-stark.github.io/Proyecto-IV-19-20/rutas)
- [Configuración herramientas construcción y CI](https://neo-stark.github.io/Proyecto-IV-19-20/CI-herramientas)
- [Tecnologías usadas](https://neo-stark.github.io/Proyecto-IV-19-20/Tecnologías)
- [Mas información](https://neo-stark.github.io/Proyecto-IV-19-20/MasInformacion)

buildtool: composer.json

> Proyecto para la asignatura Infraestructura Virtual. Curso 2019-20.
