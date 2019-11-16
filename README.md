# PrintCloud

[![Build Status](https://travis-ci.com/Neo-Stark/Proyecto-IV-19-20.svg?branch=master)](https://travis-ci.com/Neo-Stark/Proyecto-IV-19-20)
[![CircleCI](https://circleci.com/gh/Neo-Stark/Proyecto-IV-19-20.svg?style=svg)](https://circleci.com/gh/Neo-Stark/Proyecto-IV-19-20)
[![PPM Compatible](https://raw.githubusercontent.com/php-pm/ppm-badge/master/ppm-badge.png)](https://github.com/php-pm/php-pm)
[![StyleCI](https://github.styleci.io/repos/208740465/shield?branch=master)](https://github.styleci.io/repos/208740465)

despliegue https://printcloud.azurewebsites.net

## Overview

PrintCloud es una simple API que genera un pdf a partir del conjunto de datos que quieras enviarle.

Te permite enviar la información en un formato JSON que *PrintCloud* decodificará y creará un documento HTML a partir de ellos para, posteriormente, generar un pdf a partir de ese HTML aplicandole una hoja de estilos CSS.

Además, te permite elegir entre diferentes formatos y diseños para generar el pdf, que puedes declarar como un parámetro más en llamada. Puedes consultar todos los diseños [aquí](docs/styles).

## Instalación

```bash
$ git clone https://github.com/Neo-Stark/Proyecto-IV-19-20.git
$ cd Proyecto-IV-19-20
$ composer install
```
>Requiere tener instalado [Composer](https://getcomposer.org)

## Tests
```bash
$ composer test
```
*En la raíz del proyecto

## Iniciar servicio
```bash
$ composer start&
```
>Requiere tener instalado [docker](https://docs.docker.com/install/linux/docker-ce/ubuntu/)

## Documentación adicional

[GH-Pages](https://neo-stark.github.io/Proyecto-IV-19-20/)

- [Despliegue](docs/despliegue.md)

- [Documentación rutas](docs/rutas.md)
- Configuración herramientas [construcción y CI](docs/CI-herramientas.md)
- [Tecnologías usadas](docs/Tecnologías.md)
- [Mas información](docs/MasInformacion.md)

buildtool: composer.json

> Proyecto para la asignatura Infraestructura Virtual. Curso 2019-20.
