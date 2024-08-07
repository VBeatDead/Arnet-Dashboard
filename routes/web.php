<?php

use App\Http\Controllers\DocumentController;
use App\Http\Middleware\UserRoleCheck;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RedirectIfNotAuthenticated;
use App\Http\Middleware\CheckUserRole;
use App\Http\Controllers\STOController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CoreController;
use App\Http\Controllers\CmeController;
use App\Http\Controllers\TopologyController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\BBMController;

Route::get('/', function () {
    return redirect('/login');
});

//Auth
Route::get('/login', [UserController::class, 'index'])->name('login');
Route::post('/signin', [UserController::class, 'signin'])->name('signin');
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/signup', [UserController::class, 'signup'])->name('signup');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// Map
Route::get('/viewdenah', [MapController::class, 'index'])->name('viewdenah')->middleware(RedirectIfNotAuthenticated::class);
Route::resource('denah', MapController::class)->middleware(RedirectIfNotAuthenticated::class);
Route::get('/adddenah', [MapController::class, 'create'])->name('adddenah')->middleware(RedirectIfNotAuthenticated::class);
Route::post('/storedenah', [MapController::class, 'store'])->name('storedenah');
Route::delete('/denah/{id}', [MapController::class, 'destroy'])->name('deletedenah')->middleware(CheckUserRole::class . ':0');

//TOPOLOGY
Route::get('/topology', [TopologyController::class, 'topology'])->name('topology')->middleware(RedirectIfNotAuthenticated::class);
Route::resource('topology', TopologyController::class)->middleware(RedirectIfNotAuthenticated::class);
Route::get('/addtopology', [TopologyController::class, 'create'])->name('addtopology')->middleware(RedirectIfNotAuthenticated::class);
Route::post('/topology/store', [TopologyController::class, 'store'])->name('storetopology');
Route::get('/topology/edit/{id}', [TopologyController::class, 'edit'])->name('editTopology')->middleware(RedirectIfNotAuthenticated::class);
Route::put('/topology/update/{id}', [TopologyController::class, 'update'])->name('updateTopology')->middleware(RedirectIfNotAuthenticated::class);
Route::delete('/topology/delete/{id}', [TopologyController::class, 'destroy'])->name('deleteTopology')->middleware(RedirectIfNotAuthenticated::class);

// Document
Route::get('/document', [DocumentController::class, 'index'])->name('Document')->middleware(RedirectIfNotAuthenticated::class);
Route::resource('document', DocumentController::class)->middleware(RedirectIfNotAuthenticated::class);
Route::get('/viewdocument', [DocumentController::class, 'index'])->name('viewdocument')->middleware(RedirectIfNotAuthenticated::class);
Route::get('/adddocument', [DocumentController::class, 'create'])->name('adddocument')->middleware(RedirectIfNotAuthenticated::class);
Route::post('/storedocument', [DocumentController::class, 'store'])->name('storedocument');
Route::get('/document/show/{id}', [DocumentController::class, 'show']);
Route::delete('/document/{id}', [DocumentController::class, 'destroy'])->name('deletedocument')->middleware(CheckUserRole::class . ':0');
Route::get('/document/{id}/edit', [DocumentController::class, 'edit'])->name('document.edit')->middleware(RedirectIfNotAuthenticated::class);
Route::put('/document/{id}', [DocumentController::class, 'update'])->name('document.update');

//STO
Route::get('/sto', [STOController::class, 'index'])->name('sto')->middleware(RedirectIfNotAuthenticated::class);
Route::resource('sto', STOController::class)->middleware(RedirectIfNotAuthenticated::class);
Route::get('/viewsto', [STOController::class, 'index'])->name('viewsto')->middleware(RedirectIfNotAuthenticated::class);
Route::get('/addsto', [STOController::class, 'create'])->name('addsto')->middleware(RedirectIfNotAuthenticated::class);
Route::post('/storesto', [STOController::class, 'store'])->name('storesto');
Route::delete('/sto/{id}', [STOController::class, 'destroy'])->name('deletesto')->middleware(CheckUserRole::class . ':0');
Route::get('/sto/{id}/edit', [STOController::class, 'edit'])->name('sto.edit')->middleware(RedirectIfNotAuthenticated::class);
Route::put('/sto/{id}', [STOController::class, 'update'])->name('sto.update');

