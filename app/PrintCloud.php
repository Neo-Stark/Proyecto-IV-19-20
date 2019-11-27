<?php

namespace App;

use Dompdf\Dompdf;
use Illuminate\Http\Response;

class PrintCloud
{
    protected $dompdf;
    protected $pdfName;
    protected $html;
    protected $datos;

    public function __construct()
    {
        $this->dompdf = new Dompdf();
        $this->pdfName = '';
        $this->html = '';
        $this->datos = null;
    }

    public function generar()
    {
        $this->dompdf->loadHtml($this->html);

        // (Optional) Setup the paper size and orientation
        $this->dompdf->setPaper('A4');

        // Render the HTML as PDF
        $this->dompdf->render();
    }

    public function descargar($filename = 'documento.pdf')
    {
        $output = $this->dompdf->output();

        return new Response($output, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' =>  'attachment; filename="'.$filename.'"',
                'Content-Length' => strlen($output),
            ]);
    }

    public function ver()
    {
        $this->dompdf->stream($this->pdfName, ['Attachment' => 0]);
    }

    public function generarHtml($texto = null)
    {
        if (! is_null($texto)) {
            $this->html = $texto;
        } else {
            $this->html .= '
            <!DOCTYPE html>
            <html>
            <head>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
          <meta charset="UTF-8">
          <title>'.$this->pdfName.'</title>
          </head>
          <body>
          <nav class="navbar navbar-expand navbar-dark bg-dark" style="background-color: red;" >
            <span class="navbar-brand"><img src="/img/logo-ugr.png" alt="logo ugr"></span>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExample02">
                <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                </ul>
                <form class="form-inline my-2 my-md-0">
                <input class="form-control" type="text" placeholder="Search">
                </form>
            </div>
            </nav>
          <table>
          <tr style="background-color: red;" >
          ';
            if (! is_null($this->datos)) {
                $array = json_decode($this->datos, true);
                $columnas = array_keys($array[0]);
                foreach ($columnas as $colum) {
                    $this->html .= '<th>'.$colum.'</th>';
                }
                $this->html .= '</tr>';
                foreach ($array as $tupla) {
                    $this->html .= '<tr>';
                    foreach ($tupla as $valor) {
                        $this->html .= '<td>'.$valor.'</td>';
                    }
                    $this->html .= '</tr>';
                }
            }

            $this->html .= '  
            </table>
            </body>
            </html>';
        }
    }

    public function getHtml()
    {
        return $this->html;
    }

    public function setPdfName($name)
    {
        $this->pdfName = $name;
    }

    public function getPdfName()
    {
        return $this->pdfName;
    }

    public function getDompdf()
    {
        return $this->dompdf;
    }

    public function setDatos($datos)
    {
        $this->datos = $datos;

        return json_encode(['created'=> true]);
    }

    public function getDatos()
    {
        return $this->datos;
    }
}
