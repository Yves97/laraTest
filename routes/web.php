<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\TodoController;



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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/about',[App\Http\Controllers\AboutController::class,'index'])->name('about');

Route::get('/todos/undone', [TodoController::class, 'undone'])->name('todos.undone');
Route::get('/todos/done', [TodoController::class,'done'])->name('todos.done');

Route::put('/todos/makedone/{todo}',[TodoController::class,'makedone'])->name('todos.makedone');
Route::put('/todos/makeundone/{todo}',[TodoController::class,'makeundone'])->name('todos.makeundone');

Route::get('/todos/{todo}/affectedTo/{user}',[TodoController::class,'affectedto'])->name('todos.affectedto');

Route::resource('todos', TodoController::class);

// Route::get('/hello',function(){
//     return "Hello World";
// });