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

.progress {
    height: 8px;
}
    .lesson-paper{
        width: 100%;
        background: #fff;
        padding: 40px;
        font-family: "Times New Roman", serif;
        border: 1px solid #ddd;
    }

    .lesson-paper h2{
        text-align: center;
        font-weight: bold;
        margin-bottom: 30px;
        letter-spacing: 1px;
    }

    .lesson-paper p{
        margin-bottom: 10px;
        font-size: 17px;
        line-height: 1.7;
    }

    .lesson-paper .line{
        border-bottom: 1px dotted #000;
        display: inline-block;
        min-width: 200px;
        padding-left: 5px;
    }

    .lesson-table{
        width: 100%;
        border-collapse: collapse;
        margin-top: 25px;
        margin-bottom: 30px;
    }

    .lesson-table th,
    .lesson-table td{
        border: 1px solid #000;
        padding: 10px;
        text-align: center;
        font-size: 16px;
    }

    .section-title{
        font-weight: bold;
    }

    .content-box{
        margin-left: 20px;
        margin-bottom: 15px;
    }

    /* ===== PRINT ===== */

    @media print {

        body *{
            visibility: hidden;
        }

        .lesson-paper,
        .lesson-paper *{
            visibility: visible;
        }

        .lesson-paper{
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            padding: 25px;
            border: none;
            box-shadow: none;
        }

        .no-print{
            display: none !important;
        }

        table{
            width: 100%;
            border-collapse: collapse !important;
        }

        table th,
        table td{
            border: 1px solid black !important;
            padding: 8px !important;
            color: black !important;
            background: white !important;
        }

        *{
            color: black !important;
            box-shadow: none !important;
            text-shadow: none !important;
        }

        @page{
            size: A4;
            margin: 15mm;
        }

    }

</style>
@section("content")

