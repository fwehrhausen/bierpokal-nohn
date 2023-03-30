<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            "Theke" => "Th3k3Nohn2023!",
            "Einlass" => "31NL455!",
            "Admin" => "PupsiHasi123!"
        ];

        foreach ($users as $name => $password) {
            User::create([
                "name" => $name,
                "password" => Hash::make($password),
                "username" => strtolower($name),
            ]);
        }
    }
}
