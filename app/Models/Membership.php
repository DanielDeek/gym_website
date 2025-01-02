<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = ['type', 'price', 'duration', 'benefits'];
    public function members()
    {
        return $this->hasMany(Member::class);
    }
}
