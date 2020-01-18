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

    public function descargar()
    {
        $output = $this->dompdf->output();

        return new Response($output, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' =>  'attachment; filename="'.$this->pdfName.'"',
            'Content-Length' => strlen($output),
        ]);
    }

    public function ver()
    {
        $this->dompdf->stream($filename = $this->pdfName, ['Attachment' => 0]);
    }

    public function generarHtml($texto = null)
    {
        if (! is_null($texto)) {
            $this->html = $texto;
        } else {
            $this->html = view('pdfView', ['datos' => $this->datos]);
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
