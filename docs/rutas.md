# Documentación rutas

- ***/createPdf*** &emsp; HTTP METHOD: POST
    
    Esta ruta permite enviar los datos necesarios para generar el pdf.
    Los datos necesarios son *nombre* y *datos*.

    - nombre: string con el nombre del pdf
    - datos: array de datos que serán renderizados en el pdf.
    
    Esa información deberá ir codificada en el cuerpo de la solicitud en formato json. Deberá seguir un esquema como el del siguiente ejemplo:

    ```json
    {
    "nombre": "ejemplo",
    "datos": [
        {
            "nombre": "Dean",
            "universidad": "UGR"
        },
        {
        	  "nombre": "Ivan",
            "universidad": "UCA"
        }
    ]
    }
    ```

    - ***return***: información de que la creación a sido correcta y el id para descargar posteriormente el pdf.

    ```json
    {"created":true,"id":$id}
    ```

    - tests:
      - se comprueba que el código de respuesta sea 200.
      - Se comprueba que envia la respuesta "created" y que efectivamente sea true
      - se comprueba que el id recibido sea un id válido
- ***/getPdf/{$id}*** &emsp; HTTP METHOD: GET

    Esta ruta permite descargar el pdf generado a partir de la información proporcionada en **/createPdf**. Es necesario introducir el id en la ruta obtenido en el apartado anterior.

    - ***return***: fichero pdf. "nombre".pdf

    - tests:
      - se comprueba que el código de respuesta sea 200.

- ***/status*** &emsp; HTTP METHOD: GET

  Comprueba que la aplicación funciona correctamenta.

  - ***return***: `{"status":"OK"}`

  - tests:
    - se comprueba que el código de respuesta sea 200.
    - se comprueba que el mensaje sea status : OK.

- ***/*** &emsp; HTTP METHOD: GET

    Devuelve la versión de la aplicación

    - ***return***: versión de la aplicación.

    - tests:
      - se comprueba que el código de respuesta sea 200.
      - se comprueba que la versión proporcionada sea efectivamente la versión actual.