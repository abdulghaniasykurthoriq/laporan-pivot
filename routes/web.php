<?php

use App\Http\Controllers\SekolahController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function(){
    return redirect()->route('intermediete');
});
Route::get('/intermediete', [TransaksiController::class,'index'])->name('intermediete');
Route::get('/advanced', [SekolahController::class,'index'])->name('advanced');


