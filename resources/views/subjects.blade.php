@extends("layout.app")

@section("content")

<div class="content" id="content">

    <div class="table-container">

        <!-- Add Subject Button -->
        <button class="btn btn-primary mb-3"
            data-bs-toggle="modal"
            data-bs-target="#addSubjectModal">

            + Add Subject

        </button>

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

                                    <label>Subject Name</label>

                                    <input type="text"
                                        name="subjectName"
                                        class="form-control"
                                        placeholder="Enter subject name">

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
        <table class="table table-sm table-hover">

            <thead class="bg-secondary text-white">

                <tr>

                    <th>S/N</th>
                    <th>Subject Name</th>
                    <th>Subject Code</th>
                    <th>Class</th>
                    <th>Teacher</th>
                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

                @forelse ($subjects as $index => $subject)

                    <tr>

                        <td>{{ $index + 1 }}</td>

                        <td>{{ $subject->subjectName }}</td>

                        <td>{{ $subject->subjectCode }}</td>

                        <td>{{ $subject->classRoom->class_name }}</td>

                        <td>
                            {{ $subject->teacher->firstname }}
                            {{ $subject->teacher->lastname }}
                        </td>

                        <td>

                            <!-- Edit -->
                            <button class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#editSubjectModal{{ $subject->id }}">

                                <i class="bi bi-pencil-square"></i>

                            </button>

                            <!-- Delete -->
                            <form action="{{ route('subject.destroy', $subject->id) }}"
                                method="POST"
                                style="display:inline-block;">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this subject?')">

                                    Delete

                                </button>

                            </form>

                            <!-- Edit Modal -->
                            <div class="modal fade"
                                id="editSubjectModal{{ $subject->id }}">

                                <div class="modal-dialog modal-xl">

                                    <div class="modal-content">

                                        <div class="modal-header bg-primary text-white">

                                            <h5>Edit Subject</h5>

                                            <button class="btn-close"
                                                data-bs-dismiss="modal"></button>

                                        </div>

                                        <form action="{{ route('subject.update', $subject->id) }}"
                                            method="POST">

                                            @csrf
                                            @method('PUT')

                                            <div class="modal-body">

                                                <div class="row">

                                                    <div class="col-md-6 mb-3">

                                                        <label>Subject Name</label>

                                                        <input type="text"
                                                            name="subjectName"
                                                            value="{{ $subject->subjectName }}"
                                                            class="form-control">

                                                    </div>

                                                    <div class="col-md-6 mb-3">

                                                        <label>Subject Code</label>

                                                        <input type="text"
                                                            name="subjectCode"
                                                            value="{{ $subject->subjectCode }}"
                                                            class="form-control">

                                                    </div>

                                                </div>

                                                <div class="row">

                                                    <div class="col-md-6 mb-3">

                                                        <label>Class Room</label>

                                                        <select name="class_room_id"
                                                            class="form-control">

                                                            @foreach ($classes as $class)

                                                                <option value="{{ $class->id }}"
                                                                    {{ $subject->class_room_id == $class->id ? 'selected' : '' }}>

                                                                    {{ $class->class_name }}

                                                                </option>

                                                            @endforeach

                                                        </select>

                                                    </div>

                                                    <div class="col-md-6 mb-3">

                                                        <label>Teacher</label>

                                                        <select name="teacher_id"
                                                            class="form-control">

                                                            @foreach ($teachers as $teacher)

                                                                <option value="{{ $teacher->id }}"
                                                                    {{ $subject->teacher_id == $teacher->id ? 'selected' : '' }}>

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
                                                    Update
                                                </button>

                                            </div>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" style="text-align: center">No Record Found</td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
@endsection