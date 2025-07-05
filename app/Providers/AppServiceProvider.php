<?php

namespace App\Providers;

use App\Models\Car;
use App\Models\Rental;
use App\Models\Reservation;
use App\Policies\CarPolicy;
use App\Policies\RentalPolicy;
use App\Policies\ReservationPolicy;
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
        // Register policies
        Gate::policy(Car::class, CarPolicy::class);
        Gate::policy(Reservation::class, ReservationPolicy::class);
        Gate::policy(Rental::class, RentalPolicy::class);
    }
}
