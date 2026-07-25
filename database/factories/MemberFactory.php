<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['role' => 'member']),
            'nim' => fake()->numerify('2#########'),
            'age' => fake()->numberBetween(19, 24),
            'jurusan' => fake()->randomElement(['Teknik Informatika', 'Manajemen', 'Ilmu Komunikasi', 'Agroteknologi', 'Kesehatan Masyarakat']),
            'fakultas' => fake()->randomElement(['Teknik', 'Ekonomi', 'Ilmu Sosial', 'Pertanian', 'Kesehatan']),
            'universitas' => 'Universitas Contoh',
            'jabatan' => fake()->randomElement(['Anggota', 'Koordinator Desa', 'Sekretaris', 'Bendahara', 'Humas']),
            'phone' => fake()->numerify('08##########'),
            'bio' => fake()->paragraph(),
            'instagram' => '@'.fake()->userName(),
        ];
    }
}
