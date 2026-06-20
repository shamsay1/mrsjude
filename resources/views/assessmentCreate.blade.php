

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
    <h2 style="text-align: center;font-family: 'Times New Roman', Times, serif;margin-top: 20px">ASSESSMENT BOOK RECORDS</h2>
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
                <input type="number" min="0" max="10" name="classwork1[]" class="form-control classwork" style="width: 70px">
            </td>
            <td>
                <input type="number" min="0" max="10" name="classwork2[]" class="form-control classwork" style="width: 70px">
            </td>
            <td>
                <input type="number" min="0" max="10" name="classwork3[]" class="form-control classwork" style="width: 70px">
            </td>
            <td>
                <input type="number" min="0" max="10" name="classwork4[]" class="form-control classwork" style="width: 70px">
            </td>
            <td>
                <input type="number" min="0" max="10" name="classwork5[]" class="form-control classwork" style="width: 70px">
            </td>
            <td>
                <input type="number" min="0" max="10" name="classwork6[]" class="form-control classwork" style="width: 70px">
            </td>
            <td>
                <input type="number" min="0" max="10" name="classwork7[]" class="form-control classwork" style="width: 70px">
            </td>
            <td>
                <input type="number" min="0" max="10" name="classwork8[]" class="form-control classwork" style="width: 70px">
            </td>
            <td>
                <input type="number" min="0" max="10" name="classwork9[]" class="form-control classwork" style="width: 70px">
            </td>
            <td>
                <input type="number" min="0" max="10" name="classwork10[]" class="form-control classwork" style="width: 70px">
            </td>

            <td>
                <input type="number" min="0" max="10" name="homework1[]" class="form-control homework" style="width: 70px">
            </td>
            <td>
                <input type="number" min="0" max="10" name="homework2[]" class="form-control homework" style="width: 70px">
            </td>
            <td>
                <input type="number" min="0" max="10" name="homework3[]" class="form-control homework" style="width: 70px">
            </td>
            <td>
                <input type="number" min="0" max="10" name="homework4[]" class="form-control homework" style="width: 70px">
            </td>
            <td>
                <input type="number" min="0" max="10" name="homework5[]" class="form-control homework" style="width: 70px">
            </td>

            <td>
                <input type="number" min="0" max="20" name="topictest1[]" class="form-control test" style="width: 70px">
            </td>
            <td>
                <input type="number" min="0" max="20" name="topictest2[]" class="form-control test" style="width: 70px">
            </td>
            <td>
                <input type="number" min="0" max="20" name="topictest3[]" class="form-control test" style="width: 70px">
            </td>

            <td>
                <input type="number" min="0" max="60" name="terminal_exam[]" class="form-control exam" style="width: 70px">
            </td>

        </tr>

    @endforeach

</tbody>

<script>
document.addEventListener('DOMContentLoaded', function () {
    
    // Kuzuia Classwork na Homework (0 - 10)
    document.querySelectorAll('.classwork, .homework').forEach(function (input) {
        input.addEventListener('input', function () {
            if (this.value > 10) {
                alert('Tafadhali weka namba kuanzia 0 hadi 10 pekee!');
                this.value = ''; // Inafuta ile namba kubwa aliyoweka
            }
        });
    });

    // Kuzuia Topic Tests (0 - 20)
    document.querySelectorAll('.test').forEach(function (input) {
        input.addEventListener('input', function () {
            if (this.value > 20) {
                alert('Tafadhali weka namba kuanzia 0 hadi 20 pekee!');
                this.value = ''; // Inafuta ile namba kubwa aliyoweka
            }
        });
    });

    // Kuzuia Terminal Exam (0 - 60)
    document.querySelectorAll('.exam').forEach(function (input) {
        input.addEventListener('input', function () {
            if (this.value > 60) {
                alert('Tafadhali weka namba kuanzia 0 hadi 60 pekee!');
                this.value = ''; 
            }
        });
    });
});
</script>

    </table>

    <button class="btn btn-success">
        Save Marks
    </button>

</form><br>
<div class="d-flex align-items-center gap-2 mb-3">
    
    <a href="{{ route('assessment.book', $subject->id) }}" class="btn btn-primary">
        View Assessment Book
    </a>


    @if(Auth::user()->role =="teacher")
    <a href="/assessment" class="btn btn-success text-white" style="text-decoration: none;">
        Back
    </a>
    @else
    <a href="/showtl" class="btn btn-success text-white" style="text-decoration: none;">
        Back
    </a>
    @endif

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Success!',
    text: '{{ session('success') }}',
    confirmButtonText: 'OK'
});
</script>
@endif
</body>
</html>