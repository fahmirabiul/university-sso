<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
        ]);

        // Membuat 50 User palsu. 
        // Untuk setiap user yang berhasil dibuat, kita buatkan profilnya.
        User::factory(50)->create()->each(function ($user) {

            // Membuat profil dummy untuk masing-masing user
            UserProfile::create([
                'user_id' => $user->id,
                'identifier_number' => fake()->unique()->numerify('10########'), // Contoh format NIM/NIP
                'full_name' => fake()->name(),
                'department' => fake()->randomElement(['Teknik Informatika', 'Sistem Informasi', 'Ilmu Komunikasi', 'Manajemen']),
            ]);
        });

        // Membuat 1 Akun Admin Spesifik untuk Anda testing login
        $admin = User::factory()->create([
            'email' => 'admin@university.ac.id',
            // password bawaan factory adalah 'password'
        ]);

        UserProfile::create([
            'user_id' => $admin->id,
            'identifier_number' => '1111111111',
            'full_name' => 'Administrator Utama',
            'department' => 'IT Center',
        ]);

        $adminRole = \App\Models\Role::where('name', 'admin')->first();
        if ($adminRole) {
            $admin->roles()->attach($adminRole->id);
        }
    }
}
