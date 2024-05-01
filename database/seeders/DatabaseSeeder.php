<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\module::factory(100)->create();
        \App\Models\group::factory(100)->create();
        \App\Models\class_room::factory(100)->create();
        \App\Models\class_has_type::factory(100)->create();
        \App\Models\class_room_type::factory(100)->create();
        \App\Models\formateur_has_group::factory(100)->create();
        \App\Models\formateur::factory(100)->create();
        \App\Models\main_emploi::factory(100)->create();
        \App\Models\sission::factory(100)->create();
        

    }
}
