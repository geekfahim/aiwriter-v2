<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
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
