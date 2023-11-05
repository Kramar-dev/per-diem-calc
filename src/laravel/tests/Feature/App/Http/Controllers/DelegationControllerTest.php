<?php

namespace app\Http\Controllers;

use App\Http\Controllers\DelegationController;
use Tests\TestCase;

class DelegationControllerTest extends TestCase
{

    public function testAdd()
    {
        $response = $this->post('/add/delegation', [
            "start_date" => "2020-07-20 08:00:00",
            "end_date" => "2020-08-21 08:00:00",
            "country" => "PL",
            "employee_id" => 7
        ]);
        $response->assertStatus(200);
    }

    public function testGet()
    {
        $response = $this->get('/get/perdiem', ['employee_id' => 1]);
        $response->assertStatus(200);
    }
}
