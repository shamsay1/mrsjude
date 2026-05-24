@extends("layout.app")

@section("content")

<div class="content" id="content">

    <div class="table-container">

        <!-- Add Class Button -->
        <button class="btn btn-primary mb-3"
            data-bs-toggle="modal"
            data-bs-target="#addClassModal">

            + Add Class

        </button>

        <!-- Add Modal -->
        <div class="modal fade" id="addClassModal" tabindex="-1">

            <div class="modal-dialog modal-lg">

                <div class="modal-content" style="border-radius:12px;">

                    <div class="modal-header bg-primary text-white">

                        <h5 class="modal-title">Add Class</h5>

                        <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"></button>

                    </div>

                    <form action="{{ route('school-class.store') }}"
                        method="POST">

                        @csrf

                        <div class="modal-body">

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label>Class Name</label>

                                    <input type="text"
                                        name="class_name"
                                        class="form-control"
                                        placeholder="Enter class name">

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label>Class Level</label>

                                    <input type="text"
                                        name="class_level"
                                        class="form-control"
                                        placeholder="Enter class level">

                                </div>

                            </div>

                          

                        </div>

                        <div class="modal-footer">

                            <button class="btn btn-success">
                                Save Class
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
                    <th>Class Name</th>
                    <th>Class Level</th>
                    <th>School</th>
                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

                @forelse ($classes as $index => $class)

                    <tr>

                        <td>{{ $index + 1 }}</td>

                        <td>{{ $class->class_name }}</td>

                        <td>{{ $class->class_level }}</td>

                        <td>{{ $class->school->school_name }}</td>

                        <td>

                            <!-- Edit Button -->
                            <button class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#editClassModal{{ $class->id }}">

                                <i class="bi bi-pencil-square"></i>

                            </button>

                            <!-- Delete -->
                            <form action="{{ route('school-class.destroy', $class->id) }}"
                                method="POST"
                                style="display:inline-block;">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this class?')">

                                    Delete

                                </button>

                            </form>

                            <!-- Edit Modal -->
                            <div class="modal fade"
                                id="editClassModal{{ $class->id }}">

                                <div class="modal-dialog modal-lg">

                                    <div class="modal-content">

                                        <div class="modal-header bg-primary text-white">

                                            <h5>Edit Class</h5>

                                            <button class="btn-close"
                                                data-bs-dismiss="modal"></button>

                                        </div>

                                        <form action="{{ route('school-class.update', $class->id) }}"
                                            method="POST">

                                            @csrf
                                            @method('PUT')

                                            <div class="modal-body">

                                                <div class="row">

                                                    <div class="col-md-6 mb-3">

                                                        <label>Class Name</label>

                                                        <input type="text"
                                                            name="class_name"
                                                            value="{{ $class->class_name }}"
                                                            class="form-control">

                                                    </div>

                                                    <div class="col-md-6 mb-3">

                                                        <label>Class Level</label>

                                                        <input type="text"
                                                            name="class_level"
                                                            value="{{ $class->class_level }}"
                                                            class="form-control">

                                                    </div>

                                                </div>

                                                <div class="row">

                                                    <div class="col-md-12 mb-3">

                                                        <label>School</label>

                                                        <select name="school_id"
                                                            class="form-control">

                                                            @foreach ($schools as $school)

                                                                <option value="{{ $school->id }}"
                                                                    {{ $class->school_id == $school->id ? 'selected' : '' }}>

                                                                    {{ $school->school_name }}

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
                        <td colspan="5" style="text-align: center">No Record Found</td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
@endsection