<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Pagination\Paginator;
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
        Paginator::useBootstrapFive();

        Gate::define('is-customer', function (User $user) {
            return $user->usertype === 'customer';
        });

        Gate::define('is-manager', function (User $user) {
            return $user->usertype === 'manager';
        });

        Gate::define('view-booking', function (User $user, Booking $booking) {
            return ($user->id === $booking->user->id) || $user->usertype == 'manager';
        });

        // Gate::define('')
    }
}
