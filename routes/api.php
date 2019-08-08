<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/fetchprice', function(Request $request){
	$price = DB::table('packages')->where('id', $request->id)->get();
	return $price;
});

Route::post('/filter-attendance', function(Request $request){
	$filtered_attendance = DB::table('attendances')->where('attended_date', 'like', "%".$request->f_date."%")->where('trainerid', $request->trainer_id)->get();
	$local = array();
	foreach($filtered_attendance as $attend)
	{
		$local[] = $attend->id;
	}
	return $local;
});