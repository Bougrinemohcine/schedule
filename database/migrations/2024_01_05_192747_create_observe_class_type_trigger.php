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
        DB::unprepared(
            "

            CREATE TRIGGER observeClassType
            BEFORE INSERT ON class_room_types
            FOR EACH ROW
            BEGIN
                DECLARE cnt INT;
                SELECT COUNT(*)
                INTO cnt
                FROM class_room_types
                WHERE class_room_types = NEW.class_room_types AND establishment_id = NEW.establishment_id;

                IF cnt > 0 THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'you had inserted the type  before';
                END IF;
            END;


            "
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS observeClassType');
    }
};
