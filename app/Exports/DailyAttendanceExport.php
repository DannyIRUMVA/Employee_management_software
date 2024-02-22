<?php

namespace App\Exports;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DailyAttendanceExport implements FromCollection, WithHeadings
{
    protected $employees;
    protected $currentDate;

    public function __construct($employees, $currentDate)
    {
        $this->employees = $employees;
        $this->currentDate = $currentDate;
    }

    public function collection()
    {
        $data = [];

        foreach ($this->employees as $employee) {
            foreach ($employee->attendance as $attendance) {
                $attendanceDate = Carbon::parse($attendance->check_in_time)->toDateString();

                // Check if attendance date matches the current date
                if ($attendanceDate === $this->currentDate) {
                    $checkInTime = Carbon::parse($attendance->check_in_time)->format('H:i:s');
                    $checkOutTime = Carbon::parse($attendance->check_out_time)->format('H:i:s');

                    $data[] = [
                        'Names' => $employee->names,
                        'Email' => $employee->email,
                        'Date' => $attendanceDate,
                        'Arrive at' => $checkInTime,
                        'Leave at' => $checkOutTime,
                ];
                }
            }
        }

        return new Collection($data);
    }


    public function headings(): array
    {
        return [
            'Names',
            'Email',
            'Date',
            'Arrive at',
            'Leave at',
        ];
    }
}
