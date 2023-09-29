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
        Schema::table('user_subscriptions', function (Blueprint $table) {
            // rename columns
            $table->renameColumn('subscription_id', 'id');
            $table->renameColumn('subscription_plan_id', 'plan_id');
            $table->renameColumn('start_date', 'created_at');
            $table->renameColumn('end_date', 'recurring_at');

            // add columns
            $table->string('plan_amount', 32)->nullable()->after('subscription_plan_id');
            $table->string('plan_interval', 16)->nullable()->after('plan_amount');
            $table->string('payment_processor', 32)->nullable()->after('plan_interval');
            $table->dateTime('cancelled_at', $precision = 0)->nullable()->after('end_date');

            // modify columns
            $table->string('subscription_plan_id')->nullable()->change();
            $table->string('status', 16)->nullable()->change();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_subscriptions', function (Blueprint $table) {
            // rename columns
            $table->renameColumn('plan_id', 'subscription_plan_id');
            $table->renameColumn('created_at', 'start_date');
            $table->renameColumn('recurring_at', 'end_date');

            // drop columns
            $table->dropColumn('plan_amount');
            $table->dropColumn('plan_interval');
            $table->dropColumn('payment_processor');
            $table->dropColumn('cancelled_at');

            // modify columns
            $table->enum('status', ['active', 'cancelled', 'pending', 'expired', 'inactive']);
        });
    }
};
