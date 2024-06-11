<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
    public function boot(): void
    {
        Blade::if("role", function ($roles) {
            $userRole = auth()->user()->role;
            return in_array($userRole, (array) $roles);
        });

        Gate::define('admin', function (User $user) {
            return $user->role == 1;
        });
        Gate::define('pimpinan', function (User $user) {
            return $user->role == 2;
        });
        Gate::define('umum', function (User $user) {
            return in_array($user->role, ['3', '4', '5']);
        });
    }
}