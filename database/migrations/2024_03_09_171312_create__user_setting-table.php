<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userSetting', function (Blueprint $table) {
            $table->string('userId')->primary();
            $table->foreign('userId')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
               ->onUpdate('cascade');
            $table->boolean('module')->default(false);
            $table->boolean('typeSession')->default(false);
            $table->boolean('typeSalle')->default(false);
            $table->boolean('salle')->default(false);
            $table->boolean('formateur')->default(false);
            $table->boolean('branch')->default(false);
            $table->boolean('year')->default(false);
            $table->boolean('modeRamadan')->default(false);
            $table->boolean('group')->default(false);
            $table->boolean('typeSessionCase')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userSetting');
    }
}
