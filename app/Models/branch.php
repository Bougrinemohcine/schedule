<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class branch extends Model
{
    use HasFactory;
    public $table = 'branches';
    protected $primaryKey = 'id';

    public $timestamps = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'name',
        'establishment_id'

    ];
}
