<?php

use App\Http\Controllers\TakesController;
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

Route::get('/home', function () {
    return view('welcome');
});
Route::get('/gioi-thieu', function () {
    $name = 'about page';
    return view('about_us',compact('name'));
});
// Route dành cho hiển thị tất cả record của table tasks
Route::get('/tasks',[TakesController::class,'index'])->name('tasks.index');

// Route dành cho hiển thị form thêm mới 1 record vào table tasks
Route::get('/tasks/create',[TakesController::class,'create'])->name('tasks.create');

// Route dành cho submit form thêm mới 1 record vào table tasks
Route::post('/tasks',[TakesController::class,'store'])->name('tasks.store');

// Route dành cho hiển thị form chỉnh sửa 1 record của table tasks
Route::get('/tasks/{id}/edit',[TakesController::class,'edit'])->name('tasks.edit');

// Route dành cho submit form update 1 record của table Task
Route::put('/tasks/{id}',[TakesController::class,'update'])->name('tasks.update');

// Route dành cho hiển thị thông tin chi tiết của 1 record của table
Route::get('/tasks/{id}',[TakesController::class,'show'])->name('tasks.show');

// Route dành để xóa thông tin chi tiết 1 record của table
//Route::delete('/tasks/{id}',[TakesController::class,'destroy'])->name('tasks.destroy'); // cách 1 normal
Route::delete('/tasks/{task}',[TakesController::class,'destroy'])->name('tasks.destroy'); // cách 2: Injecting 1 class model Taks

























