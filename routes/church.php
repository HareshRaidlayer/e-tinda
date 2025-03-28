<?php

/*
|--------------------------------------------------------------------------
| Affiliate Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Admin

use App\Http\Controllers\ChurchController;

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::controller(ChurchController::class)->group(function () {
        Route::get('/church/all', 'index')->name('church.index');
        Route::get('/church/create', 'create')->name('church.create');
        Route::post('/church', 'store')->name('church.store');
        Route::post('/church/published', 'updatePublished')->name('church.published');
        Route::get('/church/edit/{id}', 'edit')->name('church.edit');
        Route::post('/church/{id}', 'update')->name('church.update');
        Route::get('/church/destroy/{id}', 'destroy')->name('church.destroy');
        Route::get('/donation/delete/{id}', 'donationdelete')->name('church.donationdelete');
        Route::get('/donation/list', 'donationList')->name('church.donationList');
        Route::post('/bulk-donation-delete', 'bulk_donation_delete')->name('bulk_donation_delete');
        Route::post('/donation-clear', 'donation_clear')->name('donation_clear');

    });
});

//FrontEnd
Route::controller(ChurchController::class)->group(function () {
    Route::get('/donate/to/church', 'home')->name('church.home');
    Route::get('/donate/to/church/{id}', 'single_page')->name('church.single');
});



// Route::post('church/process', [ChurchController::class, 'processPayment'])->name('donation.process');
// Route::get('donation/success', function() {
//     return 'Donation successful!';
// })->name('donation.success');

// Route::get('donation/process', [ChurchController::class, 'handleGet'])->name('stripe.get');
// Route::post('donation/process', [ChurchController::class, 'handlePost'])->name('stripe.post');

Route::post('/church/donate/{church}', [ChurchController::class, 'donationCreate'])->name('church.donate');

Route::get('/church/{churchId}/dashboard', [ChurchController::class, 'dashboard'])->name('church.dashboard');
Route::get('/church/{churchId}/stripe/refresh', function ($churchId) {
    return redirect()->route('church.stripe.onboard', ['churchId' => $churchId])->with('error', 'Please complete your Stripe onboarding process.');
})->name('church.stripe.refresh');

Route::post('/stripe/webhook', [ChurchController::class, 'handleStripeWebhook']);

Route::post('/webhook/razorpay', [ChurchController::class, 'handleRazorpayWebhook']);
