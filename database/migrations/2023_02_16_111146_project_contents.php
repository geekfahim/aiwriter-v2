<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('project_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('project_id');
            $table->text('content')->nullable();
            $table->decimal('word_count', 23, 2)->default(0);
            $table->unsignedInteger('is_saved')->default(0);
            $table->unsignedInteger('deleted')->default(0);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_contents');
    }
};
