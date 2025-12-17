<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GuruUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guru = Guru::all();

        foreach ($guru as $g) {
            User::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '', $g->nama)) . '@gmail.com'],
                [
                    'name' => $g->nama,
                    'password' => Hash::make('12345678'),
                    'role' => 'guru',
                    'nip' => $g->nip
                ]
            );
        }
    }
}
