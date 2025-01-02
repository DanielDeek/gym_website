<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberClass extends Model
{

    protected $table = 'member_class';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'class_id'
    ];

    public function class()
    {
        return $this->belongsTo(Classs::class, 'class_id');
    }
}
