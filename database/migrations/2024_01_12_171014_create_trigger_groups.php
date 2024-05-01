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
        DB::unprepared("CREATE TRIGGER observegroup
        BEFORE INSERT ON groups
        FOR EACH ROW
        BEGIN
            DECLARE groupsCount INT;
            SELECT COUNT(*) INTO groupsCount
            FROM groups
            WHERE group_name = NEW.group_name AND establishment_id = NEW.establishment_id;
            IF groupsCount > 0 THEN
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'This group has already been inserted';
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
       DB::unprepared('DROP TRIGGER IF EXISTS ovservegroup');
    }
};
