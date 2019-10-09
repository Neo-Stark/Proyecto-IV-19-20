<?php

namespace App;
use Dompdf\Dompdf;

class Pdf{

    public function generarPdf(){

        // echo 'hello world';
        $dompdf = new Dompdf();
        $dompdf->loadHtml('hello world');
        
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');
        
        // Render the HTML as PDF
        $dompdf->render();
        $file = $dompdf->output();
        
        // Output the generated PDF to Browser
        $dompdf->stream($file, array("Attachment" => 0));
    }
    }
