<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->char('uuid', 50);
            $table->string('first_name', 128)->nullable();
            $table->string('last_name', 128)->nullable();
            $table->string('email', 100);
            $table->string('password', 100)->nullable();
            $table->enum('role', ['admin', 'customer', 'manager']);
            $table->unsignedInteger('current_plan')->nullable();
            $table->string('billing_period', 100)->nullable();
            $table->string('fb_id', 128)->nullable();
            $table->string('google_id')->nullable();
            $table->string('stripe_id', 128)->nullable();
            $table->string('country', 128)->nullable();
            $table->enum('status', ['active', 'inactive', 'deleted']);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
