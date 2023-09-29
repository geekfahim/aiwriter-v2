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
            $table->dropColumn(['fb_id', 'google_id']);
            $table->tinyInteger('is_verified')->default(0)->after('country');
            $table->dateTime('email_verified_at')->nullable()->after('remember_token');
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
            $table->string('fb_id')->nullable()->after('password');
            $table->string('google_id')->nullable()->after('fb_id');
            $table->dropColumn('is_verified');
            $table->dropColumn('email_verified_at');
        });
    }
};
