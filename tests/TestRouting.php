<?php

use App\Pdf;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TestRouting extends TestCase
{
    use DatabaseTransactions;

    public function testCreatePdf()
    {
        $response = $this->call('POST', '/createPdf', ['nombre' => 'prueba', 'datos' => ['nombre' => 'fran', 'universidad' => 'ugr']]);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(true, json_decode($response->content())->created);
        $this->assertIsInt(json_decode($response->content())->id);
    }

    public function testDescargarPdf()
    {
        $pdf = new Pdf();
        $pdf->nombre = 'prueba';
        $array = ['nombre' => 'fran', 'universidad' => 'ugr'];
        $pdf->datos = json_encode($array);
        $pdf->save();
        $consulta = DB::table('pdf')->orderBy('created_at')->first(['id']);
        $response = $this->call('GET', '/getPdf/' . $consulta->id);
        $this->assertEquals(200, $response->status());
    }

    public function testStatus()
    {
        $response = $this->call('GET', '/status');
        $this->assertEquals(200, $response->status());
        $this->assertEquals('OK', json_decode($response->content())->status);
        $this->assertEquals(
            json_encode(['ruta' => '/documentos', 'valor' => ['1' => 'documento.pdf', '2' => 'prueba.pdf', '3' => 'lista.pdf']]),
            json_encode(json_decode($response->content())->ejemplo)
        );
    }

    public function testRootRoute()
    {
        $this->get('/version');

        $this->assertEquals(
            $this->app->version(),
            $this->response->getContent()
        );
        $this->assertEquals(200, $this->response->status());
    }

    public function testDB()
    {
        $pdf = new Pdf();
        $pdf->nombre = 'prueba';
        $pdf->datos = json_encode(['uni' => 'ugr']);
        $pdf->save();
        $this->seeInDatabase('pdf', ['nombre' => 'prueba']);
    }
}
