<?php

namespace app\Http\Controllers;

use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{

    public function testAdd()
    {
        $response = $this->post('/add/employee');
        $response->assertStatus(200);
    }
}
