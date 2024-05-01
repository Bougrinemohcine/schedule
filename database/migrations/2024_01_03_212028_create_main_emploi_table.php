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
        Schema::create('main_emploi', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('datestart');
            $table->date('dateend');
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
        Schema::dropIfExists('main_emploi');
    }
};
