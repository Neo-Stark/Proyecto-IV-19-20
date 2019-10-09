# Documentación adicional

## Herramientas de tests e integración continua

Para testear la aplicación se ha optado por utilizar *phpunit* que se trata del entorno por excelencia para realizar tests unitarios en PHP, permite crear tests de manera sencilla y haciendo las comprobaciones a través de assertions (como la mayoria de software dedicado a realizar tests) para verificar que el resultado de una función o parte del código es el esperado.

En cuanto a la herramienta de integración continua se ha utilizado *Travis CI* principalmente porque permite testear proyectos open source (como este) de manera gratuita. Otra razón tan importante o más, es que permite crear configuraciones muy fáciles y da soporte completo a PHP (hay muchos otros servicios de CI que no lo hacen sin plugins o con configuraciones muy complejas).

## Herramienta de construcción y dependecias

En este caso se ha usado composer para gestionar las dependecias de toda la aplicación y para poder instalar con un solo comando `composer install` todas ellas.