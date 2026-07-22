<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\LeaveType;

class LeaveRequest extends Model
{
    protected $fillable = [

        'user_id',

        'leave_type_id',

        'start_date',

        'end_date',

        'total_days',

        'reason',

        'status',

        'approved_by',

        'approved_at'

    ];

    public function user()
{
    return $this->belongsTo(User::class);
}

public function leaveType()
{
    return $this->belongsTo(LeaveType::class);
}

public function approver()
{
    return $this->belongsTo(User::class, 'approved_by');
}

}