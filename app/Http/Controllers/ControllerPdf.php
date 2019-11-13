<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Pdf;
use App\PrintCloud;

class ControllerPdf extends BaseController
{
    protected $pdf;

    public function __construct() {
        $this->pdf = new PrintCloud();
    }

    public function ver($id){
        $model = Pdf::find($id);
        $this->pdf->setDatos($model->datos);
        $this->pdf->setPdfName($model->name.".pdf");
        $this->pdf->generarHtml();
        $this->pdf->generar();
        $this->pdf->ver();
    }

    public function descargar($id){
        // $model = Pdf::find($id);
        // $this->pdf->setDatos($model->datos);
        $this->pdf->setDatos('[
            {
                "nombre": "fran",
                "universidad": "UGR"
            },
            {
                "nombre": "ivan",
                "universidad": "UCA"
            }
        ]');
        // $this->pdf->setPdfName($model->name.".pdf");
        $this->pdf->setPdfName("prueba.pdf");
        $this->pdf->generarHtml();
        $this->pdf->generar();
        return $this->pdf->descargar();
    }

    public function createPdf(Request $request){
        // $pdf = new Pdf();
        // $pdf->nombre = $request->input('nombre');
        // if (is_array($request->input('datos'))):
        // $pdf->datos = json_encode($request->input('datos'));
        // else:
        //     $pdf->datos = json_encode(Array($request->input('datos')));
        // endif;
        // $pdf->save();
        // $id = DB::table('pdf')->latest()->first();
        $this->pdf->setDatos(json_encode($request->input('datos')));
        $this->pdf->setPdfName($request->input('nombre'));

        return response()->json(['created'=>true, 'id'=> 1]);
    }
}
