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
        Schema::create('classes_has_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('establishment_id');
            $table->foreign('establishment_id')
                ->references('id')
                ->on('establishment')
                ->onDelete('cascade')
                ->onUpdate('cascade');

                $table->unsignedBigInteger('class_rooms_id');
                $table->foreign('class_rooms_id')
                    ->references('id')
                    ->on('class_rooms')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

                $table->unsignedBigInteger('class_room_types_id');
                $table->foreign('class_room_types_id')
                    ->references('id')
                    ->on('class_room_types')
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
        Schema::dropIfExists('classes_has_types');
    }
};
