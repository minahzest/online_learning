<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/courses', [HomeController::class, 'view_course'])->name('courses');
Route::get('/my_course', [HomeController::class, 'my_course'])->name('my.course');
Route::post('/assign_course', [HomeController::class, 'assign_course'])->name('assign.courses');

//admin
Route::get('/admin/dashboard', [AdminController::class, 'index'])->middleware('admin')->name('admin.dashboard');
Route::get('/admin/course', [CourseController::class, 'index'])->middleware('admin')->name('admin.course');
Route::get('/admin/student', [StudentController::class, 'index'])->middleware('admin')->name('admin.student');

//admin course
Route::post('/admin/add_update_course', [CourseController::class, 'add_update_course'])->name('update.courses');
Route::post('/admin/delete_course', [CourseController::class, 'delete_course'])->name('deleted.courses');

//admin student
Route::post('/admin/add_update_user', [StudentController::class, 'add_update_user'])->name('manipulate.user');
Route::post('/admin/delete_user', [StudentController::class, 'delete_user'])->name('delete.user');