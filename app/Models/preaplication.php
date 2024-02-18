<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preaplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'russain_citizen',
        'permanent_resident',
        'location',
        'application_status'
    ];

    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
