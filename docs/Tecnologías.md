# Tecnologías usadas

- El proyecto está desarrollado en PHP7.2.
- Para facilitar el desarrollo del servicio se usará el microframework **Lumen** que permitirá de manera rápida y fácil de depurar generar nuestro microservicio. En todo momento se basa en una arquitectura RESTful.
- Se usará la biblioteca [DomPDF](https://github.com/dompdf/dompdf) para generar los pdf's en nuestro servicio. [Aquí](https://github.com/dompdf/dompdf#quick-start) un esqueleto básico de su uso.
- Como biblioteca de logging se usará **Monolog** que permite dar soporte de log a diferentes niveles de nuestra aplicación. Además, permite formatear la salida (a JSON por ejemplo).
- Se usara MySQL como BBDD para almacenar tanto los datos a exportar, como los diferentes formatos y plantillas.
