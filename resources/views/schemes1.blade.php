@extends("layout.app")
<style>
    .scheme-table{
    min-width:1800px;
    font-size:13px;
}

.scheme-table th{
    background:#e9ecef;
    text-align:center;
    vertical-align:middle;
    font-weight:bold;
}

.scheme-table td{
    vertical-align:top;
    white-space:normal;
}

.scheme-table th:nth-child(1),
.scheme-table td:nth-child(1){
    width:250px;
}

.scheme-table th:nth-child(2),
.scheme-table td:nth-child(2){
    width:250px;
}

.scheme-table th:nth-child(3),
.scheme-table td:nth-child(3){
    width:250px;
}

.scheme-table th:nth-child(4),
.scheme-table td:nth-child(4){
    width:250px;
}

.scheme-table th:nth-child(5),
.scheme-table td:nth-child(5){
    width:80px;
    text-align:center;
}

.scheme-table th:nth-child(6),
.scheme-table td:nth-child(6){
    width:70px;
    text-align:center;
}

.scheme-table th:nth-child(7),
.scheme-table td:nth-child(7){
    width:70px;
    text-align:center;
}

.scheme-table th:nth-child(8),
.scheme-table td:nth-child(8){
    width:220px;
}

.scheme-table th:nth-child(9),
.scheme-table td:nth-child(9){
    width:220px;
}

.scheme-table th:nth-child(10),
.scheme-table td:nth-child(10){
    width:220px;
}

.scheme-table th:nth-child(11),
.scheme-table td:nth-child(11){
    width:180px;
}

.scheme-table th:nth-child(12),
.scheme-table td:nth-child(12){
    width:180px;
}
</style>
@section("content")

<div class="content" id="content">

    <div class="table-container">

        <!-- ADD BUTTON -->
        <button class="btn btn-primary mb-3"
            data-bs-toggle="modal"
            data-bs-target="#addSchemeModal">

            + Add Scheme of Work
        </button>

        <!-- ADD MODAL -->
        <div class="modal fade" id="addSchemeModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header bg-primary text-white">
                        <h5>Add Scheme of Work</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form action="{{ route('scheme.store') }}" method="POST">
                        @csrf

                        <div class="modal-body">

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label>Subject</label>
                                    <select name="subject_id" class="form-control">
                                        <option value="">--select subject--</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}">
                                                {{ $subject->subjectName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Academic Year</label>
                                    <input type="text" name="academic_year" class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Term</label>
                                    <input type="text" name="term" class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Month</label>
                                    <input type="text" name="month" class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Week</label>
                                    <input type="number" min="1" name="week" class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Period</label>
                                    <input type="number" name="period" class="form-control">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>Main Competence</label>
                                    <textarea name="main_competence" class="form-control"></textarea>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>Specific Competence</label>
                                    <textarea name="specific_competence" class="form-control"></textarea>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>Learning Activity</label>
                                    <textarea name="learning_activity" class="form-control"></textarea>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>Specific Activity</label>
                                    <textarea name="specific_activity" class="form-control"></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
    <label>Teaching Method</label>
    <textarea name="teaching_method" class="form-control"></textarea>
</div>

<div class="col-md-6 mb-3">
    <label>Learning Resource</label>
    <textarea name="learning_resource" class="form-control"></textarea>
</div>

<div class="col-md-6 mb-3">
    <label>Assessment Tool</label>
    <textarea name="assessment_tool" class="form-control"></textarea>
</div>

<div class="col-md-6 mb-3">
    <label>Reference</label>
    <textarea name="reference" class="form-control"></textarea>
</div>

<div class="col-md-12 mb-3">
    <label>Remarks</label>
    <textarea name="remarks" class="form-control"></textarea>
</div>

                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-success">Save</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <!-- TABLE -->
        <div class="table-responsive">
            @if(Auth::user()->role != "teacher")
<div class="card mb-3" style="border-radius: 2px">
    <div class="card-body">

        <h4 class="text-center fw-bold">
            SCHEME OF WORK
        </h4>

        <div class="row">

    <div class="col-md-6">

        <p>
            <strong>SCHOOL NAME:</strong>
            {{ $teacher->school->school_name ?? 'N/A' }}
        </p>

        <p>
            <strong>TEACHER NAME:</strong>
            {{ $teacher->firstname }}
            {{ $teacher->middlename }}
            {{ $teacher->lastname }}
        </p>

        <p>
            <strong>CLASS:</strong>
            {{ $schemes->first()->subject->classRoom->class_name ?? 'N/A' }}
        </p>

    </div>

    <div class="col-md-6">

        <p>
            <strong>SUBJECT:</strong>
            {{ $schemes->first()->subject->subjectName ?? 'N/A' }}
        </p>

        <p>
            <strong>TERM:</strong>
            {{ $schemes->first()->term ?? 'N/A' }}
        </p>

        <p>
            <strong>ACADEMIC YEAR:</strong>
            {{ $schemes->first()->academic_year ?? 'N/A' }}
        </p>

    </div>

</div>

    </div>
</div>
@endif
<table class="table table-bordered scheme-table">

    <thead>
        <tr>
            <th>Main Competence</th>
            <th>Specific Competence</th>
            <th>Learning Activities</th>
            <th>Specific Activities</th>
            <th>Month</th>
            <th>Week</th>
            <th>Period</th>
            <th>Teaching & Learning Methods</th>
            <th>Teaching & Learning Resources</th>
            <th>Assessment Tools</th>
            <th>Reference</th>
            <th>Remarks</th>
        </tr>
    </thead>

    <tbody>

        @foreach($schemes as $scheme)

        <tr>

            <td>{{ $scheme->main_competence }}</td>

            <td>{{ $scheme->specific_competence }}</td>

            <td>{{ $scheme->learning_activity }}</td>

            <td>{{ $scheme->specific_activity }}</td>

            <td>{{ $scheme->month }}</td>

            <td>{{ $scheme->week }}</td>

            <td>{{ $scheme->period }}</td>

            <td>{{ $scheme->teaching_method }}</td>

            <td>{{ $scheme->learning_resource }}</td>

            <td>{{ $scheme->assessment_tool }}</td>

            <td>{{ $scheme->reference }}</td>

            <td>{{ $scheme->remarks }}</td>


        </tr>

        @endforeach

    </tbody>

</table>

</div>

    </div>

</div>

@endsection