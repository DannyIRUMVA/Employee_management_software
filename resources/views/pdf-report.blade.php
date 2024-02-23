<!DOCTYPE html>
<html>
<head>
    <title>Employee Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Employee Report</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Attendance</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
            <tr>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->email }}</td>
                <td>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Arrive at</th>
                                <th>Leave at</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employee->attendance as $attendance)
                            <tr>
                                <td>{{ $attendance['Date'] }}</td>
                                <td>{{ $attendance['Arrive at'] }}</td>
                                <td>{{ $attendance['Leave at'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
