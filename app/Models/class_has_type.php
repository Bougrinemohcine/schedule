<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\class_room;


class class_has_type extends Model
{
    protected $table = 'classes_has_types';
    protected $fillable = [
        'class_rooms_id',
        "establishment_id",
        'class_room_types_id'
    ];
    public $timestamps = false;

    // public function classRoomType()
    // {
    //     return $this->belongsTo(class_room_type::class, 'class_room_types_id');
    // }

    // public function classRoom()
    // {
    //     return $this->belongsTo(class_room::class, 'class_rooms_id');
    // }
    use HasFactory;
}
