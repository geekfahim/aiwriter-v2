<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('project_templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('category');
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->text('subcategory')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_templates');
    }
};