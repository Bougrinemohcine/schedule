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
        Schema::table('request_emplois', function(Blueprint $table){
            $table->unsignedBigInteger('main_emploi_id');
            $table->foreign('main_emploi_id')
                ->references('id')
                ->on('main_emploi')
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
            Schema::table('request_emplois', function (Blueprint $table) {
                // Drop the new column if needed
                $table->dropColumn('main_emploi_id');
            });
        }

};
