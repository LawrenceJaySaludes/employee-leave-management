<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LeaveRequestResource extends JsonResource
{
    public function toArray($request): array
    {
        return [

            'id' => $this->id,

            'employee' => $this->user?->name,

            'leave_type' => $this->leaveType?->name,

            'start_date' => $this->start_date,

            'end_date' => $this->end_date,

            'total_days' => $this->total_days,

            'reason' => $this->reason,

            'status' => $this->status,

            'approved_by' => $this->approver?->name,

            'approved_at' => $this->approved_at,

            'created_at' => $this->created_at,

        ];
    }
}