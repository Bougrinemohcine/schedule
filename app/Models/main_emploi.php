<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class main_emploi extends Model
{
    use HasFactory;
    public $table = 'main_emploi' ;
    // public $timestamps = false ;
    public $fillable = [

        'datestart',
        'dateend',
        'establishment_id',
    ];
}
