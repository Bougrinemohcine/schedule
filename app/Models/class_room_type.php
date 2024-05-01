<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class class_room_type extends Model
{
    protected $table = 'class_room_types';
    protected $fillable  = [
        'class_room_types',
        'establishment_id'
    ];
    public $timestamps = false;
    public function classHasTypes()
    {
        return $this->hasMany(ClassHasType::class, 'class_room_types_id');
    }

    use HasFactory;
}
