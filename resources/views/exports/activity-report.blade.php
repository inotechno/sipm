<!-- resources/views/exports/activity-report.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Report Activities</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #f3f4f6;
            padding: 6px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
            border: 1px solid #ddd;
        }
        td {
            padding: 6px;
            border: 1px solid #ddd;
            font-size: 8px;
            vertical-align: top;
        }
        .report-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .timestamp {
            text-align: right;
            font-size: 8px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="report-title">Report Activities</div>

    <div class="timestamp">
        Generated: {{ $generated_at }}
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Scope</th>
                <th>Area</th>
                <th>Position</th>
                <th>Est. Time</th>
                <th>Quantity</th>
                <th>Forecast</th>
                <th>Plan</th>
                <th>Actual</th>
                <th>Progress</th>
                <th>Supervisor</th>
                <th>Dependencies</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activities as $activity)
                <tr>
                    <td>{{ $activity['id'] }}</td>
                    <td>{{ $activity['scope']['name'] ?? '-' }}</td>
                    <td>{{ $activity['area']['name'] ?? '-' }}</td>
                    <td>{{ $activity['position']['name'] ?? '-' }}</td>
                    <td>{{ $activity['total_estimate'] }} Day</td>
                    <td>{{ $activity['total_quantity'] ?? 0 }}</td>
                    <td>{{ $activity['forecast_date'] }}</td>
                    <td>{{ $activity['plan_date'] }}</td>
                    <td>{{ $activity['actual_date'] ?? '-' }}</td>
                    <td>
                        @if(!empty($activity['history_progress']))
                            @foreach($activity['history_progress'] as $history)
                               {{ $history['date'] }}: {{ $history['quantity'] }}<br>
                            @endforeach
                        @endif
                        Progress: {{ $activity['progress'] }} %
                    </td>
                    <td>{{ $activity['supervisor']['name'] ?? '-' }}</td>
                    <td>
                        @if(!empty($activity['issues']))
                            @foreach($activity['issues'] as $issue)
                                {{ $issue['category_dependency']['name'].': '.$issue['description'] ?? '-' }}@if(!$loop->last),@endif<br>
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $activity['status']['name'] ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
