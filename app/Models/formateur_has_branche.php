<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class formateur_has_branche extends Model
{
    use HasFactory;
    public $table = 'formateur_has_filier';
    public $timestamps = false ;

    public $fillable =['formateur_id' , 'barnch_id'];

}
