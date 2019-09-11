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
use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\WithHeadings;


use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeSheet;

class UserExport implements FromArray, WithEvents, ShouldAutoSize, WithCustomStartCell, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    private static $month;
    private static $yeah;
        // Cell bắt đầu render dữ liệu
    private static $column_data_start = 'A';
    private static $row_data_start = 12;

    private static $number_record = 0;

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
                // $event->sheet->getStyle('A3:H3')-> applyFromArray($styleHeading);
                // $event->sheet->mergeCells('A10:E10');
                // $event->sheet->setCellValue('A1', 'Duck');
                // $event->sheet->setCellValue('A2', 'Donald');
                
            },
            BeforeSheet::class => function(BeforeSheet $event){


                // for($i = 0; $i < $number + 3; $i++){
                //     $event->sheet->setCellValue((static::$column_heading + $i). (static::$row_data_start + $i)
                //     , $heading1[$i]);
                //     $event->sheet->setCellValue(static::$column_heading . (static::$row_data_start + $i)
                //     , $heading2[$i]);
                // }



            },
        ];
    }


    public function map($data): array
    {
        $row2 = ['','',''];
        $row1 = [
            $data['name'],
            $data['id'],
            $data['no.'],
        ];
        for($i = 0; $i < $data['number']; $i++){
            $row1[] = $data['array_sheet'][$i]['S'];
            $row2[] = $data['array_sheet'][$i]['C'];
        }
        
        return [
            $row1,
            $row2
        ];
    }

    public function array(): array
    {
        $result = [];
        static::$number_record = 30;
        for($i = 0; $i < 10; $i++){
            $obj = [
                'name' => 'Duck'. $i,
                'id' => '' .$i,
                'no.' => 'NO' .$i,
                'number' => 30,
                'array_sheet' => [],
            ];
            for($j = 1; $j <= 30; $j++){
                $obj['array_sheet'][] = [
                    'S' => 'X',
                    'C' => 'V'
                ];
            }

            array_push($result, $obj);
        }  

        return $result;
    }

    public function headings(): array
    {
        $string = static::$yeah .'-' .static::$month .'-1';
        $first = Carbon::create($string);
        $number = $first->daysInMonth;

        $heading1 = ['ID', 'Name', 'No.'];
        $heading2 = [' ', ' ', ' '];

        for($i = 1; $i <= $number; $i++){
            $first->day = $i;
            array_push($heading1, $first->shortEnglishDayOfWeek);
            array_push($heading2, $first->day);
        }

        return [
            $heading1,
            $heading2
        ];
    }

    public function startCell(): string
    {
        return static::$column_data_start .static::$row_data_start;
    }

}
