<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Controllers\Controller as BaseController;
use App\Models\Integration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Helper;
use App\Resolvers\PaymentPlatformResolver;
use Stripe\Event;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Subscription;
use Stripe\Webhook;

class WebhookController extends BaseController
{
    public function __construct(PaymentPlatformResolver $paymentPlatformResolver)
    {
        $this->paymentPlatformResolver = $paymentPlatformResolver;
    }

    public function processWebhook(Request $request, $processor)
    {
        $integration = Integration::where('name', $processor)->first();
        $paymentPlatform = $this->paymentPlatformResolver->resolveService($integration->id);
        session()->put('paymentPlatformId', $integration->id);
        
        return $paymentPlatform->handleWebhook($request);
    }
}