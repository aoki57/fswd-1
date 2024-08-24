<?php

namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'is_admin']);
    }

    public function index()
    {
        $employees = Employee::with(['leaveBalances', 'leaves'])->get();

        return EmployeeResource::collection($employees);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_number'  => 'nullable|min:7|max:7',
            'name'  => 'required|max:255',
            'address'  => 'required',
            'birth_date'  => 'required|date',
            'join_date'  => 'required|date'
        ]);

        try {

            $yearJoin = date('y', strtotime($validated['join_date']));

            if (empty($validated['employee_number'])) {

                $createEmployeeNumber = Employee::createEmployeeNumber($yearJoin);
                $validated['employee_number'] = $createEmployeeNumber;
            } else {

                $codeNumber = Employee::codeNumber();
                $codeNumberRequest = substr($validated['employee_number'], 0, 2);

                if ($codeNumberRequest != $codeNumber) {
                    return response()->json(['error' => 'Code Employee Wrong'], 400);
                }
            }

            $newEmployee = Employee::create($validated);
            return new EmployeeResource($newEmployee->loadMissing(['leaveBalances', 'leaves']));
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(Employee $employee)
    {
        $employee->loadMissing(['leaveBalances', 'leaves']);

        return new EmployeeResource($employee);
    }

    public function edit(Employee $employee)
    {
        //
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'employee_number'  => 'nullable|min:7|max:7',
            'name'  => 'required|max:255',
            'address'  => 'required',
            'birth_date'  => 'required|date',
            'join_date'  => 'required|date'
        ]);

        try {

            $employee->update($validated);
            return new EmployeeResource($employee->loadMissing(['leaveBalances', 'leaves']));
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Employee $employee)
    {
        try {

            $employee->delete();

            return new EmployeeResource($employee->loadMissing(['leaveBalances', 'leaves']));
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function newEmployees()
    {
        $employees = Employee::with(['leaveBalances', 'leaves'])->orderBy('join_date', 'desc')->take(3)->get();

        return EmployeeResource::collection($employees);
    }
}
