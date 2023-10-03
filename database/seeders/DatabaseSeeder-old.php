<?php

//namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
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
