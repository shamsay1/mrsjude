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
                            <th>Action</th>
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
                                </td>
                            </tr>
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
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
@endsection