<div class="content" id="content">

    <div class="table-container">

        <!-- Add Lesson Plan Button -->
        @if(Auth::user()->role =="teacher")
        <button class="btn btn-primary mb-3"
            data-bs-toggle="modal"
            data-bs-target="#addLessonPlanModal">

            + Add Lesson Plan

        </button>
        @endif

        <!-- Add Modal -->
       <div class="modal fade" id="addLessonPlanModal" tabindex="-1">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header bg-primary text-white">

                <h5>Add Lesson Plan</h5>

                <button class="btn-close"
                    data-bs-dismiss="modal"></button>

            </div>

            <form action="{{ route('lesson-plan.store') }}"
                method="POST">

                @csrf

                <div class="modal-body">

                    <!-- Progress -->
                    <div class="text-center mb-3">
                        <h6 id="stepText">Step 1 of 4</h6>
                    </div>

                    <div class="progress mb-4">
                        <div id="progressBar"
                            class="progress-bar"
                            style="width:25%">
                        </div>
                    </div>

                    <div class="step-indicator">
                        <div class="circle active">1</div>
                        <div class="circle">2</div>
                        <div class="circle">3</div>
                        <div class="circle">4</div>
                    </div>

                    <!-- STEP 1 -->
                    <div class="step active">

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label>Subject</label>

                                <select name="subject_id"
                                    id="subject_id"
                                    class="form-control"
                                    required>

                                    <option value="">
                                        Select Subject
                                    </option>

                                    @foreach ($subjects as $subject)

                                        <option value="{{ $subject->id }}">
                                            {{ $subject->subjectName }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label>Lesson Date</label>

                                <input type="date"
    name="lesson_date"
    class="form-control"
    value="{{ date('Y-m-d') }}"
    required>

                            </div>

                        </div>

                        <div class="mb-3">

                            <label>Topic</label>

                            <select name="topic_id"
                                id="topic_id"
                                class="form-control"
                                required>

                                <option value="">
                                    Select Topic
                                </option>

                            </select>

                        </div>

                    </div>

                    <!-- STEP 2 -->
                    <div class="step">

                        <div class="mb-3">

                            <label>Sub Topic</label>

                            <select name="sub_topic_id"
                                id="sub_topic_id"
                                class="form-control"
                                required>

                                <option value="">
                                    Select Sub Topic
                                </option>

                            </select>

                        </div>

                        <div class="mb-3">

                            <label>Objectives</label>

                            <textarea name="objectives"
    rows="4"
    class="form-control"
    required>The student should be able to </textarea>

                        </div>

                    </div>

                    <!-- STEP 3 -->
                    <div class="step">

                        <div class="mb-3">

    <label>Teaching Method</label>

    <select name="teaching_methods"
        class="form-control"
        required>

        <option value="">
            Select Teaching Method
        </option>

        <option value="Question and Answer">
            Question and Answer
        </option>

        <option value="Group Discussion">
            Group Discussion
        </option>

        <option value="Lecture Method">
            Lecture Method
        </option>

        <option value="Demonstration">
            Demonstration
        </option>

        <option value="Brainstorming">
            Brainstorming
        </option>

        <option value="Role Play">
            Role Play
        </option>

        <option value="Project Work">
            Project Work
        </option>

        <option value="Practical Work">
            Practical Work
        </option>

        <option value="Presentation">
            Presentation
        </option>

        <option value="Peer Teaching">
            Peer Teaching
        </option>

        <option value="Case Study">
            Case Study
        </option>

    </select>

</div>

                        <div class="mb-3">

                            <label>Teaching Materials</label>

                            <textarea name="teaching_materials"
                                rows="4"
                                class="form-control"
                                required>Chalk,Blackboard,Stick,Manila,Pictures,Charts</textarea>

                        </div>

                    </div>

                    <!-- STEP 4 -->
                    <div class="step">

                        <div class="mb-3">

                            <label>Evaluation</label>

                            <textarea name="evaluation"
                                rows="4"
                                class="form-control"
                                required></textarea>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                        id="prevBtn"
                        class="btn btn-secondary">
                        Back
                    </button>

                    <button type="button"
                        id="nextBtn"
                        class="btn btn-primary">
                        Next
                    </button>

                    <button type="submit"
                        id="submitBtn"
                        class="btn btn-success"
                        style="display:none;">
                        Save Lesson Plan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script>

document.getElementById('subject_id')
.addEventListener('change', function () {

    let subjectId = this.value;

    let topicSelect =
        document.getElementById('topic_id');

    let subTopicSelect =
        document.getElementById('sub_topic_id');

    topicSelect.innerHTML =
        '<option value="">Loading Topics...</option>';

    subTopicSelect.innerHTML =
        '<option value="">Select Sub Topic</option>';

    fetch('/get-topics/' + subjectId)

        .then(response => response.json())

        .then(data => {

            topicSelect.innerHTML =
                '<option value="">Select Topic</option>';

            data.forEach(topic => {

                topicSelect.innerHTML += `
                    <option value="${topic.id}">
                        ${topic.topic_name}
                    </option>
                `;

            });

        });

});

document.getElementById('topic_id')
.addEventListener('change', function () {

    let topicId = this.value;

    let subTopicSelect =
        document.getElementById('sub_topic_id');

    subTopicSelect.innerHTML =
        '<option value="">Loading Sub Topics...</option>';

    fetch('/get-subtopics/' + topicId)

        .then(response => response.json())

        .then(data => {

            subTopicSelect.innerHTML =
                '<option value="">Select Sub Topic</option>';

            data.forEach(subTopic => {

                subTopicSelect.innerHTML += `
                    <option value="${subTopic.id}">
                        ${subTopic.sub_topic_name}
                    </option>
                `;

            });

        });

});

</script>

        <!-- Display Lesson Plans -->
       @forelse ($lessonPlans as $plan)



    <div class="card-body">

        <!-- PRINT AREA -->
        <div class="lesson-paper" id="printableArea{{ $plan->id }}">

            <h2>LESSON PLAN</h2>

            <!-- TOP SECTION -->
            <div class="row mb-4">

                <div class="col-6">

                    <p>
                        <strong>Name of School:</strong>

                        <span class="line">
                            {{ $plan->subject->classRoom->school->school_name }}
                        </span>
                    </p>

                    <p>
                        <strong>Form:</strong>

                        <span class="line">
                            {{ $plan->subject->classRoom->class_name }}
                        </span>
                    </p>

                    <p>
                        <strong>Time:</strong>

                        <span class="line">
                            {{ $plan->time ?? '40 min' }}
                        </span>
                    </p>

                </div>

                <div class="col-6">

                    <p>
                        <strong>Teacher's Name:</strong>

                        <span class="line">
                            {{ $plan->subject->teacher->firstname }}
                            {{ $plan->subject->teacher->lastname }}
                        </span>
                    </p>

                    <p>
                        <strong>Subject:</strong>

                        <span class="line">
                            {{ $plan->subject->subjectName }}
                        </span>
                    </p>

                    <p>
                        <strong>Date:</strong>

                        <span class="line">
                            {{ \Carbon\Carbon::parse($plan->lesson_date)->format('l d/m/Y') }}
                        </span>
                    </p>

                </div>

            </div>

            <!-- STUDENTS TABLE -->

            <table class="table table-bordered table-sm">

                <thead>

                    <tr>
                        <th colspan="3">Registered</th>
                        <th colspan="3">Present</th>
                    </tr>

                    <tr>

                        <th>Girls</th>
                        <th>Boys</th>
                        <th>Total</th>

                        <th>Girls</th>
                        <th>Boys</th>
                        <th>Total</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>
                        

                        {{-- <td>{{ $female}}</td>
                        <td>{{ $male}}</td>
                        <td>{{ $total}}</td> --}}

                        <td>{{ $female ?? '..............' }}</td>
                        <td>{{ $male ?? '..............' }}</td>
                        <td>{{ $total ?? '..............' }}</td>

                    </tr>

                </tbody>

            </table>

            <!-- MAIN COMPETENCE -->

            <div class="section-title">
                Main Topic:
            </div>

            <div class="content-box">
    {{ $plan->topic?->topic_name }}
</div>

            <!-- SUB TOPIC -->

            <div class="section-title">
                Sub Topic:
            </div>

            <div class="content-box">
    {{ $plan->subTopic?->sub_topic_name }}
</div>

            <!-- OBJECTIVES -->

            <div class="section-title">
                Specific Objectives:
            </div>

            <div class="content-box">
                {!! nl2br(e($plan->objectives)) !!}
            </div>

            <!-- RESOURCES -->

            <div class="section-title">
                Teaching and Learning Resources:
            </div>

            <div class="content-box">
                {!! nl2br(e($plan->teaching_materials)) !!}
            </div>

            <!-- REFERENCES -->

            <div class="section-title">
                References:
            </div>

            <div class="content-box">
                {!! nl2br(e($plan->references ?? '')) !!}
            </div>

            <div class="section-title">
                Status:
            </div>

            <div class="content-box">
                @if($plan->status == "completed")
                <span class="badge bg-success">Already reviewed</span>
                @else
                <span class="bagde bg-danger">{{$plan->status}}</span>

                @endif
            </div>

        </div>

        <!-- BUTTONS -->

        <div class="mt-4 no-print">
            @if(Auth::user()->role == "headmaster")
            <button
    type="button"
    class="btn btn-primary approveBtn mb-3"
    data-bs-toggle="modal"
    data-bs-target="#approveModal"
    data-id="{{ $plan->id }}">
    Approve
</button>
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('plans.approve') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Approve Plan</h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="plan_id" id="plan_id">

                    <p>Are you sure you want to approve this plan?</p>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit"
                            class="btn btn-primary">
                        Approve
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>
<script>
document.querySelectorAll('.approveBtn').forEach(button => {

    button.addEventListener('click', function () {

        document.getElementById('plan_id').value = this.dataset.id;

    });

});
</script>
   @else
            <button class="btn btn-success"
        data-bs-toggle="modal"
        data-bs-target="#stageModal{{ $plan->id }}">

        Manage Stages

    </button>
            <button class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#editLessonPlan{{ $plan->id }}">

                Edit

            </button>

            <form action="{{ route('lesson-plan.destroy', $plan->id) }}"
                method="POST"
                style="display:inline-block;">

                @csrf
                @method('DELETE')

                <button class="btn btn-danger"
                    onclick="return confirm('Delete this lesson plan?')">

                    Delete

                </button>

            </form>

            <button class="btn btn-dark"
                onclick="printLessonPlan('printableArea{{ $plan->id }}')">

                Print

            </button>

        </div>

    </div>

    @endif

    <div class="modal fade" id="stageModal{{ $plan->id }}">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header bg-success text-white">
                <h5>Lesson Plan Stages</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('lesson-plan-stage.store') }}"
                  method="POST">

                @csrf

                <input type="hidden"
                       name="lesson_plan_id"
                       value="{{ $plan->id }}">

                <div class="modal-body">

                    <table class="table table-bordered">

                        <thead>

                            <tr>
                                <th>Stage</th>
                                <th>Minutes</th>
                                <th>Teaching Activities</th>
                                <th>Learning Activities</th>
                                <th>Assessment</th>
                            </tr>

                        </thead>

                        <tbody>
    @php
    $stages = [
        'Introduction',
        'Competence Development',
        'Design',
        'Realisation'
    ];
    @endphp

    @foreach($stages as $index => $stage)
    <tr>
        <td>
            {{ $stage }}
            <input type="hidden" name="stages[{{ $index }}][stage_name]" value="{{ $stage }}">
        </td>
        <td>
            <input type="number"
       name="stages[{{ $index }}][minutes]"
       class="form-control minutes"
       min="0"
       required>
        </td>
        <td>
            <textarea name="stages[{{ $index }}][teaching_activities]" class="form-control" rows="3" required></textarea>
        </td>
        <td>
            <textarea name="stages[{{ $index }}][learning_activities]" class="form-control" rows="3" required></textarea>
        </td>
        <td>
            <textarea name="stages[{{ $index }}][assessment]" class="form-control" rows="3" required></textarea>
        </td>
    </tr>
    @endforeach
