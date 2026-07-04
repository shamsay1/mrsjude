@extends("layout.app")
<style>
    .step {
    display: none;
}

.step.active {
    display: block;
}

.step-indicator {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.step-indicator .circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #dee2e6;
    color: #000;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 10px;
    font-weight: bold;
}

.step-indicator .circle.active {
    background: #0d6efd;
    color: white;
}
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
.scheme-step{
    display:none;
}

.scheme-step.active{
    display:block;
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
        @if(Auth::user()->role =="teacher")

        <button class="btn btn-primary mb-3"
            data-bs-toggle="modal"
            data-bs-target="#addSchemeModal">

            + Add Scheme of Work
        </button>
        @endif
         @if(Auth::user()->role == "supervisor" || Auth::user()->role == "headmaster")
        <button class="btn btn-primary mb-3"><a href="/showtl" style="color: white;text-decoration: none">Back</a></button>


        @endif

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

                    <!-- Progress -->
                    <div class="text-center mb-3">
                        <h6 id="schemeStepText">Step 1 of 5</h6>
                    </div>

                    <div class="progress mb-4">
                        <div class="progress-bar"
                            id="schemeProgressBar"
                            style="width:20%">
                        </div>
                    </div>

                    <div class="step-indicator mb-4">
                        <div class="circle active">1</div>
                        <div class="circle">2</div>
                        <div class="circle">3</div>
                        <div class="circle">4</div>
                        <div class="circle">5</div>
                    </div>

                    <!-- STEP 1 -->
                    <div class="scheme-step active">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label>Subject</label>

                                <select name="subject_id"
                                    class="form-control"
                                    required>

                                    <option value="">
                                        -- Select Subject --
                                    </option>

                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">
                                            {{ $subject->subjectName }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Academic Year</label>

                                <input type="text"
                                    name="academic_year"
                                    class="form-control"
                                    value="{{ date('Y') }}/{{ date('Y')+1 }}"
                                    readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Term</label>

                                <select name="term"
                                    class="form-control"
                                    required>

                                    <option value="Term I">Term I</option>
                                    <option value="Term II">Term II</option>
                                    <option value="Term III">Term III</option>

                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Month</label>

                                <input type="text"
                                    name="month"
                                    class="form-control"
                                    value="{{ now()->format('F') }}"
                                    readonly>
                            </div>

                        </div>

                    </div>

                    <!-- STEP 2 -->
                    <div class="scheme-step">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label>Week</label>

                                <input type="number"
                                    min="1"
                                    value="1"
                                    name="week"
                                    class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Period</label>

                                <input type="number"
                                    min="1"
                                    name="period"
                                    class="form-control">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Main Competence</label>

                                <textarea name="main_competence"
                                    class="form-control"
                                    rows="3">At the end of the topic,the student should have  ablility to demonstrate</textarea>
                            </div>

                        </div>

                    </div>

                    <!-- STEP 3 -->
                    <div class="scheme-step">

                        <div class="mb-3">
                            <label>Specific Competence</label>

                            <textarea name="specific_competence"
                                class="form-control"
                                rows="3">At the end of the Topic,student should be able to ....</textarea>
                        </div>

                        <div class="mb-3">
                            <label>Main Learning Activity</label>

                            <textarea name="learning_activity"
                                class="form-control"
                                rows="3">Student should be able to
                            (i)
                            (ii)
                            (iii)
                            (iv)
                            (v)
                            </textarea>
                        </div>

                        <div class="mb-3">
                            <label>Specific Activity</label>

                            <textarea name="specific_activity"
                                class="form-control"
                                rows="3"></textarea>
                        </div>

                    </div>

                    <!-- STEP 4 -->
                    <div class="scheme-step">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label>Teaching Method</label>

                                <select name="teaching_method"
                                    class="form-control">

                                    <option value="Question and Answer">Question and Answer</option>
                                    <option value="Group Discussion">Group Discussion</option>
                                    <option value="Lecture Method">Lecture Method</option>
                                    <option value="Brainstorming">Brainstorming</option>
                                    <option value="Demonstration">Demonstration</option>
                                    <option value="Project Work">Project Work</option>

                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Learning Resource</label>

                                <textarea name="learning_resource"
                                    class="form-control">Textbook, Chalkboard, Notes</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Assessment Tool</label>

                                <select name="assessment_tool"
                                    class="form-control">

                                    <option value="Oral Questions">Oral Questions</option>
                                    <option value="Written Exercise">Written Exercise</option>
                                    <option value="Quiz">Quiz</option>
                                    <option value="Assignment">Assignment</option>
                                    <option value="Observation">Observation</option>

                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Reference</label>

                                <textarea name="reference"
                                    class="form-control">Teacher Guide and Student Textbook</textarea>
                            </div>

                        </div>

                    </div>

                    <!-- STEP 5 -->
                    <div class="scheme-step">

                        <div class="mb-3">
                            <label>Remarks</label>

                            <textarea name="remarks"
                                class="form-control"
                                rows="4">The lesson was taught and understood</textarea>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                        id="schemePrevBtn"
                        class="btn btn-secondary">
                        Back
                    </button>

                    <button type="button"
                        id="schemeNextBtn"
                        class="btn btn-primary">
                        Next
                    </button>

                    <button type="submit"
                        id="schemeSubmitBtn"
                        class="btn btn-success"
                        style="display:none;">
                        Save Scheme
                    </button>

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
            <th>Status</th>
             @if(Auth::user()->role=="headmaster")
        <th>Action</th>
        @endif
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
   <td>

<button
    type="button"
    class="btn btn-sm
    @if($scheme->status == 'pending')
        btn-warning
    @elseif($scheme->status == 'completed')
        btn-success
    @elseif($scheme->status == 'rejected')
        btn-danger
    @else
        btn-secondary
    @endif"
    data-bs-toggle="modal"
    data-bs-target="#schemeStatusModal"
    data-status="{{ $scheme->status }}"
    data-comment="{{ $scheme->comments }}">

    @if($scheme->status == 'pending')

        <i class="bi bi-hourglass-split"></i> Pending

    @elseif($scheme->status == 'completed')

        <i class="bi bi-check-circle-fill"></i> Completed

    @elseif($scheme->status == 'rejected')

        <i class="bi bi-x-circle-fill"></i> Rejected

    @else

        <i class="bi bi-question-circle-fill"></i> {{ ucfirst($scheme->status) }}

    @endif

</button>

</td>

            @if(Auth::user()->role=="headmaster")

<td>

    {{-- Approve --}}
    <form action="{{ route('scheme.approve') }}" method="POST" class="d-inline">

        @csrf

        <input type="hidden" name="scheme_id" value="{{ $scheme->id }}">

        <button
            class="btn btn-success btn-sm"
            onclick="return confirm('Approve this Scheme of Work?')">

            <i class="bi bi-check-circle-fill"></i>

        </button>

    </form>

    {{-- Reject --}}
    <button
        class="btn btn-danger btn-sm"
        data-bs-toggle="modal"
        data-bs-target="#rejectSchemeModal"
        data-id="{{ $scheme->id }}">

        <i class="bi bi-x-circle-fill"></i>

    </button>

</td>

@endif



        </tr>

        @endforeach

    </tbody>

</table>
<div class="modal fade" id="schemeStatusModal" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">Scheme of Work Status</h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <p>
                    <strong>Status:</strong>
                    <span id="schemeModalStatus"></span>
                </p>

                <div id="schemeCommentSection">

                    <hr>

                    <strong>Comment</strong>

                    <div
                        id="schemeModalComment"
                        class="border rounded p-3 bg-light mt-2">

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
<div class="modal fade" id="rejectSchemeModal" tabindex="-1">

    <div class="modal-dialog">

        <form action="{{ route('scheme.reject') }}" method="POST">

            @csrf

            <input type="hidden" name="scheme_id" id="scheme_id">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Reject Scheme of Work
                    </h5>

                    <button
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <label>Comment</label>

                    <textarea
                        class="form-control"
                        name="comment"
                        rows="5"
                        required
                        placeholder="Write reason for rejection"></textarea>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Close

                    </button>

                    <button
                        class="btn btn-danger">

                        Reject

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

</div>

    </div>

</div>
<script>

document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('schemeStatusModal');

    modal.addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        const status = button.getAttribute('data-status');
        const comment = button.getAttribute('data-comment');

        let badge = '';

        if (status === 'pending') {

            badge = '<span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split"></i> Pending</span>';

            document.getElementById('schemeCommentSection').style.display = 'block';

        } else if (status === 'completed') {

            badge = '<span class="badge bg-success"><i class="bi bi-check-circle-fill"></i> Completed</span>';

            // Completed haina comment
            document.getElementById('schemeCommentSection').style.display = 'none';

        } else if (status === 'rejected') {

            badge = '<span class="badge bg-danger"><i class="bi bi-x-circle-fill"></i> Rejected</span>';

            document.getElementById('schemeCommentSection').style.display = 'block';

        } else {

            badge = '<span class="badge bg-secondary">' + status + '</span>';

            document.getElementById('schemeCommentSection').style.display = 'none';

        }

        document.getElementById('schemeModalStatus').innerHTML = badge;

        document.getElementById('schemeModalComment').innerHTML =
            comment && comment.trim() !== ''
                ? comment
                : '<span class="text-muted">No comment available.</span>';

    });

});

