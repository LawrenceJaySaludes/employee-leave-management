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
        'name' => 'Annual Leave',
        'description' => 'Vacation leave',
        'days_allowed' => 15,
        'is_paid' => true,
        'status' => true,
    ],

    [
        'name' => 'Sick Leave',
        'description' => 'Medical leave',
        'days_allowed' => 10,
        'is_paid' => true,
        'status' => true,
    ],

    [
        'name' => 'Emergency Leave',
        'description' => 'Emergency purposes',
        'days_allowed' => 5,
        'is_paid' => true,
        'status' => true,
    ],

    [
        'name' => 'Unpaid Leave',
        'description' => 'No salary deduction',
        'days_allowed' => 999,
        'is_paid' => false,
        'status' => true,
    ]

]);

    }
}
