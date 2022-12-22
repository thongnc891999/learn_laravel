<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // //===Cách 1 sử dụng seeder
        // //DB : lớp này sẽ thao tác với database MYSQL giúp cho mình
        // //DB::table('user'): lệnh này sẽ thao tác với MYSQL và chỉ định table
        // // cần thao tác là users (table này đã có trong mysql)
        // // method get(): lấy ra tất cả các record có trong table users
        // $users = DB::table('users')->get();
        // //dd($users);

        // // dùng vòng lặp foreach để xử lý công việc như sau
        // // cứ mỗi lần lặp thì lấy ra 1 user
        // // 

        // foreach($users as $user){
        //     // lấy ra id của 1 user
        //     $userId = $user->id;
        //     //tạo ra 5 task
        // $tasks = [
        //     ['name' => 'tasks 1'],
        //     ['name' => 'tasks 2'],
        //     ['name' => 'tasks 3'],
        //     ['name' => 'tasks 4'],
        //     ['name' => 'tasks 5']
        // ];
        // // Insert 5 task này vào table tasks
        // foreach ($tasks as $task){
        //     DB::table('tasks')->insert([
        //         'name'=>$task['name'],
        //         'user_id'=>$userId,
        //     ]);
        // }
        // }

        

        //===Cách 2: Sử dụng Factory kết hợp Seeder
        Task::factory()
        ->count(100)//method count: muốn tạo ra bao nhiêu record
        ->create();//method create(): thực thi lệnh
    }
}
