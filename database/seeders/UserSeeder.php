<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'uuid' => Str::uuid(),
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'admin@demo.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);
    }
}
