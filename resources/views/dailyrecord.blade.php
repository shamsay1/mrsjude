@extends("layout.app")

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

                        <button class="btn-close"
                            data-bs-dismiss="modal"></button>

                    </div>

                    <form action="{{ route('daily-record.store') }}"
                        method="POST">

                        @csrf

                        <div class="modal-body">

                            <div class="row">

                                <div class="col-md-4 mb-3">

                                    <label>Teacher</label>

                                    <select name="teacher_id"
                                        class="form-control">

                                        <option value="">
                                            Select Teacher
                                        </option>

                                        @foreach ($teachers as $teacher)

                                            <option value="{{ $teacher->id }}">

                                                {{ $teacher->firstname }}
                                                {{ $teacher->lastname }}

                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                                <div class="col-md-4 mb-3">

                                    <label>School</label>

                                    <select name="school_id"
                                        class="form-control">

                                        <option value="">
                                            Select School
                                        </option>

                                        @foreach ($schools as $school)

                                            <option value="{{ $school->id }}">
                                                {{ $school->school_name }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                                <div class="col-md-4 mb-3">

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

                            </div>

                            <div class="row">

                                <div class="col-md-4 mb-3">

                                    <label>Date</label>

                                    <input type="date"
                                        name="date"
                                        class="form-control">

                                </div>

                                <div class="col-md-4 mb-3">

                                    <label>Period</label>

                                    <input type="text"
                                        name="period"
                                        class="form-control">

                                </div>

                            </div>

                            <div class="mb-3">

                                <label>Main Topic</label>

                                <textarea name="main_topic"
                                    rows="3"
                                    class="form-control"></textarea>

                            </div>

                            <div class="mb-3">

                                <label>Work Done By Teacher</label>

                                <textarea name="work_done_by_teacher"
                                    rows="3"
                                    class="form-control"></textarea>

                            </div>

                            <div class="mb-3">

                                <label>Work Done By Student</label>

                                <textarea name="work_done_by_student"
                                    rows="3"
                                    class="form-control"></textarea>

                            </div>

                            <div class="mb-3">

                                <label>Remarks</label>

                                <textarea name="remarks"
                                    rows="2"
                                    class="form-control"></textarea>

                            </div>

                        </div>

                        <div class="modal-footer">

                            <button class="btn btn-success">
                                Save Record
                            </button>

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

                                <th>
                                    Sahihi ya mwalimu
                                </th>

                                <th>
                                    Saini ya mwanafunzi
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

                                    <td></td>

                                    <td></td>
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

{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
@endsection