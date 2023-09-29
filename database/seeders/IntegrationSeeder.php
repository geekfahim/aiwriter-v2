<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IntegrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $integrations = [
            ['name' => 'Open AI', 'type' => 'ai', 'description' => 'AI language processing models.', 'logo' => 'open-ai.png', 'updated_at' => Carbon::now()],
            ['name' => 'Stripe', 'type' => 'payment', 'description' => 'Collect payments automatically.', 'logo' => 'stripe-logo.png', 'updated_at' => Carbon::now()],
            ['name' => 'Facebook', 'type' => 'social', 'description' => 'Social Login', 'logo' => 'facebook-logo.png', 'updated_at' => Carbon::now()],
            ['name' => 'Google', 'type' => 'social', 'description' => 'Social Login', 'logo' => 'google-logo.png', 'updated_at' => Carbon::now()],
            ['name' => 'PayPal', 'type' => 'social', 'description' => 'Collect payments automatically.', 'logo' => 'paypal.png', 'updated_at' => Carbon::now()],
            ['name' => 'Paystack', 'type' => 'social', 'description' => 'Collect payments automatically.', 'logo' => 'paystack.svg', 'updated_at' => Carbon::now()],
            ['name' => 'Coinbase', 'type' => 'social', 'description' => 'Collect payments automatically.', 'logo' => 'coinbase.png', 'updated_at' => Carbon::now()],
            ['name' => 'Razorpay', 'type' => 'social', 'description' => 'Collect payments automatically.', 'logo' => 'razorpay.png', 'updated_at' => Carbon::now()],
        ];

        foreach ($integrations as $integration) {
            DB::table('integrations')->insert($integration);
        }
    }
}
