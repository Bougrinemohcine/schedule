<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER observeModels
                       BEFORE INSERT ON modules
                       FOR EACH ROW
                       BEGIN
                       DECLARE modulesCount INT ;

                       SELECT COUNT(*) INTO modulesCount
                       FROM modules
                       WHERE id =NEW.id AND	establishment_id = NEW.establishment_id ;
                       IF modulesCount> 0 THEN
                       SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT ='thes model has already been inserted';
                       END IF ;
                       END ;
                       ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       DB::unprepared('DROP TRIGGER IF EXISTS observeModels');
    }
};
