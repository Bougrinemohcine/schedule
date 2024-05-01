<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class formateur_has_group extends Model
{
    use HasFactory;

    public $table = 'formateur_has_groups' ;
    public $timestamps = false ;
    public $fillable =[
        'establishment_id',
        'group_id',
        'formateur_id'
    ];
}
