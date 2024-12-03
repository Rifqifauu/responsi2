<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// routes/api.php

use App\Http\Controllers\BalapanController;
use Illuminate\Support\Facades\Route;

// Route untuk Balapan
Route::prefix('balapan')->group(function () {
    Route::get('/', [BalapanController::class, 'index']); // Menampilkan semua balapan
    Route::post('/', [BalapanController::class, 'store']); // Menambahkan balapan baru
    Route::get('/{id_balap}', [BalapanController::class, 'show']); // Menampilkan balapan berdasarkan ID
    Route::put('/{id_balap}', [BalapanController::class, 'update']); // Memperbarui balapan berdasarkan ID
    Route::delete('/{id_balap}', [BalapanController::class, 'destroy']); // Menghapus balapan berdasarkan ID
});
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);