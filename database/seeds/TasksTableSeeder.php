<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Task;
// use Illuminate\Support\Facades\DB; DBファサードを使う場合は必要

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Task::truncate();

        $date_now = date('Y-m-d H:i:s');
        $start_count = 1;
        $end_count = 20;
        for ($i = $start_count; $i <= $end_count; $i++) {
            Task::create([
                'description' => 'task' . sprintf('%003d', $i),
                'done' => mt_rand(0, 1),
                'created_at' => date('Y-m-d H:i:s', strtotime(strval($i - $end_count) . ' day')),
                'updated_at' => date('Y-m-d H:i:s', strtotime(strval($i - $end_count) . ' day')),
            ]);
        }
    }
}
