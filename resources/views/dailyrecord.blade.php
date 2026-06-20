@extends("layout.app")
<style>
.daily-step{
    display:none;
}

.daily-step.active{
    display:block;
}

.step-indicator{
    display:flex;
    justify-content:center;
    margin-bottom:20px;
}

.step-indicator .circle{
    width:40px;
    height:40px;
    border-radius:50%;
    background:#dee2e6;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:0 5px;
    font-weight:bold;
}

.step-indicator .circle.active{
    background:#0d6efd;
    color:white;
}
</style>
@section("content")

<div class="content" id="content">

    <div class="table-container">

        <!-- Add Daily Record Button -->
        @if(Auth::user()->role =="teacher")
        <button class="btn btn-primary mb-4"
            data-bs-toggle="modal"
            data-bs-target="#addDailyRecordModal">

            + Add Daily Record

        </button>
        @endif

        <!-- Add Modal -->
        <div class="modal fade" id="addDailyRecordModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5>Add Daily Record</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('daily-record.store') }}" method="POST">
                @csrf

                <input type="hidden" name="teacher_id" value="{{ Auth::id() }}">
                <input type="hidden" name="school_id" value="{{ Auth::user()->school_id }}">

                <div class="modal-body">
                    <div class="text-center mb-3">
                        <h6 id="dailyStepText">Step 1 of 4</h6>
                    </div>

                    <div class="progress mb-3">
                        <div class="progress-bar" id="dailyProgressBar" style="width:25%"></div>
                    </div>

                    <div class="step-indicator">
                        <div class="circle active">1</div>
                        <div class="circle">2</div>
                        <div class="circle">3</div>
                        <div class="circle">4</div>
                    </div>

                    <div class="daily-step active">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="fw-bold">Subject</label>
                                <select name="subject_id" class="form-control" required>
                                    <option value="">Select Subject</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}">
                                            {{ $subject->subjectName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="daily-step">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Date</label>
                                <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Period</label>
                                <input type="text" name="period" class="form-control" placeholder="Mf. 1st & 2nd" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Main Topic</label>
                            <textarea name="main_topic" rows="3" class="form-control" placeholder="Andika mada kuu..." required></textarea>
                        </div>
                    </div>

                    <div class="daily-step">
                        <div class="mb-3">
                            <label class="fw-bold">Work Done By Teacher</label>
                            <textarea name="work_done_by_teacher" rows="4" class="form-control" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Work Done By Student</label>
                            <textarea name="work_done_by_student" rows="4" class="form-control" required></textarea>
                        </div>
                    </div>

                    <div class="daily-step">
                        <div class="mb-3">
                            <label class="fw-bold">Evaluation / Remarks</label>
                            <textarea name="remarks" rows="4" class="form-control"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" id="dailyPrevBtn" class="btn btn-secondary">Back</button>
                    <button type="button" id="dailyNextBtn" class="btn btn-primary">Next</button>
                    <button type="submit" id="dailySubmitBtn" class="btn btn-success" style="display:none;">Save Record</button>
                </div>
            </form>
        </div>
    </div>
</div>

        <!-- Daily Record Table -->
        <div class="card shadow-sm">

            <div class="card-body">

                <center>
                    <h3 class="mb-4">
                        <b>
                            KUMBUKUMBU ZA SOMO ZA KILA SIKU
                            (DAILY RECORDS)
                        </b>
                    </h3>
                </center>

                <div class="table-responsive">

                    <table class="table table-bordered">

                        <thead>

                            <tr>

                                <th>
                                    Siku/Tarehe
                                </th>

                                <th>
                                    Darasa
                                </th>

                                <th>
                                    Somo
                                </th>

                                <th>
                                    Kipindi
                                </th>

                                <th>
                                    Mada kuu na Mada ndogo
                                </th>

                                <th>
                                    Kazi iliyofanywa na mwalimu
                                </th>

                                <th>
                                    Kazi iliyofanywa na mwanafunzi
                                </th>

                                <th>
                                    Maelezo
                                </th>

                               
        @if(Auth::user()->role =="teacher")

                                <th>
                                    Action
                                </th>
                                @endif

                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($records as $record)

                                <tr>

                                    <td>
                                        {{ $record->date }}
                                    </td>

                                    <td>
                                        {{ $record->subject->classRoom->class_name }}
                                    </td>

                                    <td>
                                        {{ $record->subject->subjectName }}
                                    </td>

                                    <td>
                                        {{ $record->period }}
                                    </td>

                                    <td>
                                        {{ $record->main_topic }}
                                    </td>

                                    <td>
                                        {{ $record->work_done_by_teacher }}
                                    </td>

                                    <td>
                                        {{ $record->work_done_by_student }}
                                    </td>

                                    <td>
                                        {{ $record->remarks }}
                                    </td>
        @if(Auth::user()->role =="teacher")

                                    <td>

                                        <!-- Delete -->
                                        <form action="{{ route('daily-record.destroy', $record->id) }}"
                                            method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Delete this record?')">

                                                Delete

                                            </button>

                                        </form>

                                    </td>
@endif
                                </tr>

                            @empty

                                <tr>

                                    <td colspan="11"
                                        class="text-center text-danger">

                                        No Daily Records Found

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>
<script>

document.addEventListener('DOMContentLoaded', function(){

    let currentStep = 0;

    const steps =
        document.querySelectorAll(
            '#addDailyRecordModal .daily-step'
        );

    const circles =
        document.querySelectorAll(
            '#addDailyRecordModal .circle'
        );

    const prevBtn =
        document.getElementById(
            'dailyPrevBtn'
        );

    const nextBtn =
        document.getElementById(
            'dailyNextBtn'
        );

    const submitBtn =
        document.getElementById(
            'dailySubmitBtn'
        );

    const progressBar =
        document.getElementById(
            'dailyProgressBar'
        );

    const stepText =
        document.getElementById(
            'dailyStepText'
        );

    function showStep(step){

        steps.forEach((item,index)=>{

            item.classList.remove('active');

            if(circles[index]){
                circles[index]
                    .classList.remove(
                        'active'
                    );
            }

            if(index <= step &&
               circles[index]){

                circles[index]
                    .classList.add(
                        'active'
                    );

            }

        });

        steps[step]
            .classList.add('active');

        stepText.innerHTML =
            `Step ${step + 1} of ${steps.length}`;

        progressBar.style.width =
            (((step + 1)
            / steps.length) * 100)
            + '%';

        prevBtn.style.display =
            step === 0
            ? 'none'
            : 'inline-block';

        if(step ===
            steps.length - 1){

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
                steps.length - 1){

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
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
@endsection