<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::paginate(5);
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
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

            Employee::create($validated);
            return redirect()->route('employees.index');
        } catch (\Exception $e) {
            return redirect()->route('employees.index');
        }
    }

    public function show(Employee $employee)
    {
        $employee;
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $employee;
        return view('employees.edit', compact('employee'));
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
            return redirect()->route('employees.index');
        } catch (\Exception $e) {
            return redirect()->route('employees.index');
        }
    }

    public function destroy(Employee $employee)
    {
        try {
            $employee->delete();
            return redirect()->route('employees.index');
        } catch (\Exception $e) {
            return redirect()->route('employees.index');
        }
    }

    public function newEmployees()
    {
        $employees = Employee::orderBy('join_date', 'desc')->take(3)->get();

        return view('employees.newEmployees', compact('employees'));
    }
}
