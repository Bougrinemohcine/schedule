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
        CREATE TRIGGER observeFormateurName
        BEFORE INSERT ON users
        FOR EACH ROW
        BEGIN
            DECLARE formateurName INT;

            SELECT COUNT(*)
            INTO formateurName
            FROM users
            WHERE user_name = NEW.user_name AND establishment_id  = NEW.establishment_id  AND role = 'formateur';
            IF formateurName > 0 THEN
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'This formateur has already been inserted';
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
        DB::unprepared('DROP TRIGGER IF EXISTS observeFormateurName');
    }
};
