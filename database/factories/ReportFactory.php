<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    public function definition(): array
    {
        return [
            'member_id' => Member::factory(),
            'title' => fake()->sentence(6),
            'activity_date' => fake()->dateTimeBetween('-2 months', 'now'),
            'location' => 'Desa Taman Sari',
            'description' => fake()->paragraphs(3, true),
            'status' => 'published',
        ];
    }
}
