<?php
use App\Pdf;

class TestPrintCloud extends TestCase {
    
    public function testConstructor(){
        $pdf = new Pdf();
        $this->assertEquals('',$pdf->getHtml());
        $this->assertEquals('',$pdf->getPdfName());
        $this->assertInstanceOf('Dompdf\Dompdf', $pdf->getDompdf());
    }

    public function testSetters(){
        $pdf = new Pdf();
        $texto = "<html><head><title>Prueba</title></head><body>Hola Mundo!</body></html>";
        $pdf->setHtml($texto);
        $pdf->setPdfName('documento.pdf');

        $this->assertEquals($texto, $pdf->getHtml());
        $this->assertEquals('documento.pdf', $pdf->getPdfName());
    }

    public function testGenerarPdf(){
        $pdf = new Pdf();
        $pdf->setHtml('<html><head><title>Prueba</title></head><body>Hola Mundo!</body></html>');
        $pdf->generarPdf();
        $dom = $pdf->getDompdf()->getDom();
        $this->assertEquals('Prueba', $dom->textContent);
    }

}
