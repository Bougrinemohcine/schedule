<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class group_has_module extends Model
{
    use HasFactory;
    public $table = 'groupe_has_modules';
    public $timestamps = false ;
    public $fillable = [
        'module_id',
        'group_id'

    ];
}
