<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
//        $sqlFilePath = database_path('seeders/gpt.sql');
//        $sql = File::get($sqlFilePath);
//        DB::unprepared($sql);
        $this->call([
            CategorySeeder::class,
            EmailSeeder::class,
            IntegrationSeeder::class,
            PageSeeder::class,
            ProjectTemplateSeeder::class,
            SettingSeeder::class,
            UserSeeder::class,
        ]);
    }
}
