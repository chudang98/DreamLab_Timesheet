<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\DayRepository;
use App\Day;
use DB;
use App\Validators\DayValidator;

/**
 * Class DayRepositoryEloquent.
 *
 * @package namespace App\Eloquent;
 */
class DayRepositoryEloquent extends BaseRepository implements DayRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Day::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function insertDay($d){
        DB::table('days')->insert(
            [   'date' => $d["date"],
                'state' =>$d["state"],
                'startt_break' =>$d["startt_break"],
                'endt_break' =>$d["endt_break"],
                'reason' => $d["reason"]
            ]
        );
    }

    public function updateDay($d){
        DB::table('days')->where('date', $d["date"])
            ->update([
                'state' =>$d["state"],
                'startt_break' =>$d["startt_break"],
                'endt_break' =>$d["endt_break"],
                'reason' => $d["reason"]
            ]);
    }
    
}
