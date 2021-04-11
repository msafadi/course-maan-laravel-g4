<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            // "id" BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->id();
            // "name" VARCHAR(255)
            $table->string('name');

            $table->string('slug')->unique();

            $table->unsignedBigInteger('parent_id')->nullable();
            // RESTRICT, SET NULL, CASCADE
            $table->foreign('parent_id')->references('id')->on('categories')->nullOnDelete();

            // "created_at" TIMESTAMP
            // "updated_at" TIMESTAMP
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
