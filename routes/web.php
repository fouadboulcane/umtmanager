<?php

use App\Filament\Resources\TaskResource\Pages\HandleTasks;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DeviController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\ManifestController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AnouncementController;
use App\Http\Controllers\DeviRequestController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [HomeController::class, 'index'])->name('home');

// Route::prefix('/')
//     ->middleware('auth')
//     ->group(function () {
//         Route::resource('roles', RoleController::class);
//         Route::resource('permissions', PermissionController::class);

//         Route::resource('clients', ClientController::class);
//         Route::resource('currencies', CurrencyController::class);
//         Route::resource('devis', DeviController::class);
//         Route::resource('projects', ProjectController::class);
//         Route::resource('tasks', TaskController::class);
//         Route::resource('leaves', LeaveController::class);
//         Route::resource('events', EventController::class);
//         Route::resource('notes', NoteController::class);
//         Route::resource('anouncements', AnouncementController::class);
//         Route::resource('tickets', TicketController::class);
//         Route::resource('articles', ArticleController::class);
//         Route::resource('expenses', ExpenseController::class);
//         Route::resource('invoices', InvoiceController::class);
//         Route::resource('payments', PaymentController::class);
//         Route::resource('presences', PresenceController::class);
//         Route::resource('users', UserController::class);
//         Route::resource('manifests', ManifestController::class);
//         Route::resource('categories', CategoryController::class);
//         Route::resource('posts', PostController::class);
//         Route::resource('devi-requests', DeviRequestController::class);

//     });
