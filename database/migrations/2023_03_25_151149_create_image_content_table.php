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
        Schema::create('image_contents', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->integer('document_id')->index('document_id');
            $table->string('resolution', 255)->nullable()->index('resolution');
            $table->string('url', 64)->nullable()->index('url');
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
        Schema::table('image_content', function (Blueprint $table) {
            Schema::dropIfExists('image_contents');
        });
    }
};
