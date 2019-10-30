<?php

namespace App;
use Dompdf\Dompdf;

class PrintCloud{

    protected $dompdf;
    protected $pdfName;
    protected $html;
    protected $datos;

    public function __construct(){
        $this->dompdf = new Dompdf();
        $this->pdfName = "";
        $this->html = "";
        $this->datos = null;
    }

    public function generar(){

        $this->dompdf->loadHtml($this->html);
        
        // (Optional) Setup the paper size and orientation
        $this->dompdf->setPaper('A4');
        
        // Render the HTML as PDF
        $this->dompdf->render();
        
    }
    
    public function descargar(){
        if ($this->pdfName != ""){
            $this->dompdf->stream($this->pdfName);     
        }
        else
            return 'No existe el pdf';
    }
    
    public function ver(){
        $this->dompdf->stream($this->pdfName, array("Attachment" => 0));
    }

    public function generarHtml($texto = null){
        if (!is_null($texto)){
            $this->html = $texto;
        } else{
            $this->html.="
            <!DOCTYPE html>
            <html>
            <head>
          <meta charset=\"UTF-8\">
          <title>" . $this->pdfName . "</title>
          </head>
          <body>
          <table>
          <tr>
          ";
          if (!is_null( $this->datos)){
              $array = json_decode($this->datos, true);
              $columnas = array_keys($array[0]);
              foreach ($columnas as $colum){
                  $this->html.="<th>".$colum."</th>";
                }
                $this->html .= "</tr>";
                foreach($array as $tupla){
                    $this->html .= "<tr>";
                    foreach($tupla as $valor){
                        $this->html.="<td>".$valor."</td>";
                    }
                    $this->html .= "</tr>";
                }
            }
            
            $this->html .="  
            </table>
            </body>
            </html>";
        }
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

    public function setDatos($datos){
        $this->datos = $datos;
        return json_encode(['created'=> true]);
    }

    public function getDatos(){
        return $this->datos;
    }
}