</tbody>
                    </table>

                </div>

                <div class="modal-footer">

                    <button type="submit"
                            class="btn btn-success">

                        Save Stages

                    </button>

                </div>

            </form>

        </div>
    </div>
</div>



@empty

<div class="alert alert-danger">
    No Lesson Plan Found
</div>

@endforelse
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Stage</th>
            <th>Time (Minutes)</th>
            <th>Teaching Activities</th>
            <th>Learning Activities</th>
            <th>Assessment</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($plan) && $plan->stages && $plan->stages->count() > 0)
            @foreach($plan->stages as $stage)
                <tr>
                    <td>{{ $stage->stage_name }}</td>
                    <td>{{ $stage->minutes }}</td>
                    <td>
                        {!! nl2br(e($stage->teaching_activities)) !!}
                    </td>
                    <td>
                        {!! nl2br(e($stage->learning_activities)) !!}
                    </td>
                    <td>
                        {!! nl2br(e($stage->assessment)) !!}
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5" class="text-center text-muted py-3">
                    Hakuna hatua (stages) zilizopatikana kwenye andalio hili.
                </td>
            </tr>
        @endif
    </tbody>
</table>
 @if(Auth::user()->role =="supervisor" || Auth::user()->role =="headmaster")
    <a href="/showtl" class="btn btn-success text-white" style="text-decoration: none;">
        Back
    </a>
    @endif
    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const minuteInputs = document.querySelectorAll(".minutes");

    minuteInputs.forEach(input => {

        input.addEventListener("input", function () {

            let total = 0;

            minuteInputs.forEach(item => {
                total += parseInt(item.value) || 0;
            });

            if (total > 80) {

                alert("Total minutes cannot exceed 80.");

                this.value = "";

            }

        });

    });

});
</script>

