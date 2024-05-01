<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestEmploi extends Model
{
    protected $fillable = [
        'date_request',
        'comment',
        'user_id',
        'main_emploi_id'
    ];
    use HasFactory;

    // Define the relationship with the User model
    public function formateur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function mainEmploi()
    {
        return $this->belongsTo(main_emploi::class, 'main_emploi_id');
    }
}
