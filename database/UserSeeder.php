<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    
    public function run(): void
    {
        
        User::create([
            'name' => 'Usuario Uno',
            'email' => 'usuario1@test.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'Usuario Dos',
            'email' => 'usuario2@test.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}