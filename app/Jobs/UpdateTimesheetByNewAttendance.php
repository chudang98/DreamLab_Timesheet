<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Biz\TimesheetService;

class UpdateTimesheetByNewAttendance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TimesheetService $timesheetService)
    {

        sleep(30);

        ini_set('max_execution_time', 0);
        $attendance = $timesheetService->getOnetNewAttendance();
        while($attendance != null){
            $timesheetService->updateTimesheetByAttendance($attendance);
            $attendance = $timesheetService->getOnetNewAttendance(); 
        }
        // $url = url()->current();
        return redirect('/home');
        
    }

}
