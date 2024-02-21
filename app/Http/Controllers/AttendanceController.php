<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($employeeId)
    {
        $attendances = Attendance::where('employee_id', $employeeId)
            ->latest()
            ->get();

        if ($attendances->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No attendance records found for employee with ID ' . $employeeId,
            ], 404);
        }

        $response = [
            'status' => 'success',
            'message' => 'Attendance records retrieved successfully for employee with ID ' . $employeeId,
            'data' => $attendances,
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }

    public function checkIn(Request $request, $employeeId)
    {
        $attendance = new Attendance();
        $attendance->employee_id = $employeeId;
        $attendance->check_in_time = now();
        $attendance->save();

        return response()->json(['message' => 'Check-in successful'], 200);
    }

    public function checkOut(Request $request, $employeeId)
    {
        $attendance = Attendance::where('employee_id', $employeeId)
            ->whereNull('check_out_time')
            ->latest()
            ->first();

        if (!$attendance) {
            return response()->json(['error' => 'No check-in record found'], 400);
        }

        $attendance->check_out_time = now();
        $attendance->save();

        return response()->json(['message' => 'Check-out successful'], 200);
    }
}
