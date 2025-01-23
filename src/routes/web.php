<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

// 商品一覧
Route::get('/products', [ProductController::class, 'index']);

// 商品登録フォーム表示
Route::get('/products/register', [ProductController::class, 'create']);

// 商品登録処理
Route::post('/products', [ProductController::class, 'store']);

// 商品詳細表示（編集フォーム）
Route::get('/products/{productId}', [ProductController::class, 'edit']);

// 商品更新処理
Route::post('/products/{productId}/update', [ProductController::class, 'update']);

// 商品削除処理
Route::delete('/products/{productId}/delete', [ProductController::class, 'destroy']);

// 商品検索処理
Route::get('/products/search', [ProductController::class, 'search']);
