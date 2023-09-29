<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['id' => '1', 'category_name' => 'content/SEO', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '2', 'category_name' => 'social media', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '3', 'category_name' => 'email/letter', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '4', 'category_name' => 'business', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        foreach ($categories as $category) {
            DB::table('project_template_categories')->insert($category);
        }
    }
}
