<?php

use App\Models\Service;
use Illuminate\Contracts\View\View;
use App\Commands\AutoCompleteService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Schedule;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CustomerDashboardController;

Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index']);

// Login & Register
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', function () {
    return view('signup');
})->name('register');
Route::post('/register', [UserController::class, 'register']);

// Admin Dashboard routes
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware(['auth', 'role:admin']);

// FIXED: Admin Views - Use controllers instead of closures
Route::get('/admin/testimoni', [TestimoniController::class, 'index'])->middleware(['auth', 'role:admin']);
Route::get('/admin/berita', [BeritaController::class, 'index'])->middleware(['auth', 'role:admin']);
Route::get('/admin/produk', [ProdukController::class, 'index'])->middleware(['auth', 'role:admin']); 
Route::get('/admin/booking', [ServiceController::class, 'indexBycabang'])->middleware(['auth', 'role:admin']);
Route::get('/admin/produk', [ProdukController::class, 'index'])
    ->middleware(['auth', 'role:admin']);

// Admin API endpoints
Route::prefix('/admin/api')->middleware(['auth', 'role:admin'])->group(function () {
    // Testimoni API
    Route::get('/testimoni', [TestimoniController::class, 'getTestimoni']);
    Route::post('/testimoni', [TestimoniController::class, 'postTestimoni']);
    Route::put('/testimoni/{id}', [TestimoniController::class, 'updateTestimoni']);
    Route::delete('/testimoni/{id}', [TestimoniController::class, 'deleteTestimoni']);

    // Produk API
    Route::get('/produk', [ProdukController::class, 'getProduk']);
    Route::post('/produk', [ProdukController::class, 'storeProduk']);
    Route::put('/produk/{id}', [ProdukController::class, 'updateProduk']);
    Route::delete('/produk/{id}', [ProdukController::class, 'deleteProduk']);
    Route::get('/produk/{id}', [ProdukController::class, 'showProduk']);
    
    
});

// Service management
Route::prefix('/admin/api')->middleware(['auth', 'role:admin'])->group(function () {
    Route::POST('/service/start/{id}', [ServiceController::class, 'startService']);
    // Service API
    Route::get('/service', [ServiceController::class, 'getServices']);
    Route::get('/service/{id}', [ServiceController::class, 'showService']);
    Route::put('/service/{id}/complete', [ServiceController::class, 'completeService']);
    Route::get('/service/start/{id}', [ServiceController::class, 'startService'])->name('admin.api.service.start');
    Route::put('/service/{id}', [ServiceController::class, 'updateService']);
    Route::post('/service/cancel/{id}/user/{id_pengguna}', [ServiceController::class, 'adminCancel'])->name('admin.api.service.cancel');
    Route::post('/service/cancel/{id}', [ServiceController::class, 'customerCancel']);
});

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Customer Dashboard
Route::get('/customer/dashboard', [ServiceController::class, 'indexByUser'])
    ->name('customer.dashboard')
    ->middleware('auth', 'role:cust');

Route::get('/service-cabang', [ServiceController::class, 'getServiceCabang']);



// Produk routes
Route::resource('produk', ProdukController::class)->only(['index', 'store', 'create']);

// Halaman produk customer
Route::get('/customer/product', [ProdukController::class, 'index'])->name('customer.product')->middleware('auth');
Route::get('/product-customer', [ProdukController::class, 'index'])->name('product.customer');

// Booking Service
Route::get('/service', [ServiceController::class, 'create'])->name('service.create');
Route::post('/service', [ServiceController::class, 'store'])->name('service.store');
Route::get('/validate-slot', [ServiceController::class, 'validateslot']);
Route::get('/service-types', [ServiceController::class, 'getServiceTypes']);
Route::get('/service/history', [ServiceController::class, 'indexByUser'])->name('service.history');
Route::post('/service/{id}/cancel', [ServiceController::class, 'customerCancel'])->name('service.cancel');
Route::get('/service/all', [ServiceController::class, 'indexBycabang'])->name('service.all');
Route::post('/service/{id}/start', [ServiceController::class, 'startService'])->name('service.start');

// Testimoni
Route::get('/testimoni', [TestimoniController::class, 'getTestimoni']);
Route::post('/testimoni', [TestimoniController::class, 'postTestimoni']);
Route::get('/testimoni/valid-service', [TestimoniController::class, 'getValidService'])->middleware('auth');
Route::delete('/testimoni/{id}', [TestimoniController::class, 'deleteTestimoni']);

// Berita
Route::get('/berita', [BeritaController::class, 'getBerita']);
Route::get('/berita/{id}', [BeritaController::class, 'getBeritaById']);
Route::post('/berita', [BeritaController::class, 'postBerita']);
Route::put('/berita/{id}', [BeritaController::class, 'editBerita']);
Route::delete('/berita/{id}', [BeritaController::class, 'deleteBerita']);

// Add these routes to your existing routes
Route::middleware('auth')->group(function () {
    // ... your existing routes
    
    // Service completion and testimonial routes
    Route::get('/check-completed-services', [CustomerController::class, 'checkCompletedServices'])->name('check.completed.services');
    Route::post('/mark-service-notified/{service}', [CustomerController::class, 'markServiceNotified'])->name('mark.service.notified');
    Route::get('/service-history', [CustomerController::class, 'serviceHistory'])->name('service.history');
    Route::get('/testimonial-history', [CustomerController::class, 'testimonialHistory'])->name('testimonial.history');
});