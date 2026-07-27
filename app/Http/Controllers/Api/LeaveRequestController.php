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
    public function index(Request $request)
{
    $leaveRequests = $request->user()
        ->leaveRequests()
        ->with('leaveType')
        ->latest()
        ->get();

    return response()->json([
        'success' => true,
        'data' => LeaveRequestResource::collection($leaveRequests)
    ]);
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
   public function show(LeaveRequest $id)
{
    if ($id->user_id != auth()->id()) {
        return response()->json([
            'message' => 'Unauthorized'
        ],403);
    }

    return new LeaveRequestResource($id);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function approve($id)
{
    $leave = LeaveRequest::findOrFail($id);

    if ($leave->status != 'pending') {
        return response()->json([
            'message' => 'This request was already processed.'
        ], 400);
    }

    $leave->update([
        'status' => 'approved',
        'approved_by' => auth()->id(),
        'approved_at' => Carbon::now(),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Leave approved successfully.',
        'data' => new LeaveRequestResource($leave)
    ]);
}

public function reject(Request $request, $id)
{
    $leave = LeaveRequest::findOrFail($id);

    if ($leave->status != 'pending') {
        return response()->json([
            'message' => 'This request was already processed.'
        ], 400);
    }

    $leave->update([
        'status' => 'rejected',
        'approved_by' => auth()->id(),
        'approved_at' => Carbon::now(),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Leave rejected successfully.',
        'data' => new LeaveRequestResource($leave)
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
  public function destroy(LeaveRequest $id)
{
    if ($id->status != 'pending') {

        return response()->json([
            'message'=>'Cannot cancel this request.'
        ],422);
    }

    $id->delete();

    return response()->json([
        'message'=>'Leave request cancelled.'
    ]);
}

public function adminIndex(Request $request)
{
    $query = LeaveRequest::with([
        'user',
        'leaveType',
        'approver'
    ]);

    // Search employee name
    if ($request->filled('search')) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where(function ($query) use ($request) {

    $query->where('name', 'LIKE', '%' . $request->search . '%')
          ->orWhere('email', 'LIKE', '%' . $request->search . '%');

});
        });
    }

    // Filter by status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Filter by leave type
    if ($request->filled('leave_type')) {
        $query->where('leave_type_id', $request->leave_type);
    }

    // Filter by department
    if ($request->filled('department')) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('department', $request->department);
        });
    }

    // Filter by date range
    if ($request->filled('from')) {
        $query->whereDate('start_date', '>=', $request->from);
    }

    if ($request->filled('to')) {
        $query->whereDate('end_date', '<=', $request->to);
    }

    // Sort
    if ($request->sort === 'oldest') {
        $query->oldest();
    } else {
        $query->latest();
    }

    // Pagination
    $leaveRequests = $query->paginate(10);

    return response()->json([
        'success' => true,
        'message' => 'Leave requests retrieved successfully.',
        'data' => LeaveRequestResource::collection($leaveRequests),
        'pagination' => [
            'current_page' => $leaveRequests->currentPage(),
            'last_page' => $leaveRequests->lastPage(),
            'per_page' => $leaveRequests->perPage(),
            'total' => $leaveRequests->total(),
        ]
    ]);
}

public function myLeaves()
{
    $leaves = LeaveRequest::with('leaveType')
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

    return response()->json([
        'success' => true,
        'data' => LeaveRequestResource::collection($leaves)
    ]);
}

}
