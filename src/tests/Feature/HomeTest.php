<?php

class HomeTest extends TestCase
{
    public function testHome()
    {
        $this->get('/')
            ->assertResponseOk();
        $this->assertContains('Lumen', $this->response->getContent());
    }
}
