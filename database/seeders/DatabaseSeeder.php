<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin HR',
            'email' => 'admin@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'ADMIN',
        ]);

        $leaveTypes = [
            ['name' => 'Annual Leave', 'description' => 'Regular annual leave', 'default_days' => 12, 'is_active' => true],
            ['name' => 'Sick Leave', 'description' => 'Leave for medical reasons', 'default_days' => 14, 'is_active' => true],
            ['name' => 'Maternity Leave', 'description' => 'Leave for new mothers', 'default_days' => 90, 'is_active' => true],
        ];

        foreach ($leaveTypes as $type) {
            \App\Models\LeaveType::create($type);
        }

        \App\Models\Employee::factory(5)->create()->each(function ($employee) {
            \App\Models\LeaveRequest::factory(rand(1, 3))->create([
                'employee_id' => $employee->id,
                'leave_type_id' => \App\Models\LeaveType::inRandomOrder()->first()->id,
            ]);
        });
    }
}
