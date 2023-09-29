<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    public function run()
    {
        DB::table('pages')->insert([
            [
                'id' => 1,
                'name' => 'home',
                'title' => 'Home',
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'terms',
                'title' => 'Terms & Conditions',
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'name' => 'policy',
                'title' => 'Privacy Policy',
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
