<?php

use App\Http\Controllers\CertificateController;
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

//Public Routes
Route::get('/',[CertificateController::class,'search'])->name('certificate.search'); ///load homepage/ certificate verification page with search parameter or no parameter

///Authentication Routes
///If login page layout changes, remember to update /admin and /login

Auth::routes();
Route::get('/admin', function () { return view('/login'); } );
Route::get('/login', function () { return view('/login'); });
Route::post('/login/addCredentials', [CertificateController::class,'addCredentials'])->name('certificate.login');
Route::get('/logout',[CertificateController::class,'logout']);


//Admin Routes
Route::get('/dashboard', [CertificateController::class,'getCertificate'])->name('dashboard');
Route::get('/add-certificate',[CertificateController::class,'addCertificate']);
Route::post('/add-certificate',[CertificateController::class,'createCertificate'])->name('certificate.create');
Route::get('/view-certificate/{id}',[CertificateController::class,'viewCertificate']);
Route::get('/edit-certificate/{id}',[CertificateController::class,'editCertificate']);
Route::post('/update-certificate',[CertificateController::class,'updateCertificate'])->name('certificate.update');
Route::get('/delete-certificate/{id}',[CertificateController::class,'deleteCertificate']);
Route::get('/admin-search',[CertificateController::class,'adminSearch'])->name('certificate.adminSearch');
Route::get('/imports-exports', [CertificateController::class,'importExportView']);
Route::get('/export', [CertificateController::class, 'export'])->name('export');
Route::post('import', [CertificateController::class, 'import'])->name('import');