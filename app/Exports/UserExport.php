<?php

namespace App\Exports;

use App\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;


use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeSheet;

class UserExport implements FromArray, WithEvents, ShouldAutoSize, WithCustomStartCell
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    private static $month;
    private static $yeah;

    public static function configDay($month, $yeah){
        static::$month = $month;
        static::$yeah = $yeah;
    }


    public function registerEvents(): array
    {
        $styleHeading = [
            'font' => [
                'bold' => true,
            ]
        ];
        return [

            AfterSheet::class => function(AfterSheet $event) use ($styleHeading)
            {
                $event->sheet->getStyle('A3:H3')-> applyFromArray($styleHeading);
            },
            // BeforeSheet::class => function(BeforeSheet $event){
            //     $string = static::$yeah .'-' .static::$month .'-0';
            //     $first = new Carbon($string);
            //     $number = $first->daysInMonth;
        
            //     $heading1 = ['ID', 'Name', 'No.'];
            //     $heading2 = [' ', ' ', ' '];

            //     for($i = 1; $i <= $number; $i++){
            //         $first->day = $i;
            //         array_push($heading1, $first->shortEnglishDayOfWeek);
            //         array_push($heading2, $first->month);
            //     }
            //     $event->getSheet()->row(1, $heading1);
            //     $event->getSheet()->row(2, $heading1);

            // },
        ];
    }

    public function array(): array
    {
        return [
            [1, 2, 3],
            [4, 5, 6]
        ];
    }

    // public function headings(): array
    // {

    //     return null;
    // }

    public function startCell(): string
    {
        return 'A10';
    }

}
