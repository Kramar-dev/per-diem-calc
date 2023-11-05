<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function add(): JsonResponse
    {
        DB::insert('INSERT INTO `employees` () VALUES ()');
        $employee_id = DB::select('SELECT LAST_INSERT_ID() as last_inserted_id')[0]->last_inserted_id;
        return response()->json(['employee_id' => $employee_id]);
    }
}
