<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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

Route::get('/home', [ContactController::class,'index'])->name('ho')->middleware('age');

//Category Controller CRUD OPERATIONS

Route::get('/category/all', [CategoryController::class, 'AllCat'])->name('all.category');
Route::post('/category/add', [CategoryController::class, 'AddCat'])->name('store.category');

Route::get('/category/edit/{id}', [CategoryController::class, 'Edit']);
Route::post('/category/update/{id}', [CategoryController::class, 'Update']);
Route::get('/category/softdelete/{id}', [CategoryController::class, 'SoftDelete']);
Route::get('/category/restore/{id}', [CategoryController::class, 'Restore']);
Route::get('/category/permanentdelete/{id}', [CategoryController::class, 'PermanentDelete']);

// Brand Routes

Route::get('/brand/all', [BrandController::class, 'AllBrand'])->name('all.brand');
Route::get('/brand/edit/{id}', [BrandController::class, 'Edit']);
Route::get('/brand/delete/{id}', [BrandController::class, 'Delete']);
Route::post('/brand/add/', [BrandController::class, 'AddBrand'])->name('store.brand');
Route::post('/brand/update/{id}', [BrandController::class, 'Update']);


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    // $users = User::all();
    $users = DB::table('users')->get();
    return view('dashboard', compact('users'));
})->name('dashboard');
