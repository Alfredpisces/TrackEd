<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $school = School::firstOrCreate(
            ['name' => 'Rizal National High School'],
            ['division' => 'Division of Manila', 'region' => 'NCR']
        );

        $accounts = [
            ['name' => 'Maria Santos',    'email' => 'admin@deped.edu.ph',      'password' => 'Admin123',   'role' => 'Admin'],
            ['name' => 'Roberto Aquino',  'email' => 'schoolhead@deped.edu.ph', 'password' => 'Head123',    'role' => 'School Head'],
            ['name' => 'Grace Custodio',  'email' => 'counselor@deped.edu.ph',  'password' => 'Counsel123', 'role' => 'Counselor'],
            ['name' => 'Juan Dela Cruz',  'email' => 'teacher@deped.edu.ph',    'password' => 'Teacher123', 'role' => 'Teacher'],
        ];

        foreach ($accounts as $account) {
            User::firstOrCreate(
                ['email' => $account['email']],
                [
                    'name'      => $account['name'],
                    'password'  => Hash::make($account['password']),
                    'role'      => $account['role'],
                    'school_id' => $school->id,
                ]
            );
        }
    }
}
