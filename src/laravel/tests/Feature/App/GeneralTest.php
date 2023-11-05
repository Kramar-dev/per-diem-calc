<?php

namespace App;

use Tests\TestCase;

class GeneralTest extends TestCase
{
    public function testGetNonExistsEndpoint()
    {
        $response = $this->get('/magic');
        echo $response->status();
        $response->assertStatus(404);
    }

    public function testPostNonExistsEndpoint()
    {
        $response = $this->post('/magic');
        echo $response->status();
        $response->assertStatus(405);
    }

}
