<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Pdf;

class ControllerPdf extends BaseController
{
    public function verPdf(){
        $pdf = new Pdf();
        $pdf->setHtml("<!DOCTYPE html><html lang=\"es\"><head><title>Prueba</title></head><body>Hola Mundo!</body></html>");
        $pdf->generarPdf();
        $pdf->verPdf();
    }

    public function descargarPdf(){
        $pdf = new Pdf();
        $pdf->setHtml("<!DOCTYPE html><html lang=\"es\"><head><title>Prueba</title></head><body>Hola Mundo!</body></html>");
        $pdf->setPdfName('prueba.pdf');
        $pdf->generarPdf();
        $pdf->descargaPdf();
    }
}
