<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('billing_information')->nullable()->after('role');
             // drop columns
            $table->dropColumn('current_plan');
            $table->dropColumn('billing_period');
            $table->dropColumn('stripe_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('billing_information');
            $table->unsignedInteger('current_plan')->nullable();
            $table->string('billing_period', 100)->nullable();
            $table->string('stripe_id', 100)->nullable();
        });
    }
};
