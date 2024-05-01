<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class establishment extends Model
{
    protected $table ='establishment';
    public $timestamps = false;
    protected $fillable = [
        'name_establishment',
    ];
    use HasFactory;

}
