<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::latest()->get();

        if ($employees->isEmpty()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No employee found!',
            ], 200);
        }

        foreach ($employees as $employee) {
            $attendanceRecords = Attendance::where('employee_id', $employee->id)
                ->whereNotNull('check_in_time')
                ->whereNotNull('check_out_time')
                ->get(['check_in_time', 'check_out_time']);

            $formattedAttendance = [];

            foreach ($attendanceRecords as $attendance) {
                $formattedAttendance[] = [
                    'Date' => date('Y-m-d', strtotime($attendance->check_in_time)),
                    'Arrive at' => date('H:i:s', strtotime($attendance->check_in_time)),
                    'Leave at' => date('H:i:s', strtotime($attendance->check_out_time)),
                ];
            }

            $employee->attendance = $formattedAttendance;
            $employee->makeHidden(['created_at', 'updated_at']);
        }

        $response = [
            'status' => 'success',
            'message' => 'Employees are retrieved successfully with attendance records.',
            'data' => $employees,
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'names' => 'required|string|max:250',
            'email' => 'required|string',
            'employeeIdentifier' => 'required|string|max:10',
            'phoneNumber' => 'required|string|max:15',
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }

        $employees = Employee::create($request->all());

        $response = [
            'status' => 'success',
            'message' => 'Employee is added successfully.',
            'data' => $employees,
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $employees = Employee::find($id);

        if(is_null($employees)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Employee is not found!',
            ], 200);
        }

        $response = [
            'status' => 'success',
            'message' => 'Employee is retrieved successfully.',
            'data' => $employees,
        ];

        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'names' => 'required|string|max:250',
            'emails' => 'required|string',
            'employeeIdentifier' => 'required|string|max:10',
            'phoneNumber' => 'required|string|max:15',
        ]);

        if($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Employee is not found!',
            ], 403);
        }

        $employees = Employee::find($id);

        if (is_null($employees)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Employee is not found!',
            ], 200);
        }

        $employees ->update($request->all());

        $response = [
            'status' => 'success',
            'message'=> 'Employee is updated successfully.',
            'data' => $employees,
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employees = Employee::find($id);

        if (is_null($employees)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Employee is not found!',
            ], 200);
        }

        Employee::destroy($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Employee is deleted successfully.',
        ], 200);
    }

    public function search($name) {
        $employees = Employee::where('names', 'like', '%'.$name.'%')->latest()->get();

        if (is_null($employees->first())) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No Employee found!',
            ], 200);
        }

        $response = [
            'status' => 'success',
            'message' => 'Employee are retrieved successfully',
            'data' =>$employees,
        ];

        return response()->json($response, 200);
    }
}
