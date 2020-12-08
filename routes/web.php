<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BasketballController;
use App\Models\Basketball;
use Carbon\Carbon;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// BASKETBALL ENDPOINT
Route::get('/generate-result', [BasketballController::class, 'generate_result']);

Route::get('/api/get-result/limit/{limit}', function($limit){
	date_default_timezone_set("Asia/Seoul");
	$date_now = date('Y-m-d H:i:s');
	return Basketball::where('created_at','<=',$date_now)->latest()->limit($limit)->get();
});