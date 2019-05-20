<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('image')) {
            return;
        }

        Schema::create('image', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('source', 100)->nullable(false);
            $table->integer('id_team')->unsigned();
            $table->foreign('id_team')->references('id')->on('team');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image');
    }
}
