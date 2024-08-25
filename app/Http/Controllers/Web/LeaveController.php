<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\LeaveBalance;
use Illuminate\Http\Request;

class LeaveController extends Controller
{

    public function index()
    {
        $leaves = Leave::with('employee')->paginate(5);
        return view('leaves.index', compact('leaves'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('leaves.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_date' => 'required|date',
            'leave_duration' => 'required',
            'leave_information' => 'required'
        ]);

        try {

            $leave = Leave::create($validated);

            $year = date('Y', strtotime($leave->leave_date));

            $leaveBalance = LeaveBalance::firstOrCreate(
                [
                    'employee_id' => $leave->employee_id,
                    'year' => $year,
                ],
                [
                    'leave_quota' => 12,
                    'leave_taken' => 0
                ]
            );

            $leaveBalance->leave_taken += $leave->leave_duration;
            $leaveBalance->leave_quota -= $leave->leave_duration;
            $leaveBalance->save();

            toastr()->success('Data has been saved successfully!');
            return redirect()->route('leaves.index');
        } catch (\Exception $e) {
            toastr()->success('Error: ' . $e->getMessage());
            return redirect()->route('leaves.index');
        }
    }

    public function show(Leave $leave)
    {
        //
    }

    public function edit($id)
    {
        $leave = Leave::findOrFail($id);
        $employees = Employee::all();
        return view('leaves.edit', compact('employees', 'leave'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_date' => 'required|date',
            'leave_duration' => 'required',
            'leave_information' => 'required'
        ]);

        try {

            $leave = Leave::findOrFail($id);

            $oldYear = date('Y', strtotime($leave->leave_date));
            $newYear = date('Y', strtotime($validated['leave_date']));

            if ($oldYear != $newYear) {

                $oldLeaveBalance = LeaveBalance::where('employee_id', $leave->employee_id)
                    ->where('year', $oldYear)
                    ->first();


                if ($oldLeaveBalance) {
                    $oldLeaveBalance->leave_quota += $validated['leave_duration'];
                    $oldLeaveBalance->leave_taken -= $validated['leave_duration'];
                    $oldLeaveBalance->save();
                }

                $newLeaveBalance = LeaveBalance::firstOrCreate(
                    [
                        'employee_id' => $leave->employee_id,
                        'year' => $newYear,
                    ],
                    [
                        'leave_quota' => 12,
                        'leave_taken' => 0
                    ],
                );

                $newLeaveBalance->leave_taken += $validated['leave_duration'];
                $newLeaveBalance->leave_quota -= $validated['leave_duration'];
                $newLeaveBalance->save();
            } else {

                $leaveBalance = LeaveBalance::where('employee_id', $leave->employee_id)
                    ->where('year', $newYear)
                    ->first();

                $leaveBalance->leave_taken += $validated['leave_duration'];
                $leaveBalance->leave_quota -= $validated['leave_duration'];
                $leaveBalance->save();
            }

            $leave->update($validated);

            toastr()->success('Data has been updated successfully!');
            return redirect()->route('leaves.index');
        } catch (\Exception $e) {
            toastr()->success('Error: ' . $e->getMessage());
            return redirect()->route('leaves.index');
        }
    }

    public function destroy($id)
    {
        try {

            $leave = Leave::findOrFail($id);
            $leaveBalance = LeaveBalance::where('employee_id', $leave->employee_id)
                ->where('year', date('Y', strtotime($leave->leave_date)))
                ->first();

            $leaveBalance->update([
                'leave_quota' => $leaveBalance->leave_quota + $leave->leave_duration,
                'leave_taken' => $leaveBalance->leave_taken - $leave->leave_duration
            ]);

            $leave->delete();

            toastr()->success('Data has been deleted successfully!');
            return redirect()->route('leaves.index');
        } catch (\Exception $e) {
            toastr()->success('Error: ' . $e->getMessage());
            return redirect()->route('leaves.index');
        }
    }

    public function leaveBalances()
    {
        $employees = Employee::paginate(10);

        return view('leaves.leaveBalances', compact('employees'));
    }
}
