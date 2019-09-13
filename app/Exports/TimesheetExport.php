<?php

namespace App\Exports;

// require 'vendor/autoload.php';

// use PhpOffice\PhpSpreadsheet\Spreadsheet;
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
use \PhpOffice\PhpSpreadsheet;



class TimesheetExport implements FromArray, WithEvents, ShouldAutoSize, WithCustomStartCell, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    private static $month;
    private static $yeah;

        // Cell bắt đầu render dữ liệu
    private static $column_data_start = 'A';
    private static $row_data_start = 7;

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
            ]
            
        ];
        
        return [

            AfterSheet::class => function(AfterSheet $event) use ($style_all, $style_border)
            {
                $sheet = $event->sheet;
                
                $sheet->getStyle('A1:CA500')->applyFromArray($style_all);

                $sheet->getRowDimension(static::$row_data_start)->setRowHeight(21);
                $sheet->getRowDimension(static::$row_data_start + 1)->setRowHeight(21);

                    /**  
                      * TODO : Gộp 2 cell các trường thông tin heading
                      * TODO : Bỏ border bottom của ô timesheet sáng
                        ! WARNING : Thay đổi cột bắt đầu dữ liệu chú ý
                    */
                    
                    $heading_Name = 'A'.static::$row_data_start .':A'.(static::$row_data_start + 1);
                    $heading_ID = 'B'.static::$row_data_start .':B'.(static::$row_data_start + 1);
                    $heading_No = 'C'.static::$row_data_start .':C'.(static::$row_data_start + 1);

                $sheet->mergeCells($heading_Name);
                $sheet->mergeCells($heading_ID);
                $sheet->mergeCells($heading_No);

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
                        $sheet->getStyle($index)->getAlignment()->setWrapText(true);
                        // $sheet->getStyle($index)
                        //     ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER_CONTINUOUS);
                        // $sheet->getStyle($index)
                        //     ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
                            
                    }
                    if($i == 6){
                        $end_column = $column;
                    }
                    // $sheet->getDelegate()->getStyle('A1:B3')->getFont()->setSize(14);
                    // $event->getActiveSheet()->getColumnDimension('D')->setWidth(12);
                    $sheet->getColumnDimension($column)->setAutoSize(false);
                    $sheet->getColumnDimension($column)->setWidth(10);
                }

                

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

                // $sheet->getProtection()->setSheet(true);
                // $sheet->getStyle('A1:N1')
                //         ->getProtection()
                //         ->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);

                $title1 = 'Daily Attendance Statistic Report';
                $sheet->setCellValue('A3', $title1);
                $sheet->mergeCells('A3:C4');
                $sheet->getStyle('A3:C4')->applyFromArray($style_all);
                $sheet->getStyle('A3:C4')->applyFromArray($style_border);


                $time = 'From 1-' .static::$month .'-' .static::$yeah .' to' .static::$number_day .'-' .static::$month .'-' .static::$yeah; 
                $sheet->setCellValue('AH3', $time);
                $sheet->mergeCells('AH3:AL4');
                $sheet->getStyle('AH3:AL4')->applyFromArray($style_all);
                $sheet->getStyle('AH3:AL4')->applyFromArray($style_border);  
                
                $sheet->setCellValue('D3', '');
                $sheet->mergeCells('D3:AG4');
                $sheet->getStyle('D3:AG4')->applyFromArray($style_all);
                $sheet->getStyle('D3:AG4')->applyFromArray($style_border);

                // $sheet->getStyle('A3:C5')->setValue('Daily Attendance Statistic Report');

            },
            BeforeSheet::class => function(BeforeSheet $event)
            {

                // $time = 'From 1-' .$month .'-' .$yeah .' to' .static::$number_day .'-' .$month .'-' .$yeah; 

            },
        ];
    }


    public function map($data): array
    {
        // \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder(new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder());
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
                'duty_day' => '',
                'working_day' => '',
                'non_working' => '',
                'late' => '',
                'early' => '',
                
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
        $heading1[] = 'Late (Min)';     
        $heading1[] = 'Early (Min)';      
        $heading1[] = 'O.Time (Hour)';

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
