<?php

class TestRouting extends TestCase
{
    public function testCreatePdf()
    {
        $response = $this->call('POST', '/createPdf', ['nombre' => 'PrintCloud', 'datos' => ['nombre'=>'fran', 'universidad'=>'ugr']]);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(true, json_decode($response->content())->created);
        $this->assertIsInt(json_decode($response->content())->id);
    }

    public function testDescargarPdf()
    {
        $response = $this->call('GET', '/getPdf/1');
        $this->assertEquals(200, $response->status());
    }

    public function testStatus()
    {
        $response = $this->call('GET', '/status');
        $this->assertEquals(200, $response->status());
        $this->assertEquals('OK', json_decode($response->content())->status);
        echo json_encode(['ruta'=>'/documentos', 'valor'=>['1' => 'documento.pdf', '2' => 'prueba.pdf', '3' => 'lista.pdf']]);
        $this->assertEquals(json_encode(['ruta'=>'/documentos', 'valor'=>['1' => 'documento.pdf', '2' => 'prueba.pdf', '3' => 'lista.pdf']]),
        json_encode(json_decode($response->content())->ejemplo));
    }

    public function testRootRoute()
    {
        $this->get('/version');

        $this->assertEquals(
            $this->app->version(), $this->response->getContent()
        );
        $this->assertEquals(200, $this->response->status());
    }
}
