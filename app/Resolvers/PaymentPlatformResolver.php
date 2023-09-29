<?php

namespace App\Resolvers;

use DB;

class PaymentPlatformResolver
{
    public function __construct()
    {
        $this->paymentPlatforms = DB::table('integrations')
            ->where('status', 1)
            ->where('type', 'payment')
            ->get();
    }

    public function resolveService($paymentPlatformId)
    {
        $name = strtolower($this->paymentPlatforms->firstWhere('id', $paymentPlatformId)->name);
        $service = config("services.{$name}.class");
        
        if ($service) {
            return resolve($service);
        }

        throw new \Exception('The selected platform is not in the configuration file');
    }
}