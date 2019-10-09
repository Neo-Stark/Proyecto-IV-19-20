# PrintCloud

[![Build Status](https://travis-ci.com/Neo-Stark/Proyecto-IV-19-20.svg?branch=master)](https://travis-ci.com/Neo-Stark/Proyecto-IV-19-20)

## Overview

PrintCloud obtiene un conjunto de datos y genera un pdf con ellos.

Su función es obtener los datos y dependiendo de la cantidad y tipo, exportarlos a pdf en un formato que puede decidir el usuario dentro de una paleta de estilos a su elección.

## Parte de algo mayor

El proyecto está basado en un apartado en específico de una aplicación web externa que se está desarrollando durante las prácticas de empresa. En esta aplicación se pretende crear, entre otras cosas, un entorno donde publicar, modificar, eliminar y visualizar artículos, citas, publicaciones y elementos de producción científica. Una de las funciones que debe poseer es que sea capaz de exportar a pdf el histórico de elementos publicados en un formato predifinido para cierto usuario. Esta función es la que se desplegará como microservicio en la asignatura.

## Tecnologías usadas

- El proyecto se desarrollará en el lenguaje PHP7.
- Para facilitar el desarrollo del servicio se usará el microframework **Lumen** que permitirá de manera rápida y fácil de depurar generar nuestro microservicio. En todo momento se basa en una arquitectura RESTful.
- Se usará la biblioteca [DomPDF](https://github.com/dompdf/dompdf) para generar los pdf's en nuestro servicio. [Aquí](https://github.com/dompdf/dompdf#quick-start) un esqueleto básico de su uso.
- Como biblioteca de logging se usará **Monolog** que permite dar soporte de log a diferentes niveles de nuestra aplicación. Además, permite formatear la salida (a JSON por ejemplo).
- Se usara MySQL como BBDD para almacenar tanto los datos a exportar, como los diferentes formatos y plantillas.

## Motivación

La principal motivación es crear un servicio que sea capaz de formatear y exportar a pdf cualquier conjunto de datos de forma rápida para su posterior distribución. Esta función es transparente e inmediata para el cliente ahorrando el uso de librerias más complejas.

> Proyecto para la asignatura Infraestructura Virtual. Curso 2019-20.
