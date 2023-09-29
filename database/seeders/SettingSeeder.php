<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            ['key' => 'company_name'],
            ['key' => 'currency'],
            ['key' => 'date_format'],
            ['key' => 'email_method'],
            ['key' => 'favicon'],
            ['key' => 'logo'],
            ['key' => 'smtp_encryption'],
            ['key' => 'smtp_host'],
            ['key' => 'smtp_password'],
            ['key' => 'smtp_port'],
            ['key' => 'smtp_username'],
            ['key' => 'time_format'],
            ['key' => 'timezone'],
            ['key' => 'title'],
            ['key' => 'trial_period'],
            ['key' => 'trial_word_limit'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->insert($setting);
        }
    }
}
