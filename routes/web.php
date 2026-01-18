<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\DriverController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;

//Auth::routes();

Route::get('/', function () {
    return view('auth.login');
});



Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// صفحة المدير (Protected Routes)
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('/manager/dashboard', [ManagerController::class, 'index'])->name('manager.mdashboard');

    // Routes Management
    Route::get('/manager/routes', [ManagerController::class, 'viewRoutes'])->name('manager.routes');
    Route::post('/manager/routes/create', [ManagerController::class, 'createRoute'])->name('manager.routes.create');
    Route::post('/manager/routes/{route}/update', [ManagerController::class, 'updateRoute'])->name('manager.routes.update');
    Route::delete('/manager/routes/{route}', [ManagerController::class, 'deleteRoute'])->name('manager.routes.delete');

    // Buses Management
    Route::get('/manager/buses', [ManagerController::class, 'viewBuses'])->name('manager.buses');
    Route::get('/manager/buses/create', [ManagerController::class, 'showCreateBus'])->name('manager.buses.create');
    Route::post('/manager/buses', [ManagerController::class, 'createBus'])->name('manager.buses.store');
    Route::get('/manager/buses/{bus}/edit', [ManagerController::class, 'editBus'])->name('manager.buses.edit');
    Route::put('/manager/buses/{bus}', [ManagerController::class, 'updateBus'])->name('manager.buses.update');
    Route::delete('/manager/buses/{bus}', [ManagerController::class, 'deleteBus'])->name('manager.buses.delete');

    // Trips Management
    Route::get('/manager/trips', [ManagerController::class, 'viewTrips'])->name('manager.trips');
    Route::post('/manager/trips/create', [ManagerController::class, 'createTrip'])->name('manager.trips.create');
    Route::get('/manager/trips/{trip}/edit', [ManagerController::class, 'editTrip'])->name('manager.trips.edit');
    Route::put('/manager/trips/{trip}', [ManagerController::class, 'updateTrip'])->name('manager.trips.update');
    Route::delete('/manager/trips/{trip}', [ManagerController::class, 'deleteTrip'])->name('manager.trips.delete');

    // Drivers Management
    Route::get('/manager/drivers', [ManagerController::class, 'viewDrivers'])->name('manager.drivers');
    Route::post('/manager/drivers/create', [ManagerController::class, 'createDriver'])->name('manager.drivers.create');
    Route::get('/manager/drivers/{driver}/edit', [ManagerController::class, 'editDriver'])->name('manager.drivers.edit');
    Route::put('/manager/drivers/{driver}', [ManagerController::class, 'updateDriver'])->name('manager.drivers.update');
    Route::delete('/manager/drivers/{driver}', [ManagerController::class, 'deleteDriver'])->name('manager.drivers.delete');
});
//Route::post('/manager/drivers/{driver}/assign-bus', [ManagerController::class, 'assignBusToDriver'])->name('manager.drivers.assignBus');


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/test-edit/{id}', function ($id) {
    return "<h1>Editing Bus #{$id}</h1>";
});

/*Route::get('/driver/dashboard',function()
{
    return view('driver.dashboard');
}
)->middleware('auth')->name('driver.dashboard');  /* هون الاسم هي بحطوا اختياري لو بدي و بسمي يلي بدي ياه يعني لما اجي اكتب اسم صفحة بكتبها بهاد المفتاح*/




Route::middleware(['auth', 'role:driver'])->group(function () {
    Route::get('/driver/dashboard', [DriverController::class, 'index'])->name('driver.dashboard');
    Route::get('/driver/trips', [DriverController::class, 'trips'])->name('driver.trips');
    Route::get('/driver/bus', [DriverController::class, 'bus'])->name('driver.bus');
    //Route::get('/driver/history', [DriverController::class, 'history'])->name('driver.history');

    Route::post('/driver/start-trip/{trip}', [DriverController::class, 'startTrip'])->name('driver.startTrip');
    Route::get('/driver/check-seat-status/{trip}', [DriverController::class, 'checkSeatStatus'])->name('driver.checkSeatStatus');
});

// Student Routes
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/dashboard', [App\Http\Controllers\Studentcontroller::class, 'dashboard'])->name('student.dashboard');
    Route::get('/student/trips', [App\Http\Controllers\Studentcontroller::class, 'trips'])->name('student.trips');
    Route::get('/student/trips/{trip}/buses', [App\Http\Controllers\Studentcontroller::class, 'buses'])->name('student.buses'); // Changed URL structure slightly for RESTful consistency but can keep logic
    Route::get('/student/trips/{trip}/buses/{bus}/seats', [App\Http\Controllers\Studentcontroller::class, 'seats'])->name('student.seats');

    Route::post('/student/trips/{trip}/seats/{seat}', [App\Http\Controllers\Studentcontroller::class, 'reserveSeat'])->name('student.reserve');
     Route::put('/student/reservations/{booking}/edit', [App\Http\Controllers\Studentcontroller::class, 'editReservation'])->name('student.reservations.update');
    Route::delete('/student/reservations/{booking}', [App\Http\Controllers\Studentcontroller::class, 'cancelReservation'])->name('student.reservations.cancel');

    Route::get('/student/profile', [App\Http\Controllers\Studentcontroller::class, 'profile'])->name('student.profile');
    Route::put('/student/profile', [App\Http\Controllers\Studentcontroller::class, 'updateProfile'])->name('student.profile.update');
    Route::get('/student/reservations', [App\Http\Controllers\Studentcontroller::class, 'reservations'])->name('student.reservations');
});


//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
