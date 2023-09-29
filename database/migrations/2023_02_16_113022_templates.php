<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->char('uuid', 50);
            $table->string('name', 255);
            $table->binary('message');
            $table->enum('status', ['active', 'inactive']);
            $table->unsignedInteger('deleted')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('templates');
    }
};
