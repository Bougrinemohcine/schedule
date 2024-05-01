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
        Schema::create('groups', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('group_name');

            $table->string('year')->nullable();
            // $table->string('neveau')->nullable();
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
        Schema::dropIfExists('groups');
    }
};
