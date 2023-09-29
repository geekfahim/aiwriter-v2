<?php

namespace App\Models;
use App\Http\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingHistory extends Model {
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function subscription(){
        return $this->belongsTo(UserSubscription::class);
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id', 'id');
    }
}
