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
        Schema::create('class_room_types', function (Blueprint $table) {
            $table->id();
           $table->string('class_room_types');
           $table->unsignedBigInteger('establishment_id');
           $table->foreign('establishment_id')
               ->references('id')
               ->on('establishment')
               ->onDelete('cascade')
               ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_room_types');
    }
};
