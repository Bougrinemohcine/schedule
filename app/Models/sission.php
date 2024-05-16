<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\group;
use App\Models\class_room;

class sission extends Model
{
    use HasFactory;
    public $fillable = [
            'day',
            'day_part',
            'dure_sission',
            'module_id',
            'typeSalle',
            'group_id',
        	'establishment_id',
            'user_id',
            'class_room_id',
            'validate_date'	,
            'main_emploi_id',
            "demand_emploi_id",
            'message',
            'sission_type',
        	'status_sission',

    ];
    public function group()
    {
        return $this->belongsTo(group::class, 'group_id');
    }
    public function class_room()
    {
        return $this->belongsTo(class_room::class, 'class_room_id');
    }

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
