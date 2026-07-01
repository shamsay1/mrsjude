@extends("layout.app")

@section("content")

<div class="content" id="content">
    @if(Auth::user()->role =="supervisor" || Auth::user()->role =="headmaster")
    <a href="/showtl" class="btn btn-success text-white mb-2" style="text-decoration: none;">
        Back
    </a>
    @endif
    <div class="table-container">

        <table class="table table-bordered">

    <tr>
        <th>Subject</th>
        <th>Class</th>
        <th>Action</th>
    </tr>

    @foreach($subjects as $subject)

    <tr>

        <td>{{ $subject->subjectName }}</td>

        <td>{{ $subject->classRoom->class_name }}</td>

        <td>

            <a href="{{ route('assessment.book', $subject->id) }}"
               class="btn btn-success btn-sm">

                Open Book

            </a>

        </td>

    </tr>

    @endforeach

</table>

    </div>

</div>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
@endsection