<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id('subscription_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('subscription_plan_id');
            $table->dateTime('start_date', $precision = 0)->nullable();
            $table->dateTime('end_date', $precision = 0)->nullable();
            $table->enum('status', ['active', 'cancelled', 'pending', 'expired', 'inactive']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_subscriptions');
    }
};
