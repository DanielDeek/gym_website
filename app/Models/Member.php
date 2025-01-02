<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{

    protected $fillable = ['user_id','name','email','phone','membership_id','start_date','end_date','status'];
    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    public function getStatusAttribute()
    {
        return Carbon::now()->lessThanOrEqualTo($this->end_date) ? 'active' : 'expired';
    }

    public function isMembershipActive()
    {
        return $this->status === 'active';
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
