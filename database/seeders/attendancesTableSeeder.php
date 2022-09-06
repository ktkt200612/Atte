<?php

namespace Database\Seeders;

use App\Http\Controllers\AttendanceController;
use Illuminate\Database\Seeder;
use App\Models\Attendance;

class attendancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Attendance::factory()->count(30)->create();
    }
}
