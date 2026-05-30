@extends("layout.app")

@section("content")

<div class="content" id="content">

    <div class="table-container">

        <form method="GET" id="assessmentForm">

    <div class="mb-3">
        <label>Class</label>

        <select id="class_id" class="form-control">
            @foreach($classes as $class)
                <option value="{{ $class->id }}">
                    {{ $class->class_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Subject</label>

        <select id="subject_id" class="form-control">
            <option value="">--select subject--</option>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}">
                    {{ $subject->subjectName }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="button"
            onclick="goToAssessment()"
            class="btn btn-primary">
        Continue
    </button>

</form>

<script>
function goToAssessment()
{
    let subject = document.getElementById('subject_id').value;
    let classId = document.getElementById('class_id').value;

    window.location =
        '/assessment/create/' +
        subject +
        '/' +
        classId;
}
</script>

    </div>

</div>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
@endsection