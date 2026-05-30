

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
     
</head>
<body>
    <form action="{{ route('assessment.store') }}" method="POST">
    @csrf

    <input type="hidden" name="subject_id" value="{{ $subject->id }}">

    <table class="table table-bordered mt-3" style="width: 1800px">

        <thead>
            <tr>
                <th>S/N</th>
                <th>Name</th>

                <th>CW1</th>
                <th>CW2</th>
                <th>CW3</th>
                <th>CW4</th>
                <th>CW5</th>
                <th>CW6</th>
                <th>CW7</th>
                <th>CW8</th>
                <th>CW9</th>
                <th>CW10</th>

                <th>HW1</th>
                <th>HW2</th>
                <th>HW3</th>
                <th>HW4</th>
                <th>HW5</th>

                <th>TT1</th>
                <th>TT2</th>
                <th>TT3</th>

                <th>Exam</th>
            </tr>
        </thead>

        <tbody>

            @foreach($students as $student)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>
                        {{ $student->firstname }}
                        {{ $student->lastname }}

                        <input type="hidden"
                               name="student_id[]"
                               value="{{ $student->id }}">
                    </td>

                    <td>
                        <input type="number"
                               name="classwork1[]"
                               class="form-control">
                    </td>

                    <td>
                        <input type="number"
                               name="classwork2[]"
                               class="form-control">
                    </td>

                    <td>
                        <input type="number"
                               name="classwork3[]"
                               class="form-control">
                    </td>

                    <td>
                        <input type="number"
                               name="classwork4[]"
                               class="form-control">
                    </td>

                    <td>
                        <input type="number"
                               name="classwork5[]"
                               class="form-control">
                    </td>
                    <td>
                        <input type="number"
                               name="classwork6[]"
                               class="form-control">
                    </td>
                    <td>
                        <input type="number"
                               name="classwork7[]"
                               class="form-control">
                    </td>
                    <td>
                        <input type="number"
                               name="classwork8[]"
                               class="form-control">
                    </td>
                    <td>
                        <input type="number"
                               name="classwork9[]"
                               class="form-control">
                    </td>
                    <td>
                        <input type="number"
                               name="classwork10[]"
                               class="form-control">
                    </td>


                    <td>
                        <input type="number"
                               name="homework1[]"
                               class="form-control">
                    </td>

                    <td>
                        <input type="number"
                               name="homework2[]"
                               class="form-control">
                    </td>
                     <td>
                        <input type="number"
                               name="homework3[]"
                               class="form-control">
                    </td>
                     <td>
                        <input type="number"
                               name="homework4[]"
                               class="form-control">
                    </td>
                     <td>
                        <input type="number"
                               name="homework5[]"
                               class="form-control">
                    </td>

                    <td>
                        <input type="number"
                               name="topictest1[]"
                               class="form-control">
                    </td>
                    <td>
                        <input type="number"
                               name="topictest2[]"
                               class="form-control">
                    </td>
                    <td>
                        <input type="number"
                               name="topictest3[]"
                               class="form-control">
                    </td>

                    <td>
                        <input type="number"
                               name="terminal_exam[]"
                               class="form-control">
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

    <button class="btn btn-success">
        Save Marks
    </button>

</form><br>
<a href="{{ route('assessment.book', $subject->id) }}"
   class="btn btn-primary mb-3">

    View Assessment Book

</a>
</body>
</html>