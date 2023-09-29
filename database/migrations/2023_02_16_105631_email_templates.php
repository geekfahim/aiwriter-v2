<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128);
            $table->string('subject', 128);
            $table->binary('body');
            $table->timestamp('modified_at')->useCurrent();
            $table->unsignedBigInteger('modified_by');
        });
    }

    public function down()
    {
        Schema::dropIfExists('email_templates');
    }
};
