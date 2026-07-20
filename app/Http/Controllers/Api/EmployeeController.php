<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\EmployeeResource;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

public function index(Request $request)
{
    $query = User::where('role', 'employee');

    // Search
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%");
        });
    }

    // Filter by department
    if ($request->filled('department')) {
        $query->where('department', $request->department);
    }

    // Sorting
    $allowedSorts = ['name', 'email', 'department', 'created_at'];

    $sort = $request->get('sort', 'created_at');
    $direction = strtolower($request->get('direction', 'desc'));

    if (!in_array($sort, $allowedSorts)) {
        $sort = 'created_at';
    }

    if (!in_array($direction, ['asc', 'desc'])) {
        $direction = 'desc';
    }

    $query->orderBy($sort, $direction);

    $employees = $query->paginate(10)->withQueryString();

    return response()->json([
        'success' => true,
        'message' => 'Employees retrieved successfully.',
        'data' => EmployeeResource::collection($employees),


        'pagination' => [
            'current_page' => $employees->currentPage(),
            'last_page' => $employees->lastPage(),
            'per_page' => $employees->perPage(),
            'total' => $employees->total(),
        ],

        'filters' => [
    'search' => $request->search,
    'department' => $request->department,
    'sort' => $sort,
    'direction' => $direction,
]
        
    ]);
}

    /**
     * Store a newly created resource in storage.
     */
  public function store(StoreEmployeeRequest $request)
{
    $employee = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'department' => $request->department,
        'role' => 'employee',
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Employee created successfully.',
        'data' => new EmployeeResource($employee)
    ], 201);
}

    /**
     * Display the specified resource.
     */
   public function show(string $id)
{
    $employee = User::where('role', 'employee')->find($id);

    if (!$employee) {
        return response()->json([
            'success' => false,
            'message' => 'Employee not found.'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => new EmployeeResource($employee)
    ], 200);
}

    /**
     * Update the specified resource in storage.
     */
public function update(UpdateEmployeeRequest $request, string $id)
{
    $employee = User::where('role', 'employee')->find($id);

    if (!$employee) {
        return response()->json([
            'success' => false,
            'message' => 'Employee not found.'
        ], 404);
    }

    $employee->update($request->validated());

    return response()->json([
        'success' => true,
        'message' => 'Employee updated successfully.',
        'data' => new EmployeeResource($employee)
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
{
    $employee = User::where('role', 'employee')->find($id);

    if (!$employee) {
        return response()->json([
            'success' => false,
            'message' => 'Employee not found.'
        ], 404);
    }

    $employee->delete();

    return response()->json([
        'success' => true,
        'message' => 'Employee deleted successfully.'
    ]);
}
}
