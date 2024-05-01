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
        Schema::table('groups' , function (Blueprint $table){
            $table->string('barnch_id')->nullable() ;
            $table->foreign('barnch_id')
            ->references('id')
            ->on('branches')
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
        Schema::table('branches', function (Blueprint $table) {
            // Drop the new column if needed
            $table->dropColumn('barnch_id');
        });
    }
};
