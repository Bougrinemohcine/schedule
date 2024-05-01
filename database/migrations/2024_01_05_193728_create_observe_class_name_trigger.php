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
       DB::unprepared("
CREATE TRIGGER observeClassName
BEFORE INSERT ON class_rooms
FOR EACH ROW
BEGIN
    DECLARE existingCount INT;

    SELECT COUNT(*)
    INTO existingCount
    FROM class_rooms
    WHERE class_name = NEW.class_name AND id_establishment = NEW.id_establishment;

    IF existingCount > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'You had inserted this name before';
    END IF;
END;


");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS observeClassName');
    }
};
