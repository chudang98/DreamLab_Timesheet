<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // factory('App\User', 20)->create();
//        $user = App\User::all();
//        $user->roles()->attach(2);
//        $userAdmin = App\User::find(1);
//        $userAdmin->roles()->attach(1);

        DB::table('users')->insert([
            ['id' => 1,  'employee_id' => 100011, 'name' => 'Tran Cong Duc',       'email' => 't1abc@gmail.com',  'attendance_number' => 1,  'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 2,  'employee_id' => 100092, 'name' => 'Nguyen Ngoc Linh',    'email' => 'n2abc@gmail.com',  'attendance_number' => 2,  'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 4,  'employee_id' => 100101, 'name' => 'Nguyen The Hien',     'email' => 'n4abc@gmail.com',  'attendance_number' => 3,  'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 9,  'employee_id' => 100091, 'name' => 'Vu Anh Dan',          'email' => 'v9abc@gmail.com',  'attendance_number' => 4,  'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 11, 'employee_id' => 100076, 'name' => 'Bui The Thang',       'email' => 'b11abc@gmail.com', 'attendance_number' => 5,  'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 14, 'employee_id' => 100081, 'name' => 'Tran Thi Tam Anh',    'email' => 't14abc@gmail.com', 'attendance_number' => 6,  'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 16, 'employee_id' => 100070, 'name' => 'Nguyen Tien Vinh',    'email' => 'n16abc@gmail.com', 'attendance_number' => 7,  'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 17, 'employee_id' => 100072, 'name' => 'Pham Thi Bao Trang',  'email' => 'p17abc@gmail.com', 'attendance_number' => 8,  'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 19, 'employee_id' => 100018, 'name' => 'Nguyen Thi Thu Uyen', 'email' => 'n19abc@gmail.com', 'attendance_number' => 9,  'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 22, 'employee_id' => 100071, 'name' => 'Le Thanh Tu',         'email' => 'l22abc@gmail.com', 'attendance_number' => 10, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 23, 'employee_id' => 100094, 'name' => 'Pham Duc Viet',       'email' => 'p23abc@gmail.com', 'attendance_number' => 11, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 25, 'employee_id' => 100027, 'name' => 'Nguyen Mai Phuong',   'email' => 'n25abc@gmail.com', 'attendance_number' => 12, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 26, 'employee_id' => 100024, 'name' => 'Tran Hoang Duc',      'email' => 't26abc@gmail.com', 'attendance_number' => 13, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 27, 'employee_id' => 100120, 'name' => 'Bui Thi Hong Thanh',  'email' => 'b27abc@gmail.com', 'attendance_number' => 14, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 28, 'employee_id' => 100125, 'name' => 'Le Quynh Mai',        'email' => 'l28abc@gmail.com', 'attendance_number' => 15, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 31, 'employee_id' => 100171, 'name' => 'Vu Quynh Mai',        'email' => 'v31abc@gmail.com', 'attendance_number' => 16, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 32, 'employee_id' => 100126, 'name' => 'Nguyen Huy Hung',     'email' => 'n32abc@gmail.com', 'attendance_number' => 17, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 33, 'employee_id' => 100121, 'name' => 'Do Thi Bao Thoa',     'email' => 'd33abc@gmail.com', 'attendance_number' => 18, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 34, 'employee_id' => 100127, 'name' => 'Le Thu Trang',        'email' => 'l34abc@gmail.com', 'attendance_number' => 19, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 35, 'employee_id' => 100007, 'name' => 'Vu Thi Hop',          'email' => 'v35abc@gmail.com', 'attendance_number' => 20, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 36, 'employee_id' => 100144, 'name' => 'Lo Hoang Quyen',      'email' => 'l36abc@gmail.com', 'attendance_number' => 21, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 38, 'employee_id' => 100131, 'name' => 'Pham Thi Hai Yen',    'email' => 'p38abc@gmail.com', 'attendance_number' => 22, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 39, 'employee_id' => 100005, 'name' => 'Nguyen Xuan Minh',    'email' => 'n39abc@gmail.com', 'attendance_number' => 23, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 40, 'employee_id' => 100175, 'name' => 'Truong Minh Quan',    'email' => 't40abc@gmail.com', 'attendance_number' => 24, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 41, 'employee_id' => 100176, 'name' => 'Nguyen Quang Hiep',   'email' => 'n41abc@gmail.com', 'attendance_number' => 25, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 44, 'employee_id' => 100002, 'name' => 'Chu Thi Hai Yen',     'email' => 'c44abc@gmail.com', 'attendance_number' => 26, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 45, 'employee_id' => 100150, 'name' => 'Nguyen Khanh Hang',   'email' => 'n45abc@gmail.com', 'attendance_number' => 27, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 47, 'employee_id' => 100114, 'name' => 'Dinh Thi Thuy',       'email' => 'd47abc@gmail.com', 'attendance_number' => 28, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 48, 'employee_id' => 100132, 'name' => 'Nguyen Minh Chau',    'email' => 'n48abc@gmail.com', 'attendance_number' => 29, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 49, 'employee_id' => 100058, 'name' => 'Nguyen Van Nghiep',   'email' => 'n49abc@gmail.com', 'attendance_number' => 30, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 50, 'employee_id' => 100001, 'name' => 'Dao Minh Anh',        'email' => 'd50abc@gmail.com', 'attendance_number' => 31, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 51, 'employee_id' => 100109, 'name' => 'Hoang Thi Dieu Quynh','email' => 'h51abc@gmail.com', 'attendance_number' => 32, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 52, 'employee_id' => 100012, 'name' => 'Vu Thi Quy',          'email' => 'v52abc@gmail.com', 'attendance_number' => 33, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 54, 'employee_id' => 100004, 'name' => 'Kim Xuan Phuc',       'email' => 'k54abc@gmail.com', 'attendance_number' => 34, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 56, 'employee_id' => 100153, 'name' => 'Nguyen Danh Huy',     'email' => 'n56abc@gmail.com', 'attendance_number' => 35, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 57, 'employee_id' => 100016, 'name' => 'Ta Minh An',          'email' => 't57abc@gmail.com', 'attendance_number' => 36, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 58, 'employee_id' => 100006, 'name' => 'Vu Thi Trang Van',    'email' => 'v58abc@gmail.com', 'attendance_number' => 37, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 59, 'employee_id' => 100008, 'name' => 'Nguyen Do Anh Khoa',  'email' => 'n59abc@gmail.com', 'attendance_number' => 38, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 60, 'employee_id' => 100161, 'name' => 'Tran Hoang Mai',      'email' => 't60abc@gmail.com', 'attendance_number' => 39, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 61, 'employee_id' => 100179, 'name' => 'Nguyen Do Nguyet Min','email' => 'n61abc@gmail.com', 'attendance_number' => 40, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 62, 'employee_id' => 100200, 'name' => 'Nguyen Tuan Dung',    'email' => 'n62abc@gmail.com', 'attendance_number' => 41, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 63, 'employee_id' => 100155, 'name' => 'Dinh Van Nam',        'email' => 'd63abc@gmail.com', 'attendance_number' => 42, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 64, 'employee_id' => 100167, 'name' => 'Tran Minh Huong',     'email' => 't64abc@gmail.com', 'attendance_number' => 43, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 65, 'employee_id' => 100184, 'name' => 'Hoa Phu Quang',       'email' => 'h65abc@gmail.com', 'attendance_number' => 44, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 66, 'employee_id' => 100158, 'name' => 'Nguyen Thu Ba',       'email' => 'n66abc@gmail.com', 'attendance_number' => 45, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 67, 'employee_id' => 100162, 'name' => 'Dang Thao Trang',     'email' => 'd67abc@gmail.com', 'attendance_number' => 46, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 68, 'employee_id' => 100178, 'name' => 'Pham Thu Thao Ly',    'email' => 'p68abc@gmail.com', 'attendance_number' => 47, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 70, 'employee_id' => 100186, 'name' => 'Ngo Thi Minh Tam',    'email' => 'n70abc@gmail.com', 'attendance_number' => 48, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 73, 'employee_id' => 100156, 'name' => 'Nguyen Truong Giang', 'email' => 'n73abc@gmail.com', 'attendance_number' => 49, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 74, 'employee_id' => 100154, 'name' => 'Luong Thi Thuy Anh',  'email' => 'l74abc@gmail.com', 'attendance_number' => 50, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 77, 'employee_id' => 100003, 'name' => 'Nguyen Hong Van',     'email' => 'n77abc@gmail.com', 'attendance_number' => 51, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 78, 'employee_id' => 100192, 'name' => 'Nguyen Ha My',        'email' => 'n78abc@gmail.com', 'attendance_number' => 52, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 79, 'employee_id' => 100157, 'name' => 'Vu Thi Huyen Trang',  'email' => 'v79abc@gmail.com', 'attendance_number' => 53, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 80, 'employee_id' => 100195, 'name' => 'Mai Xuan Tien',       'email' => 'm80abc@gmail.com', 'attendance_number' => 54, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 81, 'employee_id' => 100169, 'name' => 'Pham Thi Phuong Thao','email' => 'p81abc@gmail.com', 'attendance_number' => 55, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' => 82, 'employee_id' => 100196, 'name' => 'Nguyen Duc Khanh',    'email' => 'n82abc@gmail.com', 'attendance_number' => 56, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' =>156, 'employee_id' => 100194,'name' => 'Chu Van Dang',         'email' => 'c156abc@gmail.com','attendance_number' => 57, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' =>157, 'employee_id' => 100193,'name' => 'Nguyen Phuong Thao',   'email' => 'n157abc@gmail.com','attendance_number' => 58, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['id' =>158, 'employee_id' => 100190,'name' => 'Nguyen The Anh',       'email' => 'n158abc@gmail.com','attendance_number' => 59, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')]
        ]);

    }
}
