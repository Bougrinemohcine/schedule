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
        Schema::create('sissions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('day');
            $table->string('typeSalle')->nullable();
            $table->enum('day_part', ['Matin', 'Amidi']);
            $table->enum('dure_sission', ['SE1', 'SE2','SE3',"SE4"]);
            $table->string('module_id')->nullable();
            $table->foreign('module_id')
                ->references('id')
                ->on('modules')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('group_id')->nullable();
            $table->foreign('group_id')
                ->references('id')
                ->on('groups')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('establishment_id');
            $table->foreign('establishment_id')
                ->references('id')
                ->on('establishment')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('class_room_id')->nullable();
            $table->foreign('class_room_id')
                ->references('id')
                ->on('class_rooms')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->date('validate_date')->nullable();

            $table->unsignedBigInteger('main_emploi_id'); // Corrected column name
            $table->foreign('main_emploi_id')
                ->references('id')
                ->on('main_emploi')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('demand_emploi_id')->nullable();
            $table->foreign('demand_emploi_id')
                ->references('id')
                ->on('request_emplois')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('message')->nullable();
            $table->enum('sission_type', ['TEAMS', 'PRESENTIEL','EFM'])->nullable();
            $table->enum('status_sission', ["Pending", "Accepted", "Cancelled"])->default("Pending");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sissions');
    }
};
