<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\Role;
use App\Models\StudyProgram;
use App\Models\Unit;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            MasterDataSeeder::class,
        ]);

        $roles = Role::all()->keyBy('name');
        $studyPrograms = StudyProgram::all()->keyBy('name');
        $units = Unit::all()->keyBy('name');

        $faker = Faker::create('id_ID');

        // 1. Super Admin
        $admin = User::factory()->create([
            'id' => '11111111-1111-1111-1111-100000000001',
            'email' => 'admin@university.ac.id'
        ]);
        UserProfile::create([
            'user_id' => $admin->id,
            'identifier_number' => 'ADM001',
            'full_name' => 'Administrator Utama',
            'unit_id' => $units['IT Center']->id ?? null,
        ]);
        if (isset($roles['admin'])) $admin->roles()->attach($roles['admin']->id);

        // 2. Admin Unit (4 Users)
        for ($i = 1; $i <= 4; $i++) {
            $id = '11111111-1111-1111-1111-1000000000' . sprintf('%02d', 1 + $i);
            $user = User::factory()->create([
                'id' => $id,
                'email' => "admin.unit{$i}@university.ac.id"
            ]);
            $unitName = 'Biro Administrasi ' . $i;
            UserProfile::create([
                'user_id' => $user->id,
                'identifier_number' => "UNT00{$i}",
                'full_name' => "Admin Unit $i",
                'unit_id' => $units[$unitName]->id ?? null,
            ]);
            if (isset($roles['admin_unit'])) $user->roles()->attach($roles['admin_unit']->id);
        }

        // 3. Dosen (10 Users)
        for ($i = 1; $i <= 10; $i++) {
            $id = '11111111-1111-1111-1111-1000000000' . sprintf('%02d', 5 + $i);
            $user = User::factory()->create([
                'id' => $id,
                'email' => "dosen{$i}@university.ac.id"
            ]);
            UserProfile::create([
                'user_id' => $user->id,
                'identifier_number' => "NIDN" . $faker->numerify('########'),
                'full_name' => $faker->name,
                'study_program_id' => $studyPrograms['Teknik Informatika']->id ?? null,
            ]);
            if (isset($roles['dosen'])) $user->roles()->attach($roles['dosen']->id);
        }

        // 4. Mahasiswa (5 Users)
        for ($i = 1; $i <= 5; $i++) {
            $id = '11111111-1111-1111-1111-1000000000' . sprintf('%02d', 15 + $i);
            $user = User::factory()->create([
                'id' => $id,
                'email' => "mhs{$i}@student.ac.id"
            ]);
            UserProfile::create([
                'user_id' => $user->id,
                'identifier_number' => "MHS" . $faker->numerify('#####'),
                'full_name' => $faker->name,
                'study_program_id' => $studyPrograms['Sistem Informasi']->id ?? null,
            ]);
            if (isset($roles['mahasiswa'])) $user->roles()->attach($roles['mahasiswa']->id);
        }
    }
}
