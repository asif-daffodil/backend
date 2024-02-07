<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class application extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicationType',
        'highSchool',
        'russain_citizen',
        'permanent_resident',
        'user_id',
        'ssc',
        'hsc',
        'passport',
        'photo',
    ];

    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
