<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

// Clear cache =========================================================
Route::get('/clear-cache', function () {
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    return back()->with('Clear', 'Clear Cache แล้ว');
});

// --------------------------------------------------------------------------------------

// Auth *****
Route::group(['middleware' => ['auth']], function () {

// DDC SSO *****
// Route::group(['prefix', 'middleware' => 'keycloak-web'], function () {

    Route::get('index', [HomeController::class, 'index'])->name('home');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

    Route::get('home', function () {
        return view('home2');
    });
    Route::get('/', function () {
        return view('home2');
        // return redirect('keycloak/login');
    });

    route::get('home2', [UserController::class, 'home2'])->name('home2');

    // Table Province (CRUD) =========================================================
    route::get('table', [UserController::class, 'table'])->name('table');
    route::post('table/insert', [UserController::class, 'table_insert'])->name('table_insert');
    route::get('table/edit/{id}', [UserController::class, 'table_edit'])->name('table_edit');
    route::post('table/update', [UserController::class, 'table_update'])->name('table_update');
    route::get('table/delete/{id}', [UserController::class, 'table_delete'])->name('table_delete');

    // Contact Us =========================================================
    route::get('contact', [UserController::class, 'contact'])->name('contact');

    // Dashboard =========================================================
    route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    // Profile
    route::get('profile', [UserController::class, 'profile'])->name('profile');
    route::post('profile/update', [UserController::class, 'profile_update'])->name('profile.update');
    Route::post('crop', [UserController::class, 'crop'])->name('crop');
    Route::post('change_password', [UserController::class, 'change_password'])->name('change_password');

    // Upload File =========================================================
    route::get('form/upload', [UserController::class, 'form_upload'])->name('form.upload');
    route::post('form/upload/insert', [UserController::class, 'form_upload_insert'])->name('form.upload_insert');
    route::get('form/upload/download/{id}', [UserController::class, 'form_upload_download'])->name('form.upload_download');
    route::post('form/upload/delete', [UserController::class, 'form_upload_delete'])->name('form.upload_delete');
    route::get('form/upload/truncate', [UserController::class, 'form_upload_truncate'])->name('form.upload_truncate');



    // Upload Image =========================================================
    route::get('form/image', [UserController::class, 'form_image'])->name('form.image');
    route::post('form/image/insert', [UserController::class, 'form_image_insert'])->name('form.image_insert');
    route::get('form/image/download/{id}', [UserController::class, 'form_image_download'])->name('form.image_download');
    route::post('form/image/delete', [UserController::class, 'form_image_delete'])->name('form.image_delete');

    // API : Province Relate =========================================================
    route::get('form/relate', [UserController::class, 'form_relate'])->name('form.relate');
    route::post('form/relate/insert', [UserController::class, 'form_relate_insert'])->name('form.relate_insert');

    Route::get('/district', function () {
        return view("district/index");
    });

    // ==========================================================================
    // Work Shop : Survey
    // ==========================================================================

    // Form
    route::get('workshop/form', [UserController::class, 'workshop_form'])->name('workshop.form');
    route::post('workshop/form/insert', [UserController::class, 'workshop_form_insert'])->name('workshop.form_insert');
    route::get('workshop/form/edit/{id}', [UserController::class, 'workshop_form_edit'])->name('workshop.form_edit');
    route::post('workshop/form/update', [UserController::class, 'workshop_form_update'])->name('workshop.form_update');
    route::post('workshop/form/delete', [UserController::class, 'workshop_form_delete'])->name('workshop.form_delete');

    // List
    route::get('workshop/list', [UserController::class, 'workshop_list'])->name('workshop.list');

    // Detail
    route::get('workshop/detail/{id}', [UserController::class, 'workshop_detail'])->name('workshop.detail');
    route::get('workshop/detail/delete/img/', [UserController::class, 'workshop_detail_delete_img'])->name('workshop.detail_delete_img');

    route::get('truncate', [UserController::class, 'truncate'])->name('truncate');


    // ==========================================================================
    // Line Notify
    // ==========================================================================
    route::get('line', [UserController::class, 'line'])->name('line');
    route::post('line/insert',[UserController::class,'line_insert'])->name('line_insert');
    route::get('line/notify', [UserController::class, 'line_notify'])->name('line_notify');
    route::post('line/send', [UserController::class, 'line_send'])->name('line_send');

    route::get('qrcode', [UserController::class, 'qrcode'])->name('qrcode');

});
