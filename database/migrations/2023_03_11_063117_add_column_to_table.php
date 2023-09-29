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
        Schema::table('project_templates', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive'])->default('active')->after('metadata');
            $table->tinyInteger('deleted')->default(0)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_templates', function (Blueprint $table) {
            $$table->dropColumn(['status', 'deleted']);
        });
    }
};
