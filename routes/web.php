<?php

use App\Http\Controllers\ArchivesController;
use App\Http\Controllers\BrgyNutritionScholarsController;
use App\Http\Controllers\CheckUpsController;
use App\Http\Controllers\FoodRecommendationsController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\PatientRecordsController;
use Illuminate\Support\Facades\Route;

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
Auth::routes();

Route::group(['middleware' => 'auth'], function () 
{
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::post('/check-ups/restore/{id}', [CheckUpsController::class, 'restore'])->name('check.ups.restore');
    Route::resource('check-ups', CheckUpsController::class);

    Route::resource('parents', ParentsController::class);

    Route::resource('brgy-nutrition-scholars', BrgyNutritionScholarsController::class);

    Route::resource('food-recommendation', FoodRecommendationsController::class);

    Route::resource('patient-records', PatientRecordsController::class);

    Route::get('/archives', ArchivesController::class);
});