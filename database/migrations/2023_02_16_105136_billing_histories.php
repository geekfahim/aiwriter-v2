<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('billing_histories', function (Blueprint $table) {
            $table->id('billing_id');
            $table->string('payment_reference')->nullable();
            $table->unsignedBigInteger('subscription_id');
            $table->string('plan');
            $table->decimal('amount', 10, 2);
            $table->dateTime('billing_date');
            $table->string('payment_method')->nullable();
            $table->enum('status', ['Paid', 'Unpaid', 'Cancelled']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('billing_histories');
    }
};
