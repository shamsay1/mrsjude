<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
     <style>
        body{
            padding: 10px;
        }
     </style>
</head>
<body>
   <table class="table table-bordered table-sm">

    <thead>

        <tr>

            <th rowspan="2">S/N</th>
            <th rowspan="2">Student Name</th>

            <th colspan="10">CLASS WORK (10)</th>
            <th rowspan="2">AVG</th>

            <th colspan="5">HOME WORK (10)</th>
            <th rowspan="2">AVG</th>

            <th colspan="3">TOPIC TEST (20)</th>
            <th rowspan="2">AVG</th>

            <th rowspan="2">EXAM (60)</th>
            <th rowspan="2">TOTAL (100)</th>
            <th rowspan="2">GRADE</th>
            <th rowspan="2">POSITION</th>

        </tr>

        <tr>

            @for($i = 1; $i <= 10; $i++)
                <th>{{ $i }}</th>
            @endfor

            @for($i = 1; $i <= 5; $i++)
                <th>{{ $i }}</th>
            @endfor

            @for($i = 1; $i <= 3; $i++)
                <th>{{ $i }}</th>
            @endfor

        </tr>

    </thead>

    <tbody>

        @foreach($records as $record)

            @php

                // CLASSWORK (100 -> 10)
                $cwTotal =
                    ($record->classwork1 ?? 0) +
                    ($record->classwork2 ?? 0) +
                    ($record->classwork3 ?? 0) +
                    ($record->classwork4 ?? 0) +
                    ($record->classwork5 ?? 0) +
                    ($record->classwork6 ?? 0) +
                    ($record->classwork7 ?? 0) +
                    ($record->classwork8 ?? 0) +
                    ($record->classwork9 ?? 0) +
                    ($record->classwork10 ?? 0);

                $cwAverage = $cwTotal / 10;

                // HOMEWORK (50 -> 10)
                $hwTotal =
                    ($record->homework1 ?? 0) +
                    ($record->homework2 ?? 0) +
                    ($record->homework3 ?? 0) +
                    ($record->homework4 ?? 0) +
                    ($record->homework5 ?? 0);

                $hwAverage = $hwTotal / 5;

                // TOPIC TEST (30 -> 20)
                $ttTotal =
                    ($record->topictest1 ?? 0) +
                    ($record->topictest2 ?? 0) +
                    ($record->topictest3 ?? 0);

                $ttAverage = ($ttTotal / 30) * 20;

                // EXAM (60)
                $exam = $record->terminal_exam ?? 0;

                // TOTAL (100)
                $total =
                    $cwAverage +
                    $hwAverage +
                    $ttAverage +
                    $exam;

                // GRADE
                if ($total >= 81) {
                    $grade = 'A';
                } elseif ($total >= 61) {
                    $grade = 'B';
                } elseif ($total >= 41) {
                    $grade = 'C';
                } elseif ($total >= 21) {
                    $grade = 'D';
                } else {
                    $grade = 'F';
                }

            @endphp

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>
                    {{ $record->student->firstname }}
                    {{ $record->student->middlename }}
                    {{ $record->student->lastname }}
                </td>

                <td>{{ $record->classwork1 }}</td>
                <td>{{ $record->classwork2 }}</td>
                <td>{{ $record->classwork3 }}</td>
                <td>{{ $record->classwork4 }}</td>
                <td>{{ $record->classwork5 }}</td>
                <td>{{ $record->classwork6 }}</td>
                <td>{{ $record->classwork7 }}</td>
                <td>{{ $record->classwork8 }}</td>
                <td>{{ $record->classwork9 }}</td>
                <td>{{ $record->classwork10 }}</td>

                <td>{{ number_format($cwAverage, 1) }}</td>

                <td>{{ $record->homework1 }}</td>
                <td>{{ $record->homework2 }}</td>
                <td>{{ $record->homework3 }}</td>
                <td>{{ $record->homework4 }}</td>
                <td>{{ $record->homework5 }}</td>

                <td>{{ number_format($hwAverage, 1) }}</td>

                <td>{{ $record->topictest1 }}</td>
                <td>{{ $record->topictest2 }}</td>
                <td>{{ $record->topictest3 }}</td>

                <td>{{ number_format($ttAverage, 1) }}</td>

                <td>{{ $exam }}</td>

                <td>
                    <strong>{{ number_format($total, 1) }}</strong>
                </td>

                <td>
                    <span class="badge bg-primary">
                        {{ $grade }}
                    </span>
                </td>

                <td>--</td>

            </tr>

        @endforeach

    </tbody>

</table>
<button style="background-color: green;border: none;color: white;padding: 10px;border-radius: 3px">
     @if(Auth::user()->role =="teacher")
    <a href="/assessment" class="btn btn-success text-white" style="text-decoration: none;">
        Back
    </a>
    @else
    <a href="/showtl" class="btn btn-success text-white" style="text-decoration: none;">
        Back
    </a>
    @endif
</button>
</body>
</html>