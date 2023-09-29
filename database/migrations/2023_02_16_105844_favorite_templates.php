<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('favorite_templates', function (Blueprint $table) {
            $table->unsignedBigInteger('template_id');
            $table->unsignedBigInteger('user_id');
            $table->primary(['template_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorite_templates');
    }
};
