<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classs extends Model
{
    protected $table = 'classes';
    protected $fillable = [
        'class_name',
        'description',
        'trainer_id',
        'start_time',
        'end_time',
        'day_of_week',
        'price',
        'image'
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id');
    }
}
