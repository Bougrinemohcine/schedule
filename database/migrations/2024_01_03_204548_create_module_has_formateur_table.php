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
        Schema::create('module_has_formateur', function (Blueprint $table) {
           $table->string('module_id');
           $table->enum("status",['continue','fenished'])->nullable();
            $table->foreign('module_id')
                ->references('id')
                ->on('modules')
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
        Schema::dropIfExists('module_has_formateur');
    }
};
