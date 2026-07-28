<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Report;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin account
        User::create([
            'name' => 'Admin KKN',
            'email' => 'admin@kkn.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Default settings
        Setting::set('site_name', 'KKN Taman Sari 2026');
        Setting::set('site_tagline', 'Sistem Dokumentasi & Monitoring KKN Taman Sari 2026');
        Setting::set('about', 'KKN Taman Sari 2026 adalah program Kuliah Kerja Nyata yang dilaksanakan di Desa Taman Sari. Website ini menjadi pusat dokumentasi kegiatan, profil anggota, dan galeri foto selama masa pengabdian.');
        Setting::set('location', 'Desa Taman Sari');
        Setting::set('contact_email', 'kkn.tamansari2026@gmail.com');
        Setting::set('contact_phone', '081234567890');
        Setting::set('instagram', '@kkntamansari2026');

        // Data dummy (anggota + laporan contoh) HANYA di-seed kalau faker tersedia.
        // Di production (composer install --no-dev) faker tidak ada, jadi bagian ini di-skip
        // otomatis dan hanya admin + settings yang dibuat.
        // if (function_exists('fake')) {
        //     $this->seedSampleData();
        // }
    }

    private function seedSampleData(): void
    {
        $names = [
            'Ahmad Fauzi', 'Siti Nurhaliza', 'Budi Santoso', 'Dewi Lestari',
            'Rizky Pratama', 'Putri Ayu', 'Andi Wijaya', 'Nadia Rahmawati',
        ];

        $jabatan = ['Koordinator Desa', 'Sekretaris', 'Bendahara', 'Humas', 'Anggota', 'Anggota', 'Anggota', 'Anggota'];

        foreach ($names as $i => $name) {
            $email = strtolower(str_replace(' ', '.', $name)).'@kkn.test';

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt('password'),
                'role' => 'member',
            ]);

            $member = Member::create([
                'user_id' => $user->id,
                'nim' => '2100'.str_pad((string) ($i + 1), 3, '0', STR_PAD_LEFT),
                'age' => fake()->numberBetween(19, 24),
                'jurusan' => fake()->randomElement(['Teknik Informatika', 'Manajemen', 'Ilmu Komunikasi', 'Agroteknologi', 'Kesehatan Masyarakat']),
                'fakultas' => fake()->randomElement(['Teknik', 'Ekonomi', 'Ilmu Sosial', 'Pertanian', 'Kesehatan']),
                'universitas' => 'Universitas Contoh',
                'jabatan' => $jabatan[$i],
                'phone' => '08'.fake()->numerify('##########'),
                'bio' => fake()->paragraph(),
                'instagram' => '@'.fake()->userName(),
                'hobi' => fake()->randomElement(['Fotografi', 'Membaca', 'Futsal', 'Memasak', 'Menulis', 'Badminton']),
            ]);

            // 2-4 sample reports per member
            Report::factory(rand(2, 4))->create([
                'member_id' => $member->id,
            ]);
        }
    }
}
