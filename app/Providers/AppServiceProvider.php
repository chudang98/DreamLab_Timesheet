<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;


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
          \App\Repositories\Attendance\AttendanceRepositoryInterface::class,
          \App\Repositories\Attendance\AttendanceEloquentRepository::class
        );
        $this->app->singleton(
        \App\Repositories\Timesheet\TimesheetRepositoryInterface::class,
        \App\Repositories\Timesheet\TimesheetEloquentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Calendar\CalendarRepositoryInterface::class,
            \App\Repositories\Calendar\CalendarEloquentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\User\UserRepositoryInterface::class,
            \App\Repositories\User\UserEloquentRepository::class
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
        Schema::defaultStringLength(191);
    }
}
