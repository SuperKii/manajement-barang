<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'nama' => 'Gabriella Abigail',
            'email' => 'ella@gmail.com',
            'password' => Hash::make('ella19.'),
            'role' => 'admin',
            'alamat' => 'Manado',
            'no_hp' => 109389230,
            'foto_profile' => 'ella.jpeg',
        ]);
    }
}
