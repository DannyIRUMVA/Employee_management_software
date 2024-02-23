<h1>Employee Report</h1>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Attendance Records</th>
        </tr>
    </thead>
    <tbody>
        @foreach($employees as $employee)
            <tr>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->email }}</td>
                <td>
                    <ul>
                        @foreach($employee->attendance as $record)
                            <li>Date: {{ $record['Date'] }}, Arrived at: {{ $record['Arrive at'] }}, Left at: {{ $record['Leave at'] }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