<script>

function printLessonPlan(id){

    const content = document.getElementById(id).innerHTML;

    const printWindow = window.open('', '', 'width=1000,height=900');

    printWindow.document.write(`

        <html>

        <head>

            <title>Lesson Plan</title>

            <style>

                @page{
                    size:A4;
                    margin:15mm;
                }

                body{
                    font-family:"Times New Roman", serif;
                    padding:20px;
                    color:black;
                }

                h2{
                    text-align:center;
                    margin-bottom:30px;
                    font-size:28px;
                    font-weight:bold;
                }

                p{
                    font-size:17px;
                    line-height:1.8;
                    margin-bottom:10px;
                }

                .line{
                    border-bottom:1px dotted black;
                    display:inline-block;
                    min-width:200px;
                    padding-left:5px;
                }

                .lesson-table{
                    width:100%;
                    border-collapse:collapse;
                    margin-top:20px;
                    margin-bottom:25px;
                }

                .lesson-table th,
                .lesson-table td{
                    border:1px solid black;
                    padding:10px;
                    text-align:center;
                    font-size:16px;
                }

                .section-title{
                    font-weight:bold;
                    margin-top:18px;
                    margin-bottom:5px;
                    font-size:18px;
                }

                .content-box{
                    margin-left:20px;
                    white-space:pre-line;
                    font-size:17px;
                }

            </style>

        </head>

        <body onload="window.print(); window.close();">

            ${content}

        </body>

        </html>

    `);

    printWindow.document.close();

}

