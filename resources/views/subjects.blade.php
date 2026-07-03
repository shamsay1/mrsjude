@extends("layout.app")

@section("content")

<div class="content" id="content">

    <div class="table-container">

        <!-- Add Subject Button -->
        @if(Auth::user()->role !="teacher")
        <button class="btn btn-primary mb-3"
            data-bs-toggle="modal"
            data-bs-target="#addSubjectModal">

            + Add Subject

        </button>
        @endif

        <!-- Add Modal -->
        <div class="modal fade" id="addSubjectModal" tabindex="-1">

            <div class="modal-dialog modal-xl">

                <div class="modal-content" style="border-radius:12px;">

                    <div class="modal-header bg-primary text-white">

                        <h5 class="modal-title">Add Subject</h5>

                        <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"></button>

                    </div>

                    <form action="{{ route('subject.store') }}"
                        method="POST">

                        @csrf

                        <div class="modal-body">

                            <div class="row">

                               <div class="col-md-6 mb-3">
    @php
        $subjectNames = array_keys(require storage_path('app/notes.php'));
    @endphp

    <label>Subject Name</label>

    <input
        type="text"
        name="subjectName"
        class="form-control"
        placeholder="Enter subject name"
        list="subjectList"
        autocomplete="off"
        value="{{ old('subjectName') }}"
        required>

    <datalist id="subjectList">
        @foreach($subjectNames as $subjectName)
            <option value="{{ $subjectName }}"></option>
        @endforeach
    </datalist>
</div>

                                <div class="col-md-6 mb-3">

                                    <label>Subject Code</label>

                                    <input type="text"
                                        name="subjectCode"
                                        class="form-control"
                                        placeholder="Enter subject code">

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label>Class Room</label>

                                    <select name="class_room_id"
                                        class="form-control">

                                        <option value="">
                                            Select Class
                                        </option>

                                        @foreach ($classes as $class)

                                            <option value="{{ $class->id }}">
                                                {{ $class->class_name }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                                <div class="col-md-6 mb-3">

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

                            </div>

                        </div>

                        <div class="modal-footer">

                            <button class="btn btn-success">
                                Save Subject
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

        <!-- Table -->
        <div class="accordion" id="classAccordion">

@forelse($subjects as $classId => $classSubjects)

    @php
        $className = $classSubjects->first()->classRoom->class_name ?? 'Unknown Class';
    @endphp

    <div class="accordion-item mb-2">
        <h2 class="accordion-header" id="heading{{ $classId }}">
            <button class="accordion-button collapsed" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapse{{ $classId }}">

                {{ $className }}
                <span class="badge bg-primary ms-2">
                    {{ $classSubjects->count() }} Subjects
                </span>

            </button>
        </h2>

        <div id="collapse{{ $classId }}" class="accordion-collapse collapse"
             data-bs-parent="#classAccordion">

            <div class="accordion-body">

                <table class="table table-sm table-hover">
    <thead class="bg-secondary text-white">
        <tr>
            <th>S/N</th>
            <th>Subject Name</th>
            <th>Subject Code</th>
            <th>Teacher</th>
            <th width="150">Action</th>
        </tr>
    </thead>

    <tbody>
    @foreach($classSubjects as $index => $subject)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $subject->subjectName }}</td>
            <td>{{ $subject->subjectCode }}</td>
            <td>
                {{ $subject->teacher->firstname ?? '' }}
                {{ $subject->teacher->lastname ?? '' }}
            </td>

            <td>

                <!-- Edit -->
                <button class="btn btn-primary btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#editSubject{{ $subject->id }}">
                    <i class="bi bi-pencil-square"></i>
                </button>

                <!-- Delete -->
                <button class="btn btn-danger btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteSubject{{ $subject->id }}">
                    <i class="bi bi-trash"></i>
                </button>

            </td>
        </tr>

        <!-- ================= EDIT MODAL ================= -->

        <div class="modal fade" id="editSubject{{ $subject->id }}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <form action="{{ route('subject.update',$subject->id) }}"
                          method="POST">

                        @csrf
                        @method('PUT')

                        <div class="modal-header bg-primary text-white">
                            <h5>Edit Subject</h5>

                            <button class="btn-close"
                                    data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label>Subject Name</label>
                                    <input type="text"
                                           name="subjectName"
                                           class="form-control"
                                           value="{{ $subject->subjectName }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Subject Code</label>
                                    <input type="text"
                                           name="subjectCode"
                                           class="form-control"
                                           value="{{ $subject->subjectCode }}">
                                </div>

                                <div class="col-md-6 mb-3">

                                    <label>Class</label>

                                    <select name="class_room_id"
                                            class="form-control">

                                        @foreach($classes as $class)

                                            <option value="{{ $class->id }}"
                                                {{ $subject->class_room_id==$class->id ? 'selected':'' }}>

                                                {{ $class->class_name }}

                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label>Teacher</label>

                                    <select name="teacher_id"
                                            class="form-control">

                                        @foreach($teachers as $teacher)

                                            <option value="{{ $teacher->id }}"
                                                {{ $subject->teacher_id==$teacher->id ? 'selected':'' }}>

                                                {{ $teacher->firstname }}
                                                {{ $teacher->lastname }}

                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>

                        </div>

                        <div class="modal-footer">

                            <button class="btn btn-success">
                                Update Subject
                            </button>

                        </div>

                    </form>

                </div>
            </div>
        </div>

        <!-- ================= DELETE MODAL ================= -->

        <div class="modal fade"
             id="deleteSubject{{ $subject->id }}">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header bg-danger text-white">

                        <h5>Delete Subject</h5>

                        <button class="btn-close"
                                data-bs-dismiss="modal"></button>

                    </div>

                    <div class="modal-body">

                        <h5>
                            Are you sure you want to delete
                            <b>{{ $subject->subjectName }}</b> ?
                        </h5>

                    </div>

                    <div class="modal-footer">

                        <button class="btn btn-secondary"
                                data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <form action="{{ route('subject.destroy',$subject->id) }}"
                              method="POST">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger">
                                Delete
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    @endforeach
    </tbody>

</table>

            </div>
        </div>
    </div>

@empty
    <p class="text-center">No subjects found</p>
@endforelse

</div>

    </div>

</div>
@if(session('success') || session('error'))

<div class="modal fade" id="successModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content text-center">

            @if(session('success'))

                <div class="modal-body p-5">

                    <i class="fas fa-check-circle text-success"
                       style="font-size:80px;"></i>

                    <h3 class="mt-3 text-success">
                        Success
                    </h3>

                    <p style="color:green">
                        {{ session('success') }}
                    </p>

                    <button type="button"
                            class="btn btn-success"
                            data-bs-dismiss="modal">
                        OK
                    </button>

                </div>

            @endif

            @if(session('error') || $errors->any())

<div class="modal-body p-5">

    <i class="fas fa-times-circle text-danger"
       style="font-size:80px;"></i>

    <h3 class="mt-3 text-danger">
        Failed
    </h3>

    @if(session('error'))
        <p style="color:red">
            {{ session('error') }}
        </p>
    @endif

    @if($errors->any())
        <ul class="text-danger text-start">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <button type="button"
            class="btn btn-danger"
            data-bs-dismiss="modal">
        OK
    </button>

</div>

@endif

        </div>

    </div>

</div>

@endif
@if(session('success') || session('error'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    let modal = new bootstrap.Modal(
        document.getElementById('successModal')
    );
    modal.show();
});
</script>
@endif
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
@endsection