<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    public $table = 'usersetting';
    public $timestamps = false ;
    protected $primaryKey = 'userId';
    public $fillable = ['userId',	'module',
    	'typeSession'	,'typeSalle', 'group', 'typeSessionCase',
    'salle'	,'formateur', 'modeRamadan','branch'];
}
