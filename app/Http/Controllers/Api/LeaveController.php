<?php

namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller;
use App\Http\Resources\LeaveBalanceResource;
use App\Http\Resources\LeaveResource;
use App\Models\Leave;
use App\Models\LeaveBalance;
use Illuminate\Http\Request;

class LeaveController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'is_admin']);
    }

    public function index()
    {
        $leaves = Leave::with('employee.leaveBalances')->get();

        return LeaveResource::collection($leaves);
    }

    public function create()
    {
        //
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

            return new LeaveResource($leave->loadMissing('employee.leaveBalances'));
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $leave = Leave::findOrFail($id);

        return new LeaveResource($leave->loadMissing('employee.leaveBalances'));
    }

    public function edit(Leave $leave)
    {
        //
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

            return new LeaveResource($leave->loadMissing('employee.leaveBalances'));
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], 500);
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

            return new LeaveResource($leave->loadMissing('employee.leaveBalances'));
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function leaveBalances()
    {
        $leaveBalances = LeaveBalance::with('employee')->get();

        return LeaveBalanceResource::collection($leaveBalances);
    }
}
