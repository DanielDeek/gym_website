<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    protected $fillable = ['user_id','name', 'email','specialization', 'phone', 'bio','image'];

    public function classes()
    {
        return $this->hasMany(Classs::class);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}
}
