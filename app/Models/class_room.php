<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class class_room extends Model
{
    protected $teble = 'class_rooms';
    protected $fillable = [
        'class_name',
        'class_room_type',
        'id_establishment'
    ];
    public $timestamps = false;

    // public function classHasTypes()
    // {
    //     return $this->hasMany(ClassHasType::class, 'class_rooms_id');
    // }
    use HasFactory;
}
