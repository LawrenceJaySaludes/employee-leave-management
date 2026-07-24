<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LeaveType;
use App\Http\Resources\LeaveTypeResource;
use App\Http\Requests\StoreLeaveTypeRequest;
use App\Http\Requests\UpdateLeaveTypeRequest;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function index(Request $request)
{
    $query = LeaveType::query();

    // Search
    if ($request->filled('search')) {

        $query->where(function ($q) use ($request) {

            $q->where('name', 'LIKE', "%{$request->search}%")
              ->orWhere('description', 'LIKE', "%{$request->search}%");

        });

    }

    // Filter by status
    if ($request->filled('status')) {

        $query->where('status', $request->status);

    }

    // Sorting
    if ($request->sort == 'oldest') {

        $query->oldest();

    } else {

        $query->latest();

    }

    $leaveTypes = $query->paginate(10);

    return response()->json([

        'success' => true,

        'message' => 'Leave types retrieved successfully.',

        'data' => LeaveTypeResource::collection($leaveTypes),

        'pagination' => [

            'current_page' => $leaveTypes->currentPage(),

            'last_page' => $leaveTypes->lastPage(),

            'per_page' => $leaveTypes->perPage(),

            'total' => $leaveTypes->total()

        ]

    ]);
}

    /**
     * Store a newly created resource in storage.
     */
   public function store(StoreLeaveTypeRequest $request)
{
    $leaveType = LeaveType::create($request->validated());

    return response()->json([
        'success' => true,
        'message' => 'Leave type created successfully.',
        'data' => new LeaveTypeResource($leaveType)
    ], 201);
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    $leaveType = LeaveType::findOrFail($id);

    return response()->json([
        'success' => true,
        'data' => new LeaveTypeResource($leaveType)
    ]);
}

    /**
     * Update the specified resource in storage.
     */
public function update(UpdateLeaveTypeRequest $request, string $id)
{
    $leaveType = LeaveType::findOrFail($id);

    $leaveType->update($request->validated());

    return response()->json([
        'success' => true,
        'message' => 'Leave type updated successfully.',
        'data' => new LeaveTypeResource($leaveType)
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
  public function destroy(string $id)
{
    $leaveType = LeaveType::findOrFail($id);

    $leaveType->delete();

    return response()->json([
        'success' => true,
        'message' => 'Leave type deleted successfully.'
    ]);
}
}
