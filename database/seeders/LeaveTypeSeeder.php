<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LeaveType::insert([
        [
            'name' => 'Vacation Leave',
            'days_allowed' => 15,
        ],
        [
            'name' => 'Sick Leave',
            'days_allowed' => 10,
        ],
        [
            'name' => 'Emergency Leave',
            'days_allowed' => 5,
        ],
    ]);

    }
}
