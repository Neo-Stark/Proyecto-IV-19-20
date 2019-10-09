# PrintCloud

[![Build Status](https://travis-ci.com/Neo-Stark/Proyecto-IV-19-20.svg?branch=master)](https://travis-ci.com/Neo-Stark/Proyecto-IV-19-20)

## Overview

PrintCloud es una simple API que genera un pdf a partir del conjunto de datos que quieras enviarle.

Te permite enviar la información en un formato JSON que *PrintCloud* decodificará y creará un documento HTML a partir de ellos para, posteriormente, generar un pdf a partir de ese HTML aplicandole una hoja de estilos CSS.

Además, te permite elegir entre diferentes formatos y diseños para generar el pdf, que puedes declarar como un parámetro más en llamada. Puedes consultar todos los diseños [aquí](doc/styles).

## Instalación

```bash
$ git clone https://github.com/Neo-Stark/Proyecto-IV-19-20.git
$ cd Proyecto-IV-19-20
$ composer install
```
>Requiere tener instalado [Composer](https://getcomposer.org)

## Tests
```bash
$ vendor/bin/phpunit
```
*En la raíz del proyecto
## Parte de algo mayor

El proyecto está basado en un apartado en específico de una aplicación web externa que se está desarrollando durante las prácticas de empresa. En esta aplicación se pretende crear, entre otras cosas, un entorno donde publicar, modificar, eliminar y visualizar artículos, citas, publicaciones y elementos de producción científica. Una de las funciones que debe poseer es que sea capaz de exportar a pdf el histórico de elementos publicados en un formato predifinido para cierto usuario. Esta función es la que se desplegará como microservicio en la asignatura.

## Tecnologías usadas

- El proyecto está desarrollado en PHP7.2.
- Para facilitar el desarrollo del servicio se usará el microframework **Lumen** que permitirá de manera rápida y fácil de depurar generar nuestro microservicio. En todo momento se basa en una arquitectura RESTful.
- Se usará la biblioteca [DomPDF](https://github.com/dompdf/dompdf) para generar los pdf's en nuestro servicio. [Aquí](https://github.com/dompdf/dompdf#quick-start) un esqueleto básico de su uso.
- Como biblioteca de logging se usará **Monolog** que permite dar soporte de log a diferentes niveles de nuestra aplicación. Además, permite formatear la salida (a JSON por ejemplo).
- Se usara MySQL como BBDD para almacenar tanto los datos a exportar, como los diferentes formatos y plantillas.

- Para las herramientas de construcción y CI consultar en este [enlace](doc/README.md)

## Motivación

La principal motivación es crear un servicio que sea capaz de formatear y exportar a pdf cualquier conjunto de datos de forma rápida para su posterior distribución. Esta función es transparente e inmediata para el cliente ahorrando el uso de librerias más complejas.

> Proyecto para la asignatura Infraestructura Virtual. Curso 2019-20.
