<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => '/teachers', 'middleware' => ['auth', 'allow:teacher'], 'as' => 'teachers.'], function () {
    Route::get('/dashboard', [App\Http\Controllers\Teachers\HomeController::class, 'index'])->name('dashboard');
    Route::get('/tests', [App\Http\Controllers\Teachers\TestController::class, 'index'])->name('tests.index');
    Route::get('/tests/add', [App\Http\Controllers\Teachers\TestController::class, 'add'])->name('tests.add');
    Route::post('/tests/add', [App\Http\Controllers\Teachers\TestController::class, 'store'])->name('tests.store');
    Route::get('/tests/results', [App\Http\Controllers\Teachers\TestController::class, 'results'])->name('tests.results');
    Route::get('/tests/results/view/{id}', [App\Http\Controllers\Teachers\TestController::class, 'view'])->name('tests.results.view');
    Route::post('/tests/delete', [App\Http\Controllers\Teachers\TestController::class, 'delete'])->name('tests.delete');
});

Route::group(['prefix' => '/students', 'middleware' => ['auth', 'allow:student'], 'as' => 'students.'], function () {
    Route::get('/dashboard', [App\Http\Controllers\Students\HomeController::class, 'index'])->name('dashboard');
    Route::get('/tests', [App\Http\Controllers\Students\TestController::class, 'index'])->name('tests.index');
    Route::get('/tests/take/{id}', [App\Http\Controllers\Students\TestController::class, 'take'])->name('tests.take');
    Route::post('/tests/take/{id}', [App\Http\Controllers\Students\TestController::class, 'store'])->name('tests.store');
    Route::get('/tests/results', [App\Http\Controllers\Students\TestController::class, 'results'])->name('tests.results');
    Route::get('/tests/results/view/{id}', [App\Http\Controllers\Students\TestController::class, 'view'])->name('tests.results.view');
});
