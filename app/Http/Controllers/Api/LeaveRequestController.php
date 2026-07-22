<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use App\Http\Requests\StoreLeaveRequest;
use App\Http\Requests\UpdateLeaveRequest;
use App\Http\Resources\LeaveRequestResource;
use Carbon\Carbon;

class LeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(StoreLeaveRequest $request)
{
    $start = Carbon::parse($request->start_date);
    $end = Carbon::parse($request->end_date);

    $totalDays = $start->diffInDays($end) + 1;

    $leaveRequest = LeaveRequest::create([

        'user_id' => auth()->id(),

        'leave_type_id' => $request->leave_type_id,

        'start_date' => $request->start_date,

        'end_date' => $request->end_date,

        'total_days' => $totalDays,

        'reason' => $request->reason,

        'status' => 'pending'

    ]);

    return response()->json([

        'success' => true,

        'message' => 'Leave request submitted successfully.',

        'data' => new LeaveRequestResource($leaveRequest)

    ],201);
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
