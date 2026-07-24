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

        $query->where(function ($q) use ($request) {

            $q->where('name', 'LIKE', '%' . $request->search . '%')
              ->orWhere('email', 'LIKE', '%' . $request->search . '%')
              ->orWhere('department', 'LIKE', '%' . $request->search . '%');

        });

    }

    // Sorting
    if ($request->sort == 'oldest') {

        $query->oldest();

    } else {

        $query->latest();

    }

    $employees = $query->paginate(10);

    return response()->json([

        'success' => true,

        'message' => 'Employees retrieved successfully.',

        'data' => $employees->items(),

        'pagination' => [

            'current_page' => $employees->currentPage(),

            'last_page' => $employees->lastPage(),

            'per_page' => $employees->perPage(),

            'total' => $employees->total()

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
