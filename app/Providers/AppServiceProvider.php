<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Gate::define('manage-users', fn($user) => $user->can('manage users'));
        Gate::define('view-reports', fn($user) => $user->can('view reports'));
        Gate::define('create-crops', fn($user) => $user->can('create crops'));
        Gate::define('update-crops', fn($user) => $user->can('update crops'));
        Gate::define('delete-crops', fn($user) => $user->can('delete crops'));
    }
}
