<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class group extends Model
{
    use HasFactory;
    protected $table = 'groups'  ;
    protected $primaryKey = 'id' ;
    public $incrementing = false ;
    protected $keyType = 'string';
    public $timestamps = false   ;
    protected $fillable = ['id', 'group_name', 'establishment_id', 'year', 'barnch_id'];

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'groupe_has_modules', 'group_id', 'module_id');
    }

    public function branche(){
        return $this->belongsTo(branch::class);
    }


}

