<?php

use Illuminate\Support\Facades\Route;
// use App\Models\Users;

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

Route::get('/', function () {
    return view('welcome');
});


// Route::get('/test-connection', function () {
//     $users = Users::limit(5)->get();
//     return response()->json($users);
// });
