<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'organizador@passaporte.io'],
            [
                'name' => 'Organizador Teste',
                'role' => 'organizador',
                'password' => Hash::make('12345678'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'participante@passaporte.io'],
            [
                'name' => 'Participante Teste',
                'role' => 'participante',
                'password' => Hash::make('12345678'),
            ]
        );
    }
}