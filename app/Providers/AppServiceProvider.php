<?php

namespace App\Providers;

use App\Filament\Resources\AnouncementResource;
use App\Filament\Resources\EventResource;
use App\Filament\Resources\NoteResource;
use App\Filament\Resources\TaskResource;
use App\Filament\Resources\TicketResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use FilamentQuickCreate\Facades\QuickCreate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Paginator::useBootstrap();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::serving(function () {
            // Using Vite
            Filament::registerViteTheme('resources/css/filament.css');
         
            // Using Laravel Mix
            // Filament::registerTheme(
            //     mix('css/filament.css'),
            // );
        });

        Filament::serving(function(){
            QuickCreate::getResourcesUsing(function(){
                return [
                    TaskResource::class,
                    EventResource::class,
                    NoteResource::class,
                    AnouncementResource::class,
                    TicketResource::class,
                ];
            });
        });
    }
}
