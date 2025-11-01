<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicTagController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PetController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function(){ return view('frontend.index'); });


// public tag scanning
Route::get('/tag/{code}', [PublicTagController::class,'show']);


// Auth routes from Breeze
require __DIR__.'/auth.php';


Route::middleware(['auth','verified'])->group(function(){
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
// Route::post('/activate-tag', [TagController::class,'activate'])->name('tag.activate');
Route::post('/tags/activate', [TagController::class, 'activate'])->name('tags.activate');

Route::resource('pets', TagController::class); // adjust if needed
    Route::get('/membership', [PaymentController::class, 'showMembership'])->name('membership.show');
    Route::post('/membership/create', [PaymentController::class, 'createSession'])->name('membership.create');
    Route::get('/membership/success', [PaymentController::class, 'success'])->name('membership.success');
    Route::get('/membership/cancel', [PaymentController::class, 'cancel'])->name('membership.cancel');


// Route::get('/membership', [PaymentController::class,'showMembership'])->name('membership.show');
// Route::post('/membership/create', [PaymentController::class,'createSession'])->name('membership.create');
// Route::post('/membership/webhook', [PaymentController::class,'webhook']);
    // Membership purchase page
 Route::get('/tag/{code}/history', [PublicTagController::class, 'scanHistory'])->name('public.tag.history');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route::post('/tags/{tag}/store-pet', [PetController::class, 'store'])->name('tags.storePet');

    Route::get('/tags/{tag}/pet', [TagController::class, 'managePet'])->name('tags.managePet');
    Route::post('/tags/{tag}/pet', [TagController::class, 'storePet'])->name('tags.storePet');
    Route::resource('pets', PetController::class);

    // Membership routes
    Route::get('/membership/buy', [DashboardController::class, 'buyMembership'])->name('membership.buy');
Route::post('/membership/buy', [DashboardController::class, 'storeMembership'])->name('membership.store');

    // Tag activation
    Route::post('/tags/activate', [TagController::class, 'activate'])->name('tags.activate');
});

// Public Scan Page (no auth)
Route::get('/{tag_code}', [TagController::class, 'publicView'])->name('tags.public');

Route::middleware(['auth','is_admin'])->prefix('admin')->group(function(){
Route::get('/', [AdminController::class,'index'])->name('admin.index');
});
