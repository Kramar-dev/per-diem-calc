<?php

use App\Http\Controllers\DelegationController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});



Route::post('/add/employee', [EmployeeController::class, 'add']);
Route::post('/add/delegation', [DelegationController::class, 'add']);
Route::get('/get/perdiem', [DelegationController::class, 'get']);

Route::view('/', 'welcome');

Route::get('/{any}', function () {
    return response()->json(['error' => 'Not Found'], ResponseAlias::HTTP_NOT_FOUND);
})->where('any', '.*');

Route::match(['post', 'put', 'delete'], '/{any}', function () {
    return response()->json(['error' => 'Not allowed'], ResponseAlias::HTTP_METHOD_NOT_ALLOWED);
})->where('any', '.*');
