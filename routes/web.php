<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\FollowupHistoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Root: si está logueado -> dashboard, sino -> login
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// Dashboard (protegido + verificación email)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rutas protegidas (auth + verified para TODO el sistema, coherente con dashboard)
Route::middleware(['auth', 'verified'])->group(function () {

    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD principales (si querés, podés sumar middleware permission por recurso)
    Route::resource('users', UserController::class);
    Route::resource('contacts', ContactController::class);
    Route::resource('opportunities', OpportunityController::class);

    // Contactos: alta rápida (modal / quick create)
    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::post('quick-store', [ContactController::class, 'quickStore'])->name('quick-store');
    });

    // Agenda: vista + alta de seguimientos desde agenda
    Route::prefix('agenda')->name('agenda.')->group(function () {
        Route::get('/', [AgendaController::class, 'index'])->name('index');
        Route::post('followups', [AgendaController::class, 'storeFollowup'])->name('followups.store');
    });

    // Reportes
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('commercial', [ReportController::class, 'commercial'])->name('commercial');
    });

    // Historial de seguimientos (JSON para modal)
    Route::get('opportunities/{opportunity}/followups', [FollowupHistoryController::class, 'index'])
        ->name('opportunities.followups.index');
});

require __DIR__ . '/auth.php';
