<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploiStrictureModel extends Model
{
    use HasFactory;
   public $table = 'emplistracture';
   public $timestamps = false;
   protected $primaryKey = 'user_id';
   protected $fillable = [
    'toueGroupe',
    'toutFormateur',
    'formateur',
    'groupe',
    'user_id'
   ];

}
