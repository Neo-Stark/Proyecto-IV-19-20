<?php

namespace App\Http\Controllers;

use App\Pdf;
use App\PrintCloud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;

class ControllerPdf extends BaseController
{
    protected $pdf;

    public function __construct()
    {
        $this->pdf = new PrintCloud();
    }

    private function generar($id)
    {
        $model = Pdf::find($id);
        $this->pdf->setDatos($model->datos);
        $this->pdf->setPdfName($model->nombre.'.pdf');
        $this->pdf->generarHtml();
        $this->pdf->generar();
    }

    public function ver($id)
    {
        $this->generar($id);
        $this->pdf->ver();
    }

    public function descargar($id)
    {
        $this->generar($id);

        return $this->pdf->descargar();
    }

    public function createPdf(Request $request)
    {
        $pdf = new Pdf();
        $pdf->nombre = $request->input('nombre');
        if (is_array($request->input('datos'))) :
            $pdf->datos = json_encode($request->input('datos')); else :
            $pdf->datos = json_encode([$request->input('datos')]);
        endif;
        if ($pdf->save()):
            $id = DB::table('pdf')->latest()->first(['id']);

        return response()->json(['created' => true, 'id' => $id->id]); else:
            return response()->json(['created' => false]);
        endif;
    }
}
