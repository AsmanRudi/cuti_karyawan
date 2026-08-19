<?php

namespace Database\Factories;

use App\Models\LeaveRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LeaveRequest>
 */
class LeaveRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('+1 week', '+1 month');
        $endDate = (clone $startDate)->modify('+' . fake()->numberBetween(1, 5) . ' days');
        return [
            'employee_id' => \App\Models\Employee::factory(),
            'leave_type_id' => \App\Models\LeaveType::factory(),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'total_days' => $startDate->diff($endDate)->days + 1,
            'reason' => fake()->sentence(),
            'status' => 'PENDING',
        ];
    }
}
