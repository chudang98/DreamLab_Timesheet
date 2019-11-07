<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use App\Observers\AttendanceObserver;
use App\Attendance;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
          \App\Repositories\Contracts\AttendanceRepositoryInterface::class,
          \App\Repositories\Eloquent\AttendanceEloquentRepository::class
        );
        $this->app->singleton(
        \App\Repositories\Contracts\TimesheetRepositoryInterface::class,
        \App\Repositories\Eloquent\TimesheetEloquentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Contracts\CalendarRepositoryInterface::class,
            \App\Repositories\Eloquent\CalendarEloquentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Contracts\UserRepositoryInterface::class,
            \App\Repositories\Eloquent\UserEloquentRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Attendance::observe(AttendanceObserver::class);
        // Schema::defaultStringLength(191);
    }
}
