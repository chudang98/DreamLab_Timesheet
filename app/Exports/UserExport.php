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
    private static $row_data_start = 7;

    private static $number_day = 0;
    private static $number_record = 0;


    private static $day_work = 0;

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
                        ! WARNING : Thay đổi cột bắt đầu dữ liệu chú ý
                    */
                    
                    $heading_Name = 'A'.static::$row_data_start .':A'.(static::$row_data_start + 1);
                    $heading_ID = 'B'.static::$row_data_start .':B'.(static::$row_data_start + 1);
                    $heading_No = 'C'.static::$row_data_start .':C'.(static::$row_data_start + 1);

                $sheet->mergeCells($heading_Name);
                $sheet->getStyle($heading_Name)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('00e673');
                $sheet->mergeCells($heading_ID);
                $sheet->getStyle($heading_ID)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('00e673');
                $sheet->mergeCells($heading_No);
                $sheet->getStyle($heading_No)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('00e673');

                $duty = static::$number_day + 3;



                /*
                    TODO : Gộp 2 dòng trong trường
                */
                $end_column = 'A';
                $end_row = static::$row_data_start + static::$number_record*2 + 1;

                $array_sum_column = [];
                for($i = 1; $i <= 9; $i++){
                    $t = $duty + $i;
                    $column =  Coordinate::stringFromColumnIndex($t);

                    for($j = 0; $j <= static::$number_record; $j++){
                        $row_start = static::$row_data_start + $j*2;
                        $index = $column .$row_start .':' .$column .($row_start+1);
                        $sheet->mergeCells($index);
                        $sheet->getStyle($index)->getAlignment()->setWrapText(true);
                    }
                    if($i == 9){
                        $end_column = $column;
                    }
                    // $sheet->getDelegate()->getStyle('A1:B3')->getFont()->setSize(14);
                    // $event->getActiveSheet()->getColumnDimension('D')->setWidth(12);
                    $sheet->getColumnDimension($column)->setAutoSize(false);
                    $sheet->getColumnDimension($column)->setWidth(10);
                }

                // for($i = 1; $i <= static::$number_record; $i++){
                //     $row_index = static::$row_data_start + 2 + 2*$i;
                //     $index = $end_column .$row_index;

                //     $sum = '';

                //     for($i = 0; $i < 3; $i++){
                //         // $sum .= $array_sum_column[$i].;
                //     }

                // }


                
                    /*
                        TODO : Heding table Name, ID, No.
                    */
                UserExport::headingExcel($sheet);

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

                $style_bold = [
                    'font' => [
                        'bold' => true,
                    ],
                ];


                /*
                    TODO : HEADING
                */

                $sheet->setCellValue('A1', 'CÔNG TY CỔ PHẦN GLOBAL DREAM LAB');
                $sheet->mergeCells('A1:D2');
                $sheet->getStyle('A1:D2')->applyFromArray($style_all);
                $sheet->getStyle('A1:D2')->applyFromArray($style_border);
                $sheet->getStyle('A1:D2')->applyFromArray($style_bold);
        
                $time = 'From 1-' .static::$month .'-' .static::$yeah .' to ' .static::$number_day .'-' .static::$month .'-' .static::$yeah; 
                $sheet->setCellValue('T3', 'BẢNG CHẤM CÔNG');
                $sheet->mergeCells('T3:Y5');
                $sheet->setCellValue('T4', $time);
                $sheet->getStyle('T3:Y5')->applyFromArray($style_all);
                $sheet->getStyle('T3:Y5')->applyFromArray($style_border);  
                $sheet->getStyle('T3:Y5')->applyFromArray($style_bold);
                
                $sheet->setCellValue('AI5', 'Ngày công chuẩn : ');
                $sheet->mergeCells('AI5:AK6');
                $sheet->getStyle('AI5:AK6')->applyFromArray($style_all);
                $sheet->getStyle('AI5:AK6')->applyFromArray($style_border);
        
                $sheet->setCellValue('AM1', 'Chú thích');
                $sheet->mergeCells('AM1:AP1');
                $sheet->getStyle('AM1:AP1')->applyFromArray($style_all);
                $sheet->getStyle('AM1:AP1')->applyFromArray($style_border);
                $sheet->setCellValue('AM2', 'Vắng (0)');
                $sheet->mergeCells('AM2:AP2');
                $sheet->getStyle('AM2:AP2')->applyFromArray($style_all);
                $sheet->getStyle('AM2:AP2')->applyFromArray($style_border);
                $sheet->getStyle('AM2:AP2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('ffb3b3');
                $sheet->setCellValue('AM3', 'Đến muộn (M)');
                $sheet->mergeCells('AM3:AP3');
                $sheet->getStyle('AM3:AP3')->applyFromArray($style_all);
                $sheet->getStyle('AM3:AP3')->applyFromArray($style_border);
                $sheet->getStyle('AM3:AP3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('ffffb3');
                $sheet->setCellValue('AM4', 'Về sớm (S)');
                $sheet->mergeCells('AM4:AP4');
                $sheet->getStyle('AM4:AP4')->applyFromArray($style_all);
                $sheet->getStyle('AM4:AP4')->applyFromArray($style_border);
                $sheet->getStyle('AM4:AP4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('99e6ff');
                $sheet->setCellValue('AM5', 'Nghỉ phép (P)');
                $sheet->mergeCells('AM5:AP5');
                $sheet->getStyle('AM5:AP5')->applyFromArray($style_all);
                $sheet->getStyle('AM5:AP5')->applyFromArray($style_border);
                $sheet->getStyle('AM5:AP5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('b3ffb3');

                /*
                    TODO : Viết các hàm tính toán cho trương tính toán cuối bảng
                */
                    UserExport::setValueInforCell($sheet);

                    UserExport::fillColorCellByData($sheet);

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
            $data['id'],
            $data['name'],
            $data['No.'],
        ];
        for($i = 0; $i < static::$number_day; $i++){
            if($data['timesheets'][$i]['S'] == 'X'){
                $row1[] = 0.5;
            }else{
                if($data['timesheets'][$i]['S'] == 'V')
                    $row1[] = '0';
                else
                    $row1[] = $data['timesheets'][$i]['S'];

            }
            if($data['timesheets'][$i]['C'] == 'X'){
                $row2[] = 0.5;
            }else{
                if($data['timesheets'][$i]['C'] == 'V')
                    $row2[] = '0';
                else
                    $row2[] = $data['timesheets'][$i]['C'];
            }

        }     

        $row1[] = $data['duty_day'] .'';
        $row1[] = $data['lam_bu'] .'';

        // $row1[] = '';
        // $row1[] = $data['working_day'] .'';
   /*      $row1[] = $data['day_off'] .'';
        $row1[] = $data['late'] .'';
        $row1[] = $data['day_late'] .'';
        $row1[] = $data['early'] .'';
        $row1[] = $data['day_early'] .'';
        $row1[] = $data['total_working_day'] .''; */
        

        
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
            $timesheet_array = $user->getTimesheet(static::$month, static::$yeah);
            $timesheets = $user->getTimeSheetExcel(static::$month, static::$yeah, $timesheet_array);
            $infor = $user->inforWorkingTime($timesheet_array);
            $obj = [
                'id' => $user->id,
                'name' => $user->name,
                'No.' => $user->attendance_number,
                'timesheets' => $timesheets,

                'duty_day' => static::$number_day,
                'lam_bu' => '0',
                // 'working_day' => $infor['working_day'],
      /*           'day_off' => '0',
                'non_working' => $infor['day_off'] .'',
                'late' => $infor['count_late'] .'',
                'early' => $infor['count_early'] .'',
                'day_late' => $infor['late'] .'',
                'day_early' => $infor['early'] .'',
                'total_working_day' => $infor['total_working_day'] .'', */
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
        $heading1[] = 'Ngày công chuẩn';
        $heading1[] = 'Ngày làm bù';
        $heading1[] = 'Ngày làm việc';
        $heading1[] = 'Phép';
        $heading1[] = 'Đi muộn (buổi)';     
        $heading1[] = 'Phạt muộn';
        $heading1[] = 'Về sớm (buổi)';     
        $heading1[] = 'Phạt về sớm';      
        $heading1[] = 'Tổng ngày công';

        return [
            $heading1,
            $heading2
        ];
    }

    public function startCell(): string
    {
        return static::$column_data_start .static::$row_data_start;
    }

    public static function headingExcel($sheet)
    {
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
    }

    public static function setValueInforCell($sheet)
    {
    
        // TODO : Chưa xử lý ngày nghỉ
        $start_infor = static::$number_day + 3;

        $col_phep = $start_infor + 4;
        $col_muon = $start_infor + 5;
        $col_phat_muon = $start_infor + 6;
        $col_som = $start_infor + 7;
        $col_phat_som = $start_infor + 8;
        $col_total = $start_infor + 9;

        $col_lam_bu = $start_infor + 2;
        $col_lam_vc = $start_infor + 3;


        $row_data = static::$row_data_start;

        $column_data = Coordinate::stringFromColumnIndex(static::$number_day + 3);

        for($i = 1; $i <= static::$number_record; $i++){
            
            $row_data += 2;

            $cells_data =  'D' .$row_data .':' .$column_data .($row_data + 1);

            $total_value = '=';
        
            // * Làm bù
            $cell_result =  Coordinate::stringFromColumnIndex($col_lam_bu) .'' .$row_data;
            $total_value .= ('(' .$cell_result);
        
            // * Làm việc
            $cell_result =  Coordinate::stringFromColumnIndex($col_lam_vc) .'' .$row_data;
            $cell_value = '=( COUNTIF(' .$cells_data .', "0.5")'
                    .'+ COUNTIF(' .$cells_data .', "M")'
                    .'+ COUNTIF(' .$cells_data .', "S")'
                    .'+COUNTIF(' .$cells_data .', "P") )/2';
            $sheet->setCellValue($cell_result, $cell_value);
            $total_value .= (' + ' .$cell_result);
            
                // * Phép
            $cell_result =  Coordinate::stringFromColumnIndex($col_phep) .'' .$row_data;
            $cell_value = '=COUNTIF(' .$cells_data .', "P")';
            $sheet->setCellValue($cell_result, $cell_value);
            $total_value .= (' + ' .$cell_result);

                // * Số buổi đi làm muộn
            $result_M =  Coordinate::stringFromColumnIndex($col_muon) .'' .$row_data;
            $cell_value = '=COUNTIF(' .$cells_data .', "M")';
            $sheet->setCellValue($result_M, $cell_value);


                // * Số buổi đi về sớm
            $result_S =  Coordinate::stringFromColumnIndex($col_som) .'' .$row_data;
            $cell_value = '=COUNTIF(' .$cells_data .', "S")';
            $sheet->setCellValue($result_S, $cell_value);

                // * Phạt đến muộn
            $cell_result =  Coordinate::stringFromColumnIndex($col_phat_muon) .'' .$row_data;;
            $cell_value = '=INT(' .$result_M .'/3)';
            $sheet->setCellValue($cell_result, $cell_value);
            $total_value .= (' - ' .$cell_result);


                // * Phạt về sớm
            $cell_result =  Coordinate::stringFromColumnIndex($col_phat_som) .'' .$row_data;;
            $cell_value = '=INT(' .$result_S .'/3)';
            $sheet->setCellValue($cell_result, $cell_value);
            $total_value .= (' - ' .$cell_result .')');


            $cell_result =  Coordinate::stringFromColumnIndex($col_total) .'' .$row_data;;
            $sheet->setCellValue($cell_result, $total_value);
                // *

        }
    }
    
    public static function fillColorCellByData($sheet)
    {
        for($i = 1; $i <= static::$number_day; $i++){
            for($j = 1; $j <= static::$number_record; $j++){
                $column = Coordinate::stringFromColumnIndex($i + 3);
                $row = static::$row_data_start + $j*2;
                $index = $column .$row;

                $cell = $sheet->getCell($index);
                $data = $cell->getValue();
                if($data == '0')
                {
                    $sheet->getStyle($index)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('ffb3b3');
                }else
                {
                    if($data == 'P')
                        $sheet->getStyle($index)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('b3ffb3');
                    else
                        if($data == 'M')
                            $sheet->getStyle($index)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                ->getStartColor()->setARGB('ffffb3');
                        else
                            if($data == 'S')
                                $sheet->getStyle($index)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                ->getStartColor()->setARGB('99e6ff');
                }

                $row++;
                $index = $column .$row;
                $cell = $sheet->getCell($index);
                $data = $cell->getValue();
                if($data == '0')
                {
                    $sheet->getStyle($index)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('ffb3b3');
                }else
                {
                    if($data == 'P')
                        $sheet->getStyle($index)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('b3ffb3');
                    else
                        if($data == 'M')
                            $sheet->getStyle($index)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                ->getStartColor()->setARGB('ffffb3');
                        else
                            if($data == 'S')
                                $sheet->getStyle($index)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                ->getStartColor()->setARGB('99e6ff');
                }

            }
        }
    }

}
