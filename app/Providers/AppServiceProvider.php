<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use App\Observers\AttendanceObserver;

use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;

// use App\Jobs\UpdateTimesheetByNewAttendance;
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
            \App\Repositories\Contracts\AttendanceRepository::class,
            \App\Repositories\Eloquent\AttendanceRepositoryEloquent::class
        );
        $this->app->singleton(
            \App\Repositories\Contracts\TimesheetRepository::class,
            \App\Repositories\Eloquent\TimesheetRepositoryEloquent::class
        );
        $this->app->singleton(
            \App\Repositories\Contracts\DayRepository::class,
            \App\Repositories\Eloquent\DayRepositoryEloquent::class
        );
        $this->app->singleton(
            \App\Repositories\Contracts\UserRepository::class,
            \App\Repositories\Eloquent\UserRepositoryEloquent::class
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

        Queue::after(function (JobProcessed $event) {
            // $event->connectionName
            // $event->job
            // $event->job->payload()
        });
    

    }
}
