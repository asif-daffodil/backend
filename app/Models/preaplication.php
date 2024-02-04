<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class preaplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'russain_citizen',
        'permanent_resident',
        'location',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
