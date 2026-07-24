<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LeaveType;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
       $totalEmployees = User::where('role', 'employee')->count();
       $totalLeaveTypes = LeaveType::count();
       $totalRequests = LeaveRequest::count();
       $pendingRequests = LeaveRequest::where(
    'status',
    'pending'
)->count();
$approvedRequests = LeaveRequest::where(
    'status',
    'approved'
)->count();

$rejectedRequests = LeaveRequest::where(
    'status',
    'rejected'
)->count();

$monthlyRequests = LeaveRequest::select(
        DB::raw('MONTH(created_at) as month'),
        DB::raw('COUNT(*) as total')
    )
    ->groupBy('month')
    ->orderBy('month')
    ->get();

    $mostUsedLeaveTypes = LeaveRequest::select(
        'leave_type_id',
        DB::raw('COUNT(*) as total')
    )
    ->with('leaveType')
    ->groupBy('leave_type_id')
    ->orderByDesc('total')
    ->get();

    $recentRequests = LeaveRequest::with([
        'user',
        'leaveType'
    ])
    ->latest()
    ->take(5)
    ->get();

return response()->json([

    'success' => true,

    'data' => [

        'total_employees' => $totalEmployees,

        'total_leave_types' => $totalLeaveTypes,

        'total_leave_requests' => $totalRequests,

        'pending_requests' => $pendingRequests,

        'approved_requests' => $approvedRequests,

        'rejected_requests' => $rejectedRequests,

        'monthly_requests' => $monthlyRequests,

        'most_used_leave_types' => $mostUsedLeaveTypes,
        
        'recent_requests' => $recentRequests
    ]

]);
    }

    public function employeeDashboard()
{
    $user = auth()->user();

    $monthlyRequests = LeaveRequest::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->where('user_id', $user->id)
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    $recentRequests = LeaveRequest::with('leaveType')
        ->where('user_id', $user->id)
        ->latest()
        ->take(5)
        ->get();

    return response()->json([

        'success' => true,

        'data' => [

            'total_requests' =>
                LeaveRequest::where('user_id', $user->id)->count(),

            'pending_requests' =>
                LeaveRequest::where('user_id', $user->id)
                    ->where('status', 'pending')
                    ->count(),

            'approved_requests' =>
                LeaveRequest::where('user_id', $user->id)
                    ->where('status', 'approved')
                    ->count(),

            'rejected_requests' =>
                LeaveRequest::where('user_id', $user->id)
                    ->where('status', 'rejected')
                    ->count(),

            'monthly_requests' => $monthlyRequests,

            'recent_requests' => $recentRequests

        ]

    ]);
}
}