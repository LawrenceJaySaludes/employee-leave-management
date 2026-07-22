<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LeaveRequest;

class LeaveType extends Model
{
    protected $fillable = [

        'name',

        'description',

        'days_allowed',

        'is_paid',

        'status'

    ];

    public function leaveRequests()
{
    return $this->hasMany(LeaveRequest::class);
}

}