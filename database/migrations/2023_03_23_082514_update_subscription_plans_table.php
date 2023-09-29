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
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->renameColumn('stripe_id', 'subscription_ids');
            $table->integer('allow_export')->nullable()->default(0);
            $table->integer('allow_copy')->nullable()->default(0);
            $table->integer('yearly_token')->nullable()->default(0);
            $table->integer('monthly_token')->nullable()->default(0);
            $table->integer('trial_token')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->renameColumn('subscription_ids', 'stripe_id');
            $table->dropColumn('allow_export');
            $table->dropColumn('allow_copy');
            $table->dropColumn('yearly_token');
            $table->dropColumn('monthly_token');
            $table->dropColumn('trial_token');
        });
    }
};
