<?php

use App\Http\Controllers\backoffice\AdminController;
use App\Http\Controllers\backoffice\BankController;
use App\Http\Controllers\backoffice\BookingController;
use App\Http\Controllers\backoffice\CarouselController;
use App\Http\Controllers\backoffice\FeatureAndFacController;
use App\Http\Controllers\backoffice\RoomController;
use App\Http\Controllers\backoffice\SettingController;
use App\Http\Controllers\frontoffice\LeaveMessageController;
use App\Http\Controllers\frontoffice\UserBookingController;
use App\Http\Controllers\view\BackController;
use App\Http\Controllers\view\FrontController;
use Illuminate\Support\Facades\Route;

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

/* views */

Route::get('/', [FrontController::class, 'getHome'])->name('home');
Route::get('/facilities', [FrontController::class, 'facilitiesPage'])->name('facilities');
Route::get('/about', [FrontController::class, 'aboutPage'])->name('about');
Route::get('/bookingsearch', [FrontController::class, 'bookingSearchPage'])->name('bookingsearch');
Route::get('/contactus', [FrontController::class, 'contactPage'])->name('contactus');
Route::get('/roomdetails', [FrontController::class, 'roomDetailsPage'])->name('room-details');
Route::get('/bookingdetails', [FrontController::class, 'bookingDetailsPage'])->name('booking-details');
Route::get('/rooms', [FrontController::class, 'roomPage'])->name('rooms');

Route::post('/leavemessage', [LeaveMessageController::class, 'createMessage']);

/* Controllers */
Route::get('/checkbooktimeout', [UserBookingController::class, 'checkBookTimeout']);
Route::delete('/deletetempbook/{temp_id}', [UserBookingController::class, 'deleteTempBooking']);
Route::post('/confirmbooking', [UserBookingController::class, 'createBookOrder']);
Route::post('/confirmrecaptcha', [UserBookingController::class, 'confirmreCaptcha']);

/* Route middleware users */
Route::middleware('auth:web')->group(function () {
});

Route::prefix('admin')->group(function () {
    /* Views */
    Route::get('/login', [BackController::class, 'loginPage'])->name('admin-login');
    /* Controllers */
    Route::post('/signin', [AdminController::class, 'signIn']);
    Route::post('/register', [AdminController::class, 'register']);

    /* Route middleware admin */
    Route::middleware('auth-admin:admin')->group(function () {
        Route::middleware('admin-check')->group(function () {
            /* Controllers */
            Route::get('/', [BackController::class, 'adminPage'])->name('admin');
            Route::get('/logout', [AdminController::class, 'onLogout'])->name('logout');

            Route::post('/updatesite', [SettingController::class, 'onUpdateSite']);
            Route::post('/updateshutdown', [SettingController::class, 'onUpdateShutdown']);
            Route::post('/updatecontact', [SettingController::class, 'onUpdateContact']);

            Route::get('/getcontact', [SettingController::class, 'getContact']);

            Route::get('/carousel/{id}', [CarouselController::class, 'getById']);
            Route::post('/carousel/create', [CarouselController::class, 'create']);
            Route::post('/carousel/update', [CarouselController::class, 'update']);
            Route::delete('/carousel/delete', [CarouselController::class, 'delete']);

            Route::get('/messageone/{msg_id}', [LeaveMessageController::class, 'getMessageById']);
            Route::delete('/message/delete/{msg_id}', [LeaveMessageController::class, 'deleteMessage']);

            /* Feature & Facilities */
            Route::post('/feature/create', [FeatureAndFacController::class, 'createFeature']);
            Route::get('/featureone/{id}', [FeatureAndFacController::class, 'getFeatureById']);
            Route::post('/feature/update', [FeatureAndFacController::class, 'updateFeature']);

            Route::post('/fac/create', [FeatureAndFacController::class, 'createFac']);
            Route::get('/facone/{id}', [FeatureAndFacController::class, 'getFacById']);
            Route::post('/fac/update', [FeatureAndFacController::class, 'updateFac']);

            Route::patch('/updatefacdisplay/{id}', [FeatureAndFacController::class, 'updateFacDisplay']);
            Route::patch('/updatefeaturedisplay/{id}', [FeatureAndFacController::class, 'updateFeatureDisplay']);
            Route::delete('/deletefac/{id}', [FeatureAndFacController::class, 'deleteFac']);
            Route::delete('/deletefeature/{id}', [FeatureAndFacController::class, 'deleteFeature']);

            /* Bank */
            Route::get('/bankone/{id}', [BankController::class, 'getBankById']);
            Route::post('/bank/create', [BankController::class, 'createBank']);
            Route::post('/bank/update', [BankController::class, 'updateBank']);
            Route::patch('/updatebankdisplay/{id}', [BankController::class, 'updateBankDisplay']);
            Route::delete('/deletebank/{id}', [BankController::class, 'deleteBank']);

            /* Rooms */
            Route::get('/roomone/{id}', [RoomController::class, 'getRoomById']);
            Route::get('/gallery/{id}', [RoomController::class, 'getGalleryById']);
            Route::post('/room/create', [RoomController::class, 'createRoom']);
            Route::delete('/deleteroom/{id}', [RoomController::class, 'deleteRoom']);

            Route::post('/room/update', [RoomController::class, 'updateRoom']);
            Route::post('/room/addimage', [RoomController::class, 'addImage']);
            Route::patch('/updateroomdisplay/{id}', [RoomController::class, 'updateRoomDisplay']);
            Route::patch('/updategaldefault/{id}', [RoomController::class, 'updateGalleryDefault']);
            Route::delete('/deletegal/{id}', [RoomController::class, 'deleteGallery']);

            /* Admins */
            Route::get('/adminone/{id}', [AdminController::class, 'getAdminById']);
            Route::post('/admincreate', [AdminController::class, 'register']);
            Route::post('/adminupdate', [AdminController::class, 'updateAdmin']);
            Route::delete('/deleteadmin/{id}', [AdminController::class, 'deleteAdmin']);

            /* booking */

            Route::post('/updatebookstatus', [BookingController::class, 'updatebookingStatus']);
            Route::get('/bookingone/{id}', [BookingController::class, 'getBookingById']);
            Route::post('/prebooking', [BookingController::class, 'preBooking']);
            Route::delete('/deletebooking/{id}', [BookingController::class, 'deleteBooking']);
            Route::post('/confirmbooking', [BookingController::class, 'createBookOrderAdmin']);
            Route::post('/bookingcalendar', [BookingController::class, 'bookingCalendar']);

        });
    });
});
