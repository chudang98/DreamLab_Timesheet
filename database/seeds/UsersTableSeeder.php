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
            ['employee_id' => 1,  'id' => 100011, 'name' => 'Tran Cong Duc',       'email' => 't1abc@gmail.com',  'attendance_number' => 1,  'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 2,  'id' => 100092, 'name' => 'Nguyen Ngoc Linh',    'email' => 'n2abc@gmail.com',  'attendance_number' => 2,  'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 4,  'id' => 100101, 'name' => 'Nguyen The Hien',     'email' => 'n4abc@gmail.com',  'attendance_number' => 3,  'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 9,  'id' => 100091, 'name' => 'Vu Anh Dan',          'email' => 'v9abc@gmail.com',  'attendance_number' => 4,  'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 11, 'id' => 100076, 'name' => 'Bui The Thang',       'email' => 'b11abc@gmail.com', 'attendance_number' => 5,  'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 14, 'id' => 100081, 'name' => 'Tran Thi Tam Anh',    'email' => 't14abc@gmail.com', 'attendance_number' => 6,  'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 16, 'id' => 100070, 'name' => 'Nguyen Tien Vinh',    'email' => 'n16abc@gmail.com', 'attendance_number' => 7,  'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 17, 'id' => 100072, 'name' => 'Pham Thi Bao Trang',  'email' => 'p17abc@gmail.com', 'attendance_number' => 8,  'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 19, 'id' => 100018, 'name' => 'Nguyen Thi Thu Uyen', 'email' => 'n19abc@gmail.com', 'attendance_number' => 9,  'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 22, 'id' => 100071, 'name' => 'Le Thanh Tu',         'email' => 'l22abc@gmail.com', 'attendance_number' => 10, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 23, 'id' => 100094, 'name' => 'Pham Duc Viet',       'email' => 'p23abc@gmail.com', 'attendance_number' => 11, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 25, 'id' => 100027, 'name' => 'Nguyen Mai Phuong',   'email' => 'n25abc@gmail.com', 'attendance_number' => 12, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 26, 'id' => 100024, 'name' => 'Tran Hoang Duc',      'email' => 't26abc@gmail.com', 'attendance_number' => 13, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 27, 'id' => 100120, 'name' => 'Bui Thi Hong Thanh',  'email' => 'b27abc@gmail.com', 'attendance_number' => 14, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 28, 'id' => 100125, 'name' => 'Le Quynh Mai',        'email' => 'l28abc@gmail.com', 'attendance_number' => 15, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 31, 'id' => 100171, 'name' => 'Vu Quynh Mai',        'email' => 'v31abc@gmail.com', 'attendance_number' => 16, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 32, 'id' => 100126, 'name' => 'Nguyen Huy Hung',     'email' => 'n32abc@gmail.com', 'attendance_number' => 17, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 33, 'id' => 100121, 'name' => 'Do Thi Bao Thoa',     'email' => 'd33abc@gmail.com', 'attendance_number' => 18, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 34, 'id' => 100127, 'name' => 'Le Thu Trang',        'email' => 'l34abc@gmail.com', 'attendance_number' => 19, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 35, 'id' => 100007, 'name' => 'Vu Thi Hop',          'email' => 'v35abc@gmail.com', 'attendance_number' => 20, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 36, 'id' => 100144, 'name' => 'Lo Hoang Quyen',      'email' => 'l36abc@gmail.com', 'attendance_number' => 21, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 38, 'id' => 100131, 'name' => 'Pham Thi Hai Yen',    'email' => 'p38abc@gmail.com', 'attendance_number' => 22, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 39, 'id' => 100005, 'name' => 'Nguyen Xuan Minh',    'email' => 'n39abc@gmail.com', 'attendance_number' => 23, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 40, 'id' => 100175, 'name' => 'Truong Minh Quan',    'email' => 't40abc@gmail.com', 'attendance_number' => 24, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 41, 'id' => 100176, 'name' => 'Nguyen Quang Hiep',   'email' => 'n41abc@gmail.com', 'attendance_number' => 25, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 44, 'id' => 100002, 'name' => 'Chu Thi Hai Yen',     'email' => 'c44abc@gmail.com', 'attendance_number' => 26, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 45, 'id' => 100150, 'name' => 'Nguyen Khanh Hang',   'email' => 'n45abc@gmail.com', 'attendance_number' => 27, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 47, 'id' => 100114, 'name' => 'Dinh Thi Thuy',       'email' => 'd47abc@gmail.com', 'attendance_number' => 28, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 48, 'id' => 100132, 'name' => 'Nguyen Minh Chau',    'email' => 'n48abc@gmail.com', 'attendance_number' => 29, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 49, 'id' => 100058, 'name' => 'Nguyen Van Nghiep',   'email' => 'n49abc@gmail.com', 'attendance_number' => 30, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 50, 'id' => 100001, 'name' => 'Dao Minh Anh',        'email' => 'd50abc@gmail.com', 'attendance_number' => 31, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 51, 'id' => 100109, 'name' => 'Hoang Thi Dieu Quynh','email' => 'h51abc@gmail.com', 'attendance_number' => 32, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 52, 'id' => 100012, 'name' => 'Vu Thi Quy',          'email' => 'v52abc@gmail.com', 'attendance_number' => 33, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 54, 'id' => 100004, 'name' => 'Kim Xuan Phuc',       'email' => 'k54abc@gmail.com', 'attendance_number' => 34, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 56, 'id' => 100153, 'name' => 'Nguyen Danh Huy',     'email' => 'n56abc@gmail.com', 'attendance_number' => 35, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 57, 'id' => 100016, 'name' => 'Ta Minh An',          'email' => 't57abc@gmail.com', 'attendance_number' => 36, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 58, 'id' => 100006, 'name' => 'Vu Thi Trang Van',    'email' => 'v58abc@gmail.com', 'attendance_number' => 37, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 59, 'id' => 100008, 'name' => 'Nguyen Do Anh Khoa',  'email' => 'n59abc@gmail.com', 'attendance_number' => 38, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 60, 'id' => 100161, 'name' => 'Tran Hoang Mai',      'email' => 't60abc@gmail.com', 'attendance_number' => 39, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 61, 'id' => 100179, 'name' => 'Nguyen Do Nguyet Min','email' => 'n61abc@gmail.com', 'attendance_number' => 40, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 62, 'id' => 100200, 'name' => 'Nguyen Tuan Dung',    'email' => 'n62abc@gmail.com', 'attendance_number' => 41, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 63, 'id' => 100155, 'name' => 'Dinh Van Nam',        'email' => 'd63abc@gmail.com', 'attendance_number' => 42, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 64, 'id' => 100167, 'name' => 'Tran Minh Huong',     'email' => 't64abc@gmail.com', 'attendance_number' => 43, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 65, 'id' => 100184, 'name' => 'Hoa Phu Quang',       'email' => 'h65abc@gmail.com', 'attendance_number' => 44, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 66, 'id' => 100158, 'name' => 'Nguyen Thu Ba',       'email' => 'n66abc@gmail.com', 'attendance_number' => 45, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 67, 'id' => 100162, 'name' => 'Dang Thao Trang',     'email' => 'd67abc@gmail.com', 'attendance_number' => 46, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 68, 'id' => 100178, 'name' => 'Pham Thu Thao Ly',    'email' => 'p68abc@gmail.com', 'attendance_number' => 47, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 70, 'id' => 100186, 'name' => 'Ngo Thi Minh Tam',    'email' => 'n70abc@gmail.com', 'attendance_number' => 48, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 73, 'id' => 100156, 'name' => 'Nguyen Truong Giang', 'email' => 'n73abc@gmail.com', 'attendance_number' => 49, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 74, 'id' => 100154, 'name' => 'Luong Thi Thuy Anh',  'email' => 'l74abc@gmail.com', 'attendance_number' => 50, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 77, 'id' => 100003, 'name' => 'Nguyen Hong Van',     'email' => 'n77abc@gmail.com', 'attendance_number' => 51, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 78, 'id' => 100192, 'name' => 'Nguyen Ha My',        'email' => 'n78abc@gmail.com', 'attendance_number' => 52, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 79, 'id' => 100157, 'name' => 'Vu Thi Huyen Trang',  'email' => 'v79abc@gmail.com', 'attendance_number' => 53, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 80, 'id' => 100195, 'name' => 'Mai Xuan Tien',       'email' => 'm80abc@gmail.com', 'attendance_number' => 54, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 81, 'id' => 100169, 'name' => 'Pham Thi Phuong Thao','email' => 'p81abc@gmail.com', 'attendance_number' => 55, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' => 82, 'id' => 100196, 'name' => 'Nguyen Duc Khanh',    'email' => 'n82abc@gmail.com', 'attendance_number' => 56, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' =>156, 'id' => 100194,'name' => 'Chu Van Dang',         'email' => 'c156abc@gmail.com','attendance_number' => 57, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' =>157, 'id' => 100193,'name' => 'Nguyen Phuong Thao',   'email' => 'n157abc@gmail.com','attendance_number' => 58, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')],
            ['employee_id' =>158, 'id' => 100190,'name' => 'Nguyen The Anh',       'email' => 'n158abc@gmail.com','attendance_number' => 59, 'attendance_machine_id' => 1, 'password' => bcrypt('abc')]
        ]);

    }
}
