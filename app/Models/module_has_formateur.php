<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class module_has_formateur extends Model
{
    use HasFactory;

    public $table = 'module_has_formateur' ;
    public $timestamps = false ;
    public $fillable =[
        'establishment_id',
        'module_id',
        'status',
        'formateur_id'
    ];
}
