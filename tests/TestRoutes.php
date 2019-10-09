<?php

class TestRoutes extends TestCase {

    public function testRootRoute(){
        $this->get('/');

        $this->assertEquals(
            $this->app->version(), $this->response->getContent()
        );
    }
}