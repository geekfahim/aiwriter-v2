<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('integrations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128);
            $table->string('type', 128);
            $table->text('description');
            $table->string('logo', 128)->nullable();
            $table->text('data')->nullable();
            $table->unsignedTinyInteger('status')->default(0);
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('integrations');
    }
};
