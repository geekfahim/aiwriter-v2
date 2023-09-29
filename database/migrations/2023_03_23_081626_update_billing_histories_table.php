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
        Schema::table('billing_histories', function (Blueprint $table) {
            // rename columns
            $table->renameColumn('payment_reference', 'payment_id');
            $table->renameColumn('subscription_id', 'user_id');
            $table->renameColumn('plan', 'plan_id');
            $table->renameColumn('payment_method', 'processor');
            
            // add columns
            $table->string('currency', 10)->nullable()->after('amount');
            $table->string('interval', 20)->nullable()->after('currency');
            $table->text('product')->nullable()->after('interval');
            $table->text('coupon')->nullable()->after('product');
            $table->text('tax_rates')->nullable()->after('coupon');
            $table->text('seller')->nullable()->after('tax_rates');
            $table->text('customer')->nullable()->after('seller');

            // modify columns
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
        Schema::table('billing_histories', function (Blueprint $table) {
            // rename columns back to original names
            $table->renameColumn('payment_id', 'payment_reference');
            $table->renameColumn('user_id', 'subscription_id');
            $table->renameColumn('plan_id', 'plan');
            $table->renameColumn('processor', 'payment_method');

            // drop added columns
            $table->dropColumn('currency');
            $table->dropColumn('interval');
            $table->dropColumn('product');
            $table->dropColumn('coupon');
            $table->dropColumn('tax_rates');
            $table->dropColumn('seller');
            $table->dropColumn('customer');

            // modify columns back to original types
            $table->enum('status', ['Paid', 'Unpaid', 'Cancelled'])->change();
        });
    }
};