</script>
<script>
document.addEventListener("DOMContentLoaded", function() {

    let currentStep = 0;

    const steps = document.querySelectorAll(".step");
    const circles = document.querySelectorAll(".circle");

    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    const submitBtn = document.getElementById("submitBtn");

    const progressBar =
        document.getElementById("progressBar");

    const stepText =
        document.getElementById("stepText");

    function showStep(step) {

        steps.forEach((item, index) => {

            item.classList.remove("active");

            circles[index].classList.remove("active");

            if(index <= step) {
                circles[index].classList.add("active");
            }

        });

        steps[step].classList.add("active");

        stepText.innerHTML =
            `Step ${step + 1} of ${steps.length}`;

        let percent =
            ((step + 1) / steps.length) * 100;

        progressBar.style.width =
            percent + "%";

        prevBtn.style.display =
            step === 0 ? "none" : "inline-block";

        if(step === steps.length - 1){

            nextBtn.style.display = "none";
            submitBtn.style.display = "inline-block";

        }else{

            nextBtn.style.display = "inline-block";
            submitBtn.style.display = "none";

        }

    }

    nextBtn.addEventListener("click", function() {

        if(currentStep < steps.length - 1){

            currentStep++;

            showStep(currentStep);

        }

    });

    prevBtn.addEventListener("click", function() {

        if(currentStep > 0){

            currentStep--;

            showStep(currentStep);

        }

    });

    showStep(currentStep);

});
</script>
<script>

document.getElementById('subject_id')
.addEventListener('change', function () {

    let subjectId = this.value;

    let topicSelect =
        document.getElementById('topic_id');

    let subTopicSelect =
        document.getElementById('sub_topic_id');

    topicSelect.innerHTML =
        '<option value="">Loading...</option>';

    subTopicSelect.innerHTML =
        '<option value="">Select Sub Topic</option>';

    fetch('/get-topics/' + subjectId)

        .then(response => response.json())

        .then(data => {

            topicSelect.innerHTML =
                '<option value="">Select Topic</option>';

            data.forEach(topic => {

                topicSelect.innerHTML += `
                    <option value="${topic.id}">
                        ${topic.topic_name}
                    </option>
                `;

            });

        });

});

document.getElementById('topic_id')
.addEventListener('change', function () {

    let topicId = this.value;

    let subTopicSelect =
        document.getElementById('sub_topic_id');

    subTopicSelect.innerHTML =
        '<option value="">Loading...</option>';

    fetch('/get-subtopics/' + topicId)

        .then(response => response.json())

        .then(data => {

            subTopicSelect.innerHTML =
                '<option value="">Select Sub Topic</option>';

            data.forEach(subTopic => {

                subTopicSelect.innerHTML += `
                    <option value="${subTopic.id}">
                        ${subTopic.sub_topic_name}
                    </option>
                `;

            });

        });

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
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
@endsection