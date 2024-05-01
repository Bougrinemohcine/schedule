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
       DB::unprepared("CREATE TRIGGER OVSERVESISSION
       AFTER INSERT ON sissions
       FOR EACH ROW
       BEGIN
           DECLARE num INT;
           SELECT COUNT(*) INTO num
           FROM sissions
           WHERE user_id IS NULL OR group_id IS NULL;

           IF num > 0 THEN
               DELETE FROM sissions
               WHERE user_id IS NULL OR group_id IS NULL;
               SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Should select group and formateur';
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
        Schema::unprepared('OVSERVESISSION');
    }
};
