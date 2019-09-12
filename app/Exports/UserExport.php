<?php

namespace App\Exports;

use App\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeSheet;
use \PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use \Maatwebsite\Excel\Sheet;



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

    private static $number_day = 0;
    private static $number_record = 0;

    public static function configDay($month, $yeah){
        static::$month = $month;
        static::$yeah = $yeah;
    }


    public function registerEvents(): array
    {
        $style_all = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];

        $style_border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
                // 'inside' => [
                //     'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                //     'color' => ['argb' => '00000000'],
                // ],

            ],
            
        ];
        
        return [

            AfterSheet::class => function(AfterSheet $event) use ($style_all, $style_border)
            {
                $sheet = $event->sheet;
    
                $sheet->getStyle('A1:CA200')->applyFromArray($style_all);

                    /**  
                      * TODO : Gộp 2 cell các trường thông tin heading
                      * TODO : Bỏ border bottom của ô timesheet sáng
                        ! WARNING : Thay đổi cột bắt đầu dữ liệu chú ý
                    */
                $sheet->mergeCells('A12:A13');
                $sheet->mergeCells('B12:B13');
                $sheet->mergeCells('C12:C13');
                $sheet->mergeCells('C12:C13');

                $duty = static::$number_day + 3;

                $end_column = 'A';
                $end_row = static::$row_data_start + static::$number_record*2 + 1;

                for($i = 1; $i <= 6; $i++){
                    $t = $duty + $i;
                    $column =  Coordinate::stringFromColumnIndex($t);
                    for($j = 0; $j <= static::$number_record; $j++){
                        $row_start = static::$row_data_start + $j*2;
                        $index = $column .$row_start .':' .$column .($row_start+1);
                        $sheet->mergeCells($index);
                    }
                    if($i == 6){
                        $end_column = $column;
                    }
                }
                

                $sheet->getStyle('C7:G7')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('d9d9d9');

                for($i = 0; $i <= static::$number_record; $i++){
                    $cell1 = 'A' . (static::$row_data_start + $i*2);
                    $cell2 = 'A' . (static::$row_data_start + $i*2 + 1);
                    $sheet->mergeCells($cell1 .':' .$cell2);

                    $cell3 = 'B' . (static::$row_data_start + $i*2);
                    $cell4 = 'B' . (static::$row_data_start + $i*2 + 1);
                    $sheet->mergeCells($cell3 .':' .$cell4);
                    
                    $cell5 = 'C' . (static::$row_data_start + $i*2);
                    $cell6 = 'C' . (static::$row_data_start + $i*2 + 1);
                    $sheet->mergeCells($cell5 .':' .$cell6);
                
                }


                    /**  
                        * TODO : Tô màu các cột thứ 7, chủ nhật
                        ! WARNING : Thay đổi cột bắt đầu dữ liệu chú ý
                    **/


                for($i = 0; $i <= static::$number_day + 3; $i++){
                    $cell = $sheet->getCellByColumnAndRow($i, static::$row_data_start); 
                    $day = $cell->getValue();
                    if($day == 'Sat' || $day == 'Sun'){
                        $column = Coordinate::stringFromColumnIndex($i);
                        $index = $column .static::$row_data_start .':' .$column .$end_row;
                        $sheet->getStyle($index)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('d9d9d9');
                    }
                        
                }

                    /**  
                        * TODO : Set border outline cho các hàng
                        ! WARNING : Thay đổi cột bắt đầu dữ liệu chú ý
                    **/
                
                for($i = 0; $i <= static::$number_record; $i++){
                    $row = static::$row_data_start + $i*2;
                    $index = static::$column_data_start .'' .$row .':' .$end_column .($row + 1);
                    $sheet->getStyle($index)->applyFromArray($style_border);

                }


                $lock = [
                    'protection' => [
                        'locked' => TRUE,
                        'hidden' => FALSE
                    ],
                ];
  

                $sheet->getStyle('A1:AN13')->applyFromArray($lock);
                
            },
            BeforeSheet::class => function(BeforeSheet $event)
            {



            },
        ];
    }


    public function map($data): array
    {
        $row2 = ['','',''];
        $row1 = [
            $data['name'],
            $data['id'],
            $data['No.'],
        ];
        for($i = 0; $i < static::$number_day; $i++){
            $row1[] = $data['timesheets'][$i]['S'];
            $row2[] = $data['timesheets'][$i]['C'];
        }     

        
        return [
            $row1,
            $row2
        ];
    }

    public function array(): array
    {
        static::$number_record = 0;

        $users = User::all();


        $result = [];
        

        $date = static::$yeah .'-' .static::$month .'-1';
        static::$number_day = Carbon::create($date)->daysInMonth;
        
        foreach($users as $user){
            $timesheets = $user->getTimeSheet(static::$month, static::$yeah);
            $obj = [
                'name' => $user->name,
                'id' => $user->id,
                'No.' => $user->attendance_number,
                'timesheets' => $timesheets,
            ];

            $result[] = $obj;
            static::$number_record++;


        }


            // array_push($result, $obj);

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
        $heading1[] = 'Duty working day';
        $heading1[] = 'Working day';
        $heading1[] = 'Non working day';
        $heading1[] = 'Late ( Min )';     
        $heading1[] = 'Early ( Min )';      
        $heading1[] = 'O.Time ( Min )';

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
