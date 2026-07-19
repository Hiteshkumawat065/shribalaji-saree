<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Auth\LoginController;


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

//Auth::routes(); 

/*
 * Frontend Routes
 * Namespaces indicate folder structure
 */ 
Route::group(['namespace' => 'Frontend', 'prefix' => 'frontend', 'as' => 'frontend.'], function(){    
    includeRouteFiles(__DIR__.'/frontend/'); 
}); 


Route::get('/', [App\Http\Controllers\Frontend\DashboardController::class, 'index'])->name('frontend.home');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('auth.showLoginForm');

/*
 * Backend Routes
 * Namespaces indicate folder structure
 */ 

Route::group(['namespace' => 'Backend','prefix' => 'admin', 'as' => 'admin.'], function(){   
       includeRouteFiles(__DIR__.'/backend/');
 });

