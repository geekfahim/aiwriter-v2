<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->text('stripe_id')->nullable();
            $table->decimal('monthly_price', 23, 10);
            $table->decimal('yearly_price', 23, 10);
            $table->text('editional_token_price');
            $table->unsignedInteger('words')->nullable();
            $table->enum('status', ['active', 'inactive', 'deleted']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscription_plans');
    }
};
