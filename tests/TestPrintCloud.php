<?php

use App\PrintCloud;

class TestPrintCloud extends TestCase
{
    public function testConstructor()
    {
        $pdf = new PrintCloud();
        $this->assertEquals('', $pdf->getHtml());
        $this->assertEquals('', $pdf->getPdfName());
        $this->assertInstanceOf('Dompdf\Dompdf', $pdf->getDompdf());
    }

    public function testSetters()
    {
        $pdf = new PrintCloud();
        $texto = '<html><head><title>Prueba</title></head><body>Hola Mundo!</body></html>';
        $datos = json_encode(['prueba'=>true]);

        $pdf->setDatos($datos);
        $pdf->setPdfName('documento.pdf');
        $pdf->generarHtml($texto);

        $this->assertEquals($texto, $pdf->getHtml());
        $this->assertEquals($datos, $pdf->getDatos());
        $this->assertEquals('documento.pdf', $pdf->getPdfName());
    }

    public function testGenerar()
    {
        $pdf = new PrintCloud();
        $pdf->generarHtml('<html><head><title>Prueba</title></head><body>Hola Mundo!</body></html>');
        $pdf->generar();
        $dom = $pdf->getDompdf()->getDom();
        $this->assertEquals('Prueba', $dom->textContent);
    }
}
