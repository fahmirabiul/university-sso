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
            MasterDataSeeder::class,
        ]);

        $roles = \App\Models\Role::all()->keyBy('name');
        $studyPrograms = \App\Models\StudyProgram::all()->keyBy('name');
        $units = \App\Models\Unit::all()->keyBy('name');

        // 1. Super Admin
        $admin = User::factory()->create(['email' => 'admin@university.ac.id']);
        UserProfile::create([
            'user_id' => $admin->id,
            'identifier_number' => 'ADM001',
            'full_name' => 'Administrator Utama',
            'unit_id' => $units['IT Center']->id ?? null,
        ]);
        if (isset($roles['admin'])) $admin->roles()->attach($roles['admin']->id);

        // 2. Admin Unit (5 Users)
        for ($i = 1; $i <= 5; $i++) {
            $user = User::factory()->create(['email' => "admin.unit{$i}@university.ac.id"]);
            $unitName = 'Biro Administrasi ' . $i;
            UserProfile::create([
                'user_id' => $user->id,
                'identifier_number' => "UNT00{$i}",
                'full_name' => "Admin Unit {$i}",
                'unit_id' => $units[$unitName]->id ?? null,
            ]);
            if (isset($roles['admin_unit'])) $user->roles()->attach($roles['admin_unit']->id);
        }

        // 3. Dosen (5 Users)
        for ($i = 1; $i <= 5; $i++) {
            $user = User::factory()->create(['email' => "dosen{$i}@university.ac.id"]);
            UserProfile::create([
                'user_id' => $user->id,
                'identifier_number' => "NIDN00{$i}",
                'full_name' => "Dosen Pengajar {$i}",
                'study_program_id' => $studyPrograms['Teknik Informatika']->id ?? null,
            ]);
            if (isset($roles['dosen'])) $user->roles()->attach($roles['dosen']->id);
        }

        // 4. Mahasiswa (4 Users, 2 di jurusan yang sama)
        $mahasiswaData = [
            ['email' => 'mhs1@student.ac.id', 'nim' => 'MHS001', 'name' => 'Mahasiswa 1', 'dept' => 'Sistem Informasi'],
            ['email' => 'mhs2@student.ac.id', 'nim' => 'MHS002', 'name' => 'Mahasiswa 2', 'dept' => 'Sistem Informasi'], // Jurusan sama
            ['email' => 'mhs3@student.ac.id', 'nim' => 'MHS003', 'name' => 'Mahasiswa 3', 'dept' => 'Teknik Informatika'],
            ['email' => 'mhs4@student.ac.id', 'nim' => 'MHS004', 'name' => 'Mahasiswa 4', 'dept' => 'Ilmu Komunikasi'],
        ];

        foreach ($mahasiswaData as $data) {
            $user = User::factory()->create(['email' => $data['email']]);
            UserProfile::create([
                'user_id' => $user->id,
                'identifier_number' => $data['nim'],
                'full_name' => $data['name'],
                'study_program_id' => $studyPrograms[$data['dept']]->id ?? null,
            ]);
            if (isset($roles['mahasiswa'])) $user->roles()->attach($roles['mahasiswa']->id);
        }
    }
}