</script>
<script>

document.addEventListener('DOMContentLoaded',function(){

    const modal=document.getElementById('rejectSchemeModal');

    modal.addEventListener('show.bs.modal',function(event){

        const button=event.relatedTarget;

        const id=button.getAttribute('data-id');

        document.getElementById('scheme_id').value=id;

    });

});

</script>
<script>

document.addEventListener('DOMContentLoaded', function(){

    let currentStep = 0;

    const steps =
        document.querySelectorAll('.scheme-step');

    const circles =
        document.querySelectorAll(
            '#addSchemeModal .circle'
        );

    const prevBtn =
        document.getElementById(
            'schemePrevBtn'
        );

    const nextBtn =
        document.getElementById(
            'schemeNextBtn'
        );

    const submitBtn =
        document.getElementById(
            'schemeSubmitBtn'
        );

    const progressBar =
        document.getElementById(
            'schemeProgressBar'
        );

    const stepText =
        document.getElementById(
            'schemeStepText'
        );

    function showStep(step){

        steps.forEach((item,index)=>{

            item.classList.remove('active');

            circles[index].classList.remove(
                'active'
            );

            if(index <= step){
                circles[index].classList.add(
                    'active'
                );
            }

        });

        steps[step].classList.add(
            'active'
        );

        stepText.innerHTML =
            `Step ${step+1} of ${steps.length}`;

        progressBar.style.width =
            (((step+1)/steps.length)*100)
            + '%';

        prevBtn.style.display =
            step === 0
            ? 'none'
            : 'inline-block';

        if(step === steps.length-1){

            nextBtn.style.display =
                'none';

            submitBtn.style.display =
                'inline-block';

        }else{

            nextBtn.style.display =
                'inline-block';

            submitBtn.style.display =
                'none';

        }

    }

    nextBtn.addEventListener(
        'click',
        function(){

            if(currentStep <
                steps.length-1){

                currentStep++;

                showStep(
                    currentStep
                );

            }

        }
    );

    prevBtn.addEventListener(
        'click',
        function(){

            if(currentStep > 0){

                currentStep--;

                showStep(
                    currentStep
                );

            }

        }
    );

    showStep(currentStep);

});
</script>
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
@endsection