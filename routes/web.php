<?php
// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;

// Trang chủ
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('classes.index');
    }
    return redirect()->route('login');
});

// Routes xác thực
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes quản lý lớp học (yêu cầu đăng nhập)
Route::middleware('auth')->group(function () {
    Route::resource('classes', ClassController::class);
});