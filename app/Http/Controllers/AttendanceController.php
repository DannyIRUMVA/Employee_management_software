<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Jobs\SendDepartureNotificationEmail;
use App\Jobs\SendCheckInNotificationEmail;



class AttendanceController extends Controller
{
    //Display a listing of the resource.

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

    //recording arriving time

    public function checkIn(Request $request, $employeeId)
    {
        $attendance = new Attendance();
        $attendance->employee_id = $employeeId;
        $attendance->check_in_time = now();
        $attendance->save();

        SendCheckInNotificationEmail::dispatch($attendance->employee->email, $attendance->check_in_time);

        return response()->json(['message' => 'Check-in successful'], 200);
    }

    // recording leaving time

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

        SendDepartureNotificationEmail::dispatch($attendance->employee->email, $attendance->check_out_time);

        return response()->json(['message' => 'Check-out successful'], 200);
    }

}
