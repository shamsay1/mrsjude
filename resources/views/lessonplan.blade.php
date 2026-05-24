@extends("layout.app")
<style>

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
        <button class="btn btn-primary mb-3"
            data-bs-toggle="modal"
            data-bs-target="#addLessonPlanModal">

            + Add Lesson Plan

        </button>

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

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label>Subject</label>

                                    <select name="subject_id"
                                        class="form-control">

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
                                        class="form-control">

                                </div>

                            </div>

                            <div class="mb-3">

                                <label>Topic</label>

                                <input type="text"
                                    name="topic"
                                    class="form-control">

                            </div>

                            <div class="mb-3">

                                <label>Sub Topic</label>

                                <input type="text"
                                    name="subtopic"
                                    class="form-control">

                            </div>

                            <div class="mb-3">

                                <label>Objectives</label>

                                <textarea name="objectives"
                                    class="form-control"
                                    rows="3"></textarea>

                            </div>

                            <div class="mb-3">

                                <label>Teaching Methods</label>

                                <textarea name="teaching_methods"
                                    class="form-control"
                                    rows="3"></textarea>

                            </div>

                            <div class="mb-3">

                                <label>Teaching Materials</label>

                                <textarea name="teaching_materials"
                                    class="form-control"
                                    rows="3"></textarea>

                            </div>

                            <div class="mb-3">

                                <label>Evaluation</label>

                                <textarea name="evaluation"
                                    class="form-control"
                                    rows="3"></textarea>

                            </div>

                        </div>

                        <div class="modal-footer">

                            <button class="btn btn-success">
                                Save Lesson Plan
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

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

                        <td>{{ $plan->registered_girls ?? '..............' }}</td>
                        <td>{{ $plan->registered_boys ?? '..............' }}</td>
                        <td>{{ $plan->registered_total ?? '..............' }}</td>

                        <td>{{ $plan->present_girls ?? '..............' }}</td>
                        <td>{{ $plan->present_boys ?? '..............' }}</td>
                        <td>{{ $plan->present_total ?? '..............' }}</td>

                    </tr>

                </tbody>

            </table>

            <!-- MAIN COMPETENCE -->

            <div class="section-title">
                Main Competence:
            </div>

            <div class="content-box">
                {{ $plan->topic }}
            </div>

            <!-- SUB TOPIC -->

            <div class="section-title">
                Sub Topic:
            </div>

            <div class="content-box">
                {{ $plan->subtopic }}
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

        </div>

        <!-- BUTTONS -->

        <div class="mt-4 no-print">

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



@empty

<div class="alert alert-danger">
    No Lesson Plan Found
</div>

@endforelse

    </div>

</div>

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

{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
@endsection