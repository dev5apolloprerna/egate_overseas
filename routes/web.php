<?php
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;


use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\VisaMasterController;
use App\Http\Controllers\Admin\VisaServicesController;
use App\Http\Controllers\Admin\CountryMasterController;
use App\Http\Controllers\Admin\CountryServicesController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\TestimonialController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::fallback(function () {
     return view('errors.404');
});

Route::get('/login', function () {
    return redirect()->route('login');
});


Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Profile Routes
Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'getProfile'])->name('detail');
    Route::get('/edit', [HomeController::class, 'EditProfile'])->name('EditProfile');
    Route::post('/update', [HomeController::class, 'updateProfile'])->name('update');
    Route::post('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
});

Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// Roles
Route::resource('roles', App\Http\Controllers\RolesController::class);

// Permissions
Route::resource('permissions', App\Http\Controllers\PermissionsController::class);

// Users
Route::middleware('auth')->prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::get('/edit/{id?}', [UserController::class, 'edit'])->name('edit');
    Route::post('/update/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/delete/{user}', [UserController::class, 'delete'])->name('destroy');
    Route::get('/update/status/{user_id}/{status}', [UserController::class, 'updateStatus'])->name('status');
    Route::post('/password-update/{Id?}', [UserController::class, 'passwordupdate'])->name('passwordupdate');
    Route::get('/import-users', [UserController::class, 'importUsers'])->name('import');
    Route::post('/upload-users', [UserController::class, 'uploadUsers'])->name('upload');
    Route::get('export/', [UserController::class, 'export'])->name('export');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('blog', BlogController::class);
    Route::post('blog/bulk-delete', [BlogController::class, 'bulkDelete'])->name('blog.bulk-delete');
});

//------------visa master and visa services routes -----------///
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('visaservices', VisaServicesController::class);
    Route::post('visaservices/bulk-delete', [VisaServicesController::class, 'bulkDelete'])->name('visaservices.bulk-delete');
});

Route::prefix('admin')->name('admin.')->group(function () {

    Route::delete('visamaster/bulk-delete', [VisaMasterController::class, 'bulkDelete'])
        ->name('visamaster.bulk-delete');

    Route::resource('visamaster', VisaMasterController::class)
        ->parameters(['visamaster' => 'strSlug']);


    Route::get('visamaster/{iVisaId}/details', [VisaServicesController::class, 'index'])
        ->name('visaservices.index');
    Route::get('visamaster/{iVisaId}/details/create', [VisaServicesController::class, 'create'])
        ->name('visaservices.create');
    Route::post('visamaster/{iVisaId}/details', [VisaServicesController::class, 'store'])
        ->name('visaservices.store');
    Route::delete('visamaster/{iVisaId}/details/bulk-delete', [VisaServicesController::class, 'bulkDelete'])
        ->name('visaservices.bulk-delete');

    Route::get('visaservices/{iVisaServiceId}', [VisaServicesController::class, 'show'])
        ->name('visaservices.show');
    Route::get('visaservices/{iVisaServiceId}/edit', [VisaServicesController::class, 'edit'])
        ->name('visaservices.edit');
    Route::put('visaservices/{iVisaServiceId}', [VisaServicesController::class, 'update'])
        ->name('visaservices.update');
    Route::delete('visaservices/{iVisaServiceId}', [VisaServicesController::class, 'destroy'])
        ->name('visaservices.destroy');
});

//------------Country master and Country services routes -----------///
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('countryservices', CountryServicesController::class);
    Route::post('countryservices/bulk-delete', [CountryServicesController::class, 'bulkDelete'])->name('countryservices.bulk-delete');
});

Route::prefix('admin')->name('admin.')->group(function () {

    Route::delete('countrymaster/bulk-delete', [CountryMasterController::class, 'bulkDelete'])
        ->name('countrymaster.bulk-delete');

    Route::resource('countrymaster', CountryMasterController::class)
        ->parameters(['countrymaster' => 'strSlug']);


    Route::get('countrymaster/{iCountryId}/details', [CountryServicesController::class, 'index'])
        ->name('countryservices.index');
    Route::get('countrymaster/{iCountryId}/details/create', [CountryServicesController::class, 'create'])
        ->name('countryservices.create');
    Route::post('countrymaster/{iCountryId}/details', [CountryServicesController::class, 'store'])
        ->name('countryservices.store');
    Route::delete('countrymaster/{iCountryId}/details/bulk-delete', [CountryServicesController::class, 'bulkDelete'])
        ->name('countryservices.bulk-delete');

    Route::get('countryservices/{iCountryServiceId}', [CountryServicesController::class, 'show'])
        ->name('countryservices.show');
    Route::get('countryservices/{iCountryServiceId}/edit', [CountryServicesController::class, 'edit'])
        ->name('countryservices.edit');
    Route::put('countryservices/{iCountryServiceId}', [CountryServicesController::class, 'update'])
        ->name('countryservices.update');
    Route::delete('countryservices/{iCountryServiceId}', [CountryServicesController::class, 'destroy'])
        ->name('countryservices.destroy');
});


//_-------------- faq routes---------------//
Route::prefix('faqs')->name('faqs.')->group(function () {
    Route::get('/', [FaqController::class, 'index'])->name('index');         // Listing
    Route::get('/create', [FaqController::class, 'create'])->name('create'); // Add page
    Route::post('/store', [FaqController::class, 'store'])->name('store');   // Save new
    Route::get('/edit/{id}', [FaqController::class, 'edit'])->name('edit');  // Edit page
    Route::post('/update/{id}', [FaqController::class, 'update'])->name('update'); // Update record
    Route::delete('/{id}', [FaqController::class, 'destroy'])->name('destroy');   // Delete single
    Route::post('/bulk-delete', [FaqController::class, 'bulkDelete'])->name('bulkDelete'); // Bulk delete
    Route::get('/toggle-status/{id}', [FaqController::class, 'toggleStatus'])->name('toggleStatus'); // Change status
});


Route::prefix('admin')->name('admin.')->group(function(){
    Route::resource('testimonials', TestimonialController::class);
    Route::post('testimonials/bulk-delete', [TestimonialController::class, 'bulkDelete'])->name('testimonials.bulk-delete');
});