//Room
Route::get('/room', [RoomController::class, 'index'])->name('room')->middleware(RedirectIfNotAuthenticated::class);
Route::resource('room', RoomController::class)->middleware(RedirectIfNotAuthenticated::class);
Route::get('/viewroom', [RoomController::class, 'index'])->name('viewroom')->middleware(RedirectIfNotAuthenticated::class);
Route::get('/addroom', [RoomController::class, 'create'])->name('addroom')->middleware(RedirectIfNotAuthenticated::class);
Route::post('/storeroom', [RoomController::class, 'store'])->name('storeroom');
Route::delete('/room/{id}', [RoomController::class, 'destroy'])->name('deleteroom')->middleware(CheckUserRole::class . ':0');
Route::get('/room/{id}/edit', [RoomController::class, 'edit'])->name('room.edit')->middleware(RedirectIfNotAuthenticated::class);
Route::put('/room/{id}', [RoomController::class, 'update'])->name('room.update');

//Device
Route::get('/device', [DeviceController::class, 'index'])->name('device.index');
Route::get('/viewdevice', [RoomController::class, 'index'])->name('viewdevice')->middleware(RedirectIfNotAuthenticated::class);
Route::post('/storedevice', [DeviceController::class, 'store'])->name('device.store');
Route::put('/device/{id}', [DeviceController::class, 'update'])->name('device.update');
Route::delete('/device/{id}', [DeviceController::class, 'destroy'])->name('deletedevice');

//User
Route::get('/user', [UserController::class, 'show'])->name('user')->middleware(RedirectIfNotAuthenticated::class);
Route::resource('user', UserController::class)->middleware(RedirectIfNotAuthenticated::class);
Route::get('/viewuser', [UserController::class, 'show'])->name('viewuser')->middleware([RedirectIfNotAuthenticated::class, CheckUserRole::class . ':0']);
Route::get('/adduser', [UserController::class, 'createView'])->name('adduser')->middleware(RedirectIfNotAuthenticated::class);
Route::post('/storeuser', [UserController::class, 'store'])->name('storeuser');
Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('deleteuser')->middleware(CheckUserRole::class . ':0');
Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit')->middleware(RedirectIfNotAuthenticated::class);
Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');

//Core
Route::get('/core', [CoreController::class, 'index'])->name('core')->middleware(RedirectIfNotAuthenticated::class);
Route::get('/core/pie', [CoreController::class, 'view'])->name('corepie')->middleware(RedirectIfNotAuthenticated::class);
Route::resource('core', CoreController::class)->middleware(RedirectIfNotAuthenticated::class);
Route::get('/viewcore', [CoreController::class, 'index'])->name('viewcore')->middleware(RedirectIfNotAuthenticated::class);
Route::get('/addcore', [CoreController::class, 'create'])->name('addcore')->middleware(RedirectIfNotAuthenticated::class);
Route::post('/storecore', [CoreController::class, 'store'])->name('storecore');
Route::delete('/core/{id}', [CoreController::class, 'destroy'])->name('deletecore')->middleware(CheckUserRole::class . ':0');
Route::get('/core/{id}/edit', [CoreController::class, 'edit'])->name('core.edit')->middleware(RedirectIfNotAuthenticated::class);
Route::put('/core/{id}', [CoreController::class, 'update'])->name('core.update');

//Cme
Route::get('/cme', [CmeController::class, 'index'])->name('cme')->middleware(RedirectIfNotAuthenticated::class);
Route::resource('cme', CmeController::class)->middleware(RedirectIfNotAuthenticated::class);
Route::get('/viewcme', [CmeController::class, 'index'])->name('viewcme')->middleware(RedirectIfNotAuthenticated::class);
Route::get('/addcme', [CmeController::class, 'create'])->name('addcme')->middleware(RedirectIfNotAuthenticated::class);
Route::get('/cme/{id}', [CmeController::class, 'show'])->name('cme.show')->middleware(RedirectIfNotAuthenticated::class);
Route::get('/cme/{sto_id}/{type_id}', [CmeController::class, 'show'])->name('cme.show')->middleware(RedirectIfNotAuthenticated::class);
Route::post('/storecme', [CmeController::class, 'store'])->name('storecme');
Route::delete('/cme/{id}', [CmeController::class, 'destroy'])->name('deletecme')->middleware(CheckUserRole::class . ':0');
Route::get('/cme/{id}/edit', [CmeController::class, 'edit'])->name('cme.edit')->middleware(RedirectIfNotAuthenticated::class);
Route::put('/cme/{id}', [CmeController::class, 'update'])->name('cme.update');

//bbm
Route::get('/bbm', [BBMController::class, 'index'])->name('bbm.index')->middleware(RedirectIfNotAuthenticated::class);
Route::resource('bbm', BBMController::class)->middleware(RedirectIfNotAuthenticated::class);
