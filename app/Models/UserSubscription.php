<?php

namespace App\Models;
use App\Http\Traits\HasUuid;
use App\Services\PaypalService;
use App\Services\StripeService;
use App\Services\RazorpayService;
use App\Services\PaystackService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model {
    use HasFactory;

    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
   

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id', 'id');
    }

    /**
     * Cancel the current plan.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancelSubscription()
    {
        if($this->payment_processor != null){
            switch ($this->payment_processor) {
                case 'paypal':
                    $paymentService = new PaypalService();
                    break;
                case 'stripe':
                    $paymentService = new StripeService();
                    break;
                case 'razorpay':
                    $paymentService = new RazorpayService();
                    break;
                case 'paystack':
                    $paymentService = new PaystackService();
                    break;
                default:
                    throw new \InvalidArgumentException("Invalid payment processor: {$this->payment_processor}");
            }

            $paymentService->cancelSubscription($this->subscription_id);

            // Update the subscription end date and recurring date
            if (!empty($this->recurring_at)) {
                $this->cancelled_at = $this->recurring_at;
                $this->recurring_at = null;
            }

            $this->save();
        }
    }

    /**
     * Get the comments for the blog post.
     */
    public function getPlan()
    {
        return $this->hasOne(SubscriptionPlan::class, 'id', 'plan_id');
    }
}