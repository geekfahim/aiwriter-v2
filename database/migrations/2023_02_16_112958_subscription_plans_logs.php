<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subscription_plans_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('subscription_plan_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->enum('action', ['purchase', 'cancel', 'upgrade', 'downgrade']);
            $table->unsignedInteger('previous_plan_id')->nullable();
            $table->timestamp('timestamp')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscription_plans_logs');
    }
};
