<?php

use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PropertyController as PublicPropertyController;
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

// Public Routes
Route::get('/', [PublicPropertyController::class, 'index'])->name('home');
Route::get('/properties', [PublicPropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{property}', [PublicPropertyController::class, 'show'])->name('properties.show');

// Admin Authentication Routes
Route::get('admin/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('admin/login', [LoginController::class, 'login']);
Route::post('admin/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', function () {
            return redirect()->route('admin.properties.index');
        });
        Route::resource('properties', PropertyController::class);
        Route::patch('properties/{property}/archive', [PropertyController::class, 'archive'])->name('properties.archive');
        Route::patch('properties/{property}/unarchive', [PropertyController::class, 'unarchive'])->name('properties.unarchive');
        Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
    });
});

// Temporary debug route - remove in production
if (config('app.debug')) {
    Route::get('/debug/property-images/{property}', function(App\Models\Property $property) {
        $property->load('images');
        return response()->json([
            'property_id' => $property->id,
            'title' => $property->title,
            'images' => $property->images->map(function($image) {
                return [
                    'id' => $image->id,
                    'path' => $image->image_path,
                    'url' => $image->image_url,
                    'order' => $image->order
                ];
            })
        ]);
    });
}
