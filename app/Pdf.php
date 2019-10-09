<?php

namespace App;
use Dompdf\Dompdf;

class Pdf{

    protected $dompdf;
    protected $pdfName;
    protected $html;

    public function __construct(){
        $this->dompdf = new Dompdf();
        $this->pdfName = "";
        $this->html = "";
    }

    public function generarPdf(){

        $this->dompdf->loadHtml($this->html);
        
        // (Optional) Setup the paper size and orientation
        $this->dompdf->setPaper('A4');
        
        // Render the HTML as PDF
        $this->dompdf->render();
        
    }
    
    public function descargaPdf(){
        if ($this->pdfName != "")
            $this->dompdf->stream($this->pdfName);        
        else
            echo 'No existe el pdf';
    }
    
    public function verPdf(){
        $this->dompdf->stream("MiDocumento.pdf", array("Attachment" => 0));
    }

    public function setHtml($string){
        $this->html = $string;
    }

    public function getHtml(){
        return $this->html;
    }

    public function setPdfName($name){
        $this->pdfName = $name;
    }

    public function getPdfName(){
        return $this->pdfName;
    }

    public function getDompdf(){
        return $this->dompdf;
    }
}
