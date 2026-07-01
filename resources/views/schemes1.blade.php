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
                                    rows="3">At the end of the course,the student should able to</textarea>
                            </div>

                        </div>

                    </div>

                    <!-- STEP 3 -->
                    <div class="scheme-step">

                        <div class="mb-3">
                            <label>Specific Competence</label>

                            <textarea name="specific_competence"
                                class="form-control"
                                rows="3">The student should be able to</textarea>
                        </div>

                        <div class="mb-3">
                            <label>Learning Activity</label>

                            <textarea name="learning_activity"
                                class="form-control"
                                rows="3"></textarea>
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
                                rows="4">Prepared as planned.</textarea>
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
         @if(Auth::user()->role =="supervisor" || Auth::user()->role =="headmaster")
    <a href="/showtl" class="btn btn-success text-white mb-2" style="text-decoration: none;">
        Back
    </a>
    @endif
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