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
        Schema::create('audio_contents', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->integer('document_id');
            $table->string('file')->nullable();
            $table->integer('seconds')->nullable();
            $table->text('text')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audio_contents', function (Blueprint $table) {
            Schema::dropIfExists('audio_contents');
        });
    }
};
