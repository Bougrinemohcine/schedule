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
        Schema::create('formateur_has_filier', function (Blueprint $table) {
            $table->string('barnch_id')->nullable() ;
            $table->foreign('barnch_id')
            ->references('id')
            ->on('branches')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->string('formateur_id');
            $table->foreign('formateur_id')
            ->references('id')
            ->on('users')
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
        Schema::dropIfExists('formateur_has_filier');
    }
};
