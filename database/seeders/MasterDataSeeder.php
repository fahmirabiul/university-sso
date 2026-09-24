<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faculty;
use App\Models\StudyProgram;
use App\Models\Unit;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Faculties and Study Programs
        $ft = Faculty::firstOrCreate(['name' => 'Fakultas Teknik', 'code' => 'FT']);
        $fik = Faculty::firstOrCreate(['name' => 'Fakultas Ilmu Komunikasi', 'code' => 'FIK']);

        StudyProgram::firstOrCreate([
            'faculty_id' => $ft->id,
            'name' => 'Sistem Informasi',
            'degree' => 'S1'
        ]);

        StudyProgram::firstOrCreate([
            'faculty_id' => $ft->id,
            'name' => 'Teknik Informatika',
            'degree' => 'S1'
        ]);

        StudyProgram::firstOrCreate([
            'faculty_id' => $fik->id,
            'name' => 'Ilmu Komunikasi',
            'degree' => 'S1'
        ]);

        // 2. Units
        Unit::firstOrCreate(['name' => 'IT Center', 'type' => 'Lembaga']);
        for ($i = 1; $i <= 5; $i++) {
            Unit::firstOrCreate(['name' => 'Biro Administrasi ' . $i, 'type' => 'Biro']);
        }
    }
}
