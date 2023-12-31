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
        Schema::table('project_template_categories', function (Blueprint $table) {
            $table->tinyInteger('deleted')->default(0)->after('category_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_template_categories', function (Blueprint $table) {
            $$table->dropColumn('deleted');
        });
    }
};
