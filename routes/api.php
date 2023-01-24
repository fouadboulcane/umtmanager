<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DeviController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\LeaveController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\CurrencyController;
use App\Http\Controllers\Api\PresenceController;
use App\Http\Controllers\Api\ManifestController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TaskUsersController;
use App\Http\Controllers\Api\UserNotesController;
use App\Http\Controllers\Api\UserTasksController;
use App\Http\Controllers\Api\EventUsersController;
use App\Http\Controllers\Api\UserLeavesController;
use App\Http\Controllers\Api\UserEventsController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\ClientDevisController;
use App\Http\Controllers\Api\ClientUsersController;
use App\Http\Controllers\Api\AnouncementController;
use App\Http\Controllers\Api\UserTicketsController;
use App\Http\Controllers\Api\UserClientsController;
use App\Http\Controllers\Api\DeviRequestController;
use App\Http\Controllers\Api\ClientEventsController;
use App\Http\Controllers\Api\DeviArticlesController;
use App\Http\Controllers\Api\ProjectTasksController;
use App\Http\Controllers\Api\ArticleDevisController;
use App\Http\Controllers\Api\UserExpensesController;
use App\Http\Controllers\Api\ClientTicketsController;
use App\Http\Controllers\Api\UserPresencesController;
use App\Http\Controllers\Api\UserUserMetasController;
use App\Http\Controllers\Api\CategoryPostsController;
use App\Http\Controllers\Api\ClientProjectsController;
use App\Http\Controllers\Api\ClientInvoicesController;
use App\Http\Controllers\Api\CurrencyClientsController;
use App\Http\Controllers\Api\ProjectExpensesController;
use App\Http\Controllers\Api\ProjectInvoicesController;
use App\Http\Controllers\Api\InvoicePaymentsController;
use App\Http\Controllers\Api\UserSocialLinksController;
use App\Http\Controllers\Api\UserAnouncementsController;
use App\Http\Controllers\Api\UserDeviRequestsController;
use App\Http\Controllers\Api\ClientDeviRequestsController;
use App\Http\Controllers\Api\ManifestDeviRequestsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('clients', ClientController::class);

        // Client Projects
        Route::get('/clients/{client}/projects', [
            ClientProjectsController::class,
            'index',
        ])->name('clients.projects.index');
        Route::post('/clients/{client}/projects', [
            ClientProjectsController::class,
            'store',
        ])->name('clients.projects.store');

        // Client Devis
        Route::get('/clients/{client}/devis', [
            ClientDevisController::class,
            'index',
        ])->name('clients.devis.index');
        Route::post('/clients/{client}/devis', [
            ClientDevisController::class,
            'store',
        ])->name('clients.devis.store');

        // Client Events
        Route::get('/clients/{client}/events', [
            ClientEventsController::class,
            'index',
        ])->name('clients.events.index');
        Route::post('/clients/{client}/events', [
            ClientEventsController::class,
            'store',
        ])->name('clients.events.store');

        // Client Tickets
        Route::get('/clients/{client}/tickets', [
            ClientTicketsController::class,
            'index',
        ])->name('clients.tickets.index');
        Route::post('/clients/{client}/tickets', [
            ClientTicketsController::class,
            'store',
        ])->name('clients.tickets.store');

        // Client Invoices
        Route::get('/clients/{client}/invoices', [
            ClientInvoicesController::class,
            'index',
        ])->name('clients.invoices.index');
        Route::post('/clients/{client}/invoices', [
            ClientInvoicesController::class,
            'store',
        ])->name('clients.invoices.store');

        // Client Devi Requests
        Route::get('/clients/{client}/devi-requests', [
            ClientDeviRequestsController::class,
            'index',
        ])->name('clients.devi-requests.index');
        Route::post('/clients/{client}/devi-requests', [
            ClientDeviRequestsController::class,
            'store',
        ])->name('clients.devi-requests.store');

        // Client Group Clients
        Route::get('/clients/{client}/users', [
            ClientUsersController::class,
            'index',
        ])->name('clients.users.index');
        Route::post('/clients/{client}/users/{user}', [
            ClientUsersController::class,
            'store',
        ])->name('clients.users.store');
        Route::delete('/clients/{client}/users/{user}', [
            ClientUsersController::class,
            'destroy',
        ])->name('clients.users.destroy');

        Route::apiResource('currencies', CurrencyController::class);

        // Currency Clients
        Route::get('/currencies/{currency}/clients', [
            CurrencyClientsController::class,
            'index',
        ])->name('currencies.clients.index');
        Route::post('/currencies/{currency}/clients', [
            CurrencyClientsController::class,
            'store',
        ])->name('currencies.clients.store');

        Route::apiResource('devis', DeviController::class);

        // Devi Articles
        Route::get('/devis/{devi}/articles', [
            DeviArticlesController::class,
            'index',
        ])->name('devis.articles.index');
        Route::post('/devis/{devi}/articles/{article}', [
            DeviArticlesController::class,
            'store',
        ])->name('devis.articles.store');
        Route::delete('/devis/{devi}/articles/{article}', [
            DeviArticlesController::class,
            'destroy',
        ])->name('devis.articles.destroy');

        Route::apiResource('projects', ProjectController::class);

        // Project Tasks
        Route::get('/projects/{project}/tasks', [
            ProjectTasksController::class,
            'index',
        ])->name('projects.tasks.index');
        Route::post('/projects/{project}/tasks', [
            ProjectTasksController::class,
            'store',
        ])->name('projects.tasks.store');

        // Project Expenses
        Route::get('/projects/{project}/expenses', [
            ProjectExpensesController::class,
            'index',
        ])->name('projects.expenses.index');
        Route::post('/projects/{project}/expenses', [
            ProjectExpensesController::class,
            'store',
        ])->name('projects.expenses.store');

        // Project Invoices
        Route::get('/projects/{project}/invoices', [
            ProjectInvoicesController::class,
            'index',
        ])->name('projects.invoices.index');
        Route::post('/projects/{project}/invoices', [
            ProjectInvoicesController::class,
            'store',
        ])->name('projects.invoices.store');

        Route::apiResource('tasks', TaskController::class);

        // Task Collab Members
        Route::get('/tasks/{task}/users', [
            TaskUsersController::class,
            'index',
        ])->name('tasks.users.index');
        Route::post('/tasks/{task}/users/{user}', [
            TaskUsersController::class,
            'store',
        ])->name('tasks.users.store');
        Route::delete('/tasks/{task}/users/{user}', [
            TaskUsersController::class,
            'destroy',
        ])->name('tasks.users.destroy');

        Route::apiResource('leaves', LeaveController::class);

        // Route::apiResource('events', EventController::class);

        // Event Team Members
        Route::get('/events/{event}/users', [
            EventUsersController::class,
            'index',
        ])->name('events.users.index');
        Route::post('/events/{event}/users/{user}', [
            EventUsersController::class,
            'store',
        ])->name('events.users.store');
        Route::delete('/events/{event}/users/{user}', [
            EventUsersController::class,
            'destroy',
        ])->name('events.users.destroy');

        Route::apiResource('notes', NoteController::class);

        Route::apiResource('anouncements', AnouncementController::class);

        Route::apiResource('tickets', TicketController::class);

        Route::apiResource('articles', ArticleController::class);

        // Article Devis
        Route::get('/articles/{article}/devis', [
            ArticleDevisController::class,
            'index',
        ])->name('articles.devis.index');
        Route::post('/articles/{article}/devis/{devi}', [
            ArticleDevisController::class,
            'store',
        ])->name('articles.devis.store');
        Route::delete('/articles/{article}/devis/{devi}', [
            ArticleDevisController::class,
            'destroy',
        ])->name('articles.devis.destroy');

        Route::apiResource('expenses', ExpenseController::class);

        Route::apiResource('invoices', InvoiceController::class);

        // Invoice Payments
        Route::get('/invoices/{invoice}/payments', [
            InvoicePaymentsController::class,
            'index',
        ])->name('invoices.payments.index');
        Route::post('/invoices/{invoice}/payments', [
            InvoicePaymentsController::class,
            'store',
        ])->name('invoices.payments.store');

        Route::apiResource('payments', PaymentController::class);

        Route::apiResource('presences', PresenceController::class);

        Route::apiResource('users', UserController::class);

        // User Leaves
        Route::get('/users/{user}/leaves', [
            UserLeavesController::class,
            'index',
        ])->name('users.leaves.index');
        Route::post('/users/{user}/leaves', [
            UserLeavesController::class,
            'store',
        ])->name('users.leaves.store');

        // User Tickets
        Route::get('/users/{user}/tickets', [
            UserTicketsController::class,
            'index',
        ])->name('users.tickets.index');
        Route::post('/users/{user}/tickets', [
            UserTicketsController::class,
            'store',
        ])->name('users.tickets.store');

        // User Expenses
        Route::get('/users/{user}/expenses', [
            UserExpensesController::class,
            'index',
        ])->name('users.expenses.index');
        Route::post('/users/{user}/expenses', [
            UserExpensesController::class,
            'store',
        ])->name('users.expenses.store');

        // User Created Events
        Route::get('/users/{user}/events', [
            UserEventsController::class,
            'index',
        ])->name('users.events.index');
        Route::post('/users/{user}/events', [
            UserEventsController::class,
            'store',
        ])->name('users.events.store');

        // User Notes
        Route::get('/users/{user}/notes', [
            UserNotesController::class,
            'index',
        ])->name('users.notes.index');
        Route::post('/users/{user}/notes', [
            UserNotesController::class,
            'store',
        ])->name('users.notes.store');

        // User Presences
        Route::get('/users/{user}/presences', [
            UserPresencesController::class,
            'index',
        ])->name('users.presences.index');
        Route::post('/users/{user}/presences', [
            UserPresencesController::class,
            'store',
        ])->name('users.presences.store');

        // User Anouncements
        Route::get('/users/{user}/anouncements', [
            UserAnouncementsController::class,
            'index',
        ])->name('users.anouncements.index');
        Route::post('/users/{user}/anouncements', [
            UserAnouncementsController::class,
            'store',
        ])->name('users.anouncements.store');

        // User Social Links
        Route::get('/users/{user}/social-links', [
            UserSocialLinksController::class,
            'index',
        ])->name('users.social-links.index');
        Route::post('/users/{user}/social-links', [
            UserSocialLinksController::class,
            'store',
        ])->name('users.social-links.store');

        // User User Metas
        Route::get('/users/{user}/user-metas', [
            UserUserMetasController::class,
            'index',
        ])->name('users.user-metas.index');
        Route::post('/users/{user}/user-metas', [
            UserUserMetasController::class,
            'store',
        ])->name('users.user-metas.store');

        // User Tasks
        Route::get('/users/{user}/tasks', [
            UserTasksController::class,
            'index',
        ])->name('users.tasks.index');
        Route::post('/users/{user}/tasks', [
            UserTasksController::class,
            'store',
        ])->name('users.tasks.store');

        // User Devi Requests
        Route::get('/users/{user}/devi-requests', [
            UserDeviRequestsController::class,
            'index',
        ])->name('users.devi-requests.index');
        Route::post('/users/{user}/devi-requests', [
            UserDeviRequestsController::class,
            'store',
        ])->name('users.devi-requests.store');

        // User Events
        Route::get('/users/{user}/events', [
            UserEventsController::class,
            'index',
        ])->name('users.events.index');
        Route::post('/users/{user}/events/{event}', [
            UserEventsController::class,
            'store',
        ])->name('users.events.store');
        Route::delete('/users/{user}/events/{event}', [
            UserEventsController::class,
            'destroy',
        ])->name('users.events.destroy');

        // User Clients
        Route::get('/users/{user}/clients', [
            UserClientsController::class,
            'index',
        ])->name('users.clients.index');
        Route::post('/users/{user}/clients/{client}', [
            UserClientsController::class,
            'store',
        ])->name('users.clients.store');
        Route::delete('/users/{user}/clients/{client}', [
            UserClientsController::class,
            'destroy',
        ])->name('users.clients.destroy');

        // User Tasks2
        Route::get('/users/{user}/tasks', [
            UserTasksController::class,
            'index',
        ])->name('users.tasks.index');
        Route::post('/users/{user}/tasks/{task}', [
            UserTasksController::class,
            'store',
        ])->name('users.tasks.store');
        Route::delete('/users/{user}/tasks/{task}', [
            UserTasksController::class,
            'destroy',
        ])->name('users.tasks.destroy');

        Route::apiResource('manifests', ManifestController::class);

        // Manifest Devi Requests
        Route::get('/manifests/{manifest}/devi-requests', [
            ManifestDeviRequestsController::class,
            'index',
        ])->name('manifests.devi-requests.index');
        Route::post('/manifests/{manifest}/devi-requests', [
            ManifestDeviRequestsController::class,
            'store',
        ])->name('manifests.devi-requests.store');

        Route::apiResource('categories', CategoryController::class);

        // Category Posts
        Route::get('/categories/{category}/posts', [
            CategoryPostsController::class,
            'index',
        ])->name('categories.posts.index');
        Route::post('/categories/{category}/posts', [
            CategoryPostsController::class,
            'store',
        ])->name('categories.posts.store');

        Route::apiResource('posts', PostController::class);

        Route::apiResource('devi-requests', DeviRequestController::class);
    });
