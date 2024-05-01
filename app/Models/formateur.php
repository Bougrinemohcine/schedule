<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\formateur_has_branche;
use App\Models\formateur_has_group;
use App\Models\module_has_formateur;

use App\Models\Branch;
use App\Models\group;
use App\Models\Module;
class formateur extends Model
{
    public $table = 'users' ;
    public $timestamps = false ;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    public $fillable =[
        'id',
        'email',
        'password',
        'role',
        'status',
        'user_name',
        'establishment_id',
        'passwordClone',
    ];

    public function branches()
    {
        return $this->belongsToMany(branch::class ,"formateur_has_filier" , 'formateur_id' , 'barnch_id');
    }

    public function groupes()
    {
        return $this->belongsToMany(group::class , "formateur_has_groups", 'formateur_id' , 'group_id');
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class ,"module_has_formateur" ,"formateur_id" ,"module_id");
    }
    use HasFactory;
